import * as pdfjsLib from 'pdfjs-dist'
import { useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'
import FileUpload from '../../components/ui/FileUpload'
import ProgressBar from '../../components/ui/ProgressBar'

pdfjsLib.GlobalWorkerOptions.workerSrc = new URL('pdfjs-dist/build/pdf.worker.min.mjs', import.meta.url).toString()

type ConvertedImage = {
  page: number
  png: string
  jpg: string
  width: number
  height: number
}

function PDFToImageTool() {
  const [file, setFile] = useState<File | null>(null)
  const [progress, setProgress] = useState(0)
  const [images, setImages] = useState<ConvertedImage[]>([])
  const [info, setInfo] = useState('Upload a PDF to convert pages to downloadable images.')
  const [scale, setScale] = useState(1.75)

  function download(url: string, filename: string) {
    const link = document.createElement('a')
    link.href = url
    link.download = filename
    link.click()
  }

  function downloadAll(format: 'png' | 'jpg') {
    images.forEach((item) => {
      const data = format === 'png' ? item.png : item.jpg
      download(data, `page-${item.page}.${format}`)
    })
  }

  async function handle(file: File) {
    setProgress(8)
    const bytes = await file.arrayBuffer()
    const loadingTask = pdfjsLib.getDocument({ data: bytes })
    const pdf = await loadingTask.promise
    const converted: ConvertedImage[] = []

    for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber += 1) {
      const page = await pdf.getPage(pageNumber)
      const viewport = page.getViewport({ scale })
      const canvas = document.createElement('canvas')
      const context = canvas.getContext('2d', { alpha: false })
      if (!context) continue

      canvas.width = Math.ceil(viewport.width)
      canvas.height = Math.ceil(viewport.height)
      await page.render({ canvas: canvas as HTMLCanvasElement, canvasContext: context, viewport }).promise

      converted.push({
        page: pageNumber,
        png: canvas.toDataURL('image/png'),
        jpg: canvas.toDataURL('image/jpeg', 0.92),
        width: canvas.width,
        height: canvas.height,
      })

      setProgress(Math.round((pageNumber / pdf.numPages) * 100))
    }

    setImages(converted)
    setInfo(`Converted ${converted.length} page(s). Use per-page or bulk download.`)
  }

  return (
    <Card className="space-y-3">
      <label className="block space-y-2 text-sm text-its-text-secondary">
        Quality Scale: {scale.toFixed(2)}x
        <input
          type="range"
          min={1}
          max={3}
          step={0.25}
          value={scale}
          onChange={(event) => setScale(Number(event.target.value))}
          className="w-full"
        />
      </label>

      <FileUpload
        files={file ? [file] : []}
        onFilesChange={(next) => {
          const selected = next[0] ?? null
          setFile(selected)
          setImages([])
          setProgress(0)
          setInfo('Upload a PDF to convert pages to downloadable images.')
          if (selected) {
            void handle(selected)
          }
        }}
        accept="application/pdf"
        label="Upload one PDF"
        maxFileSizeMB={60}
      />
      {progress > 0 ? <ProgressBar value={progress} label="Converting pages" /> : null}
      <p className="text-sm text-its-text-secondary">{info}</p>
      {images.length ? (
        <>
          <div className="flex flex-wrap gap-2">
            <Button onClick={() => downloadAll('png')}>Download all PNG</Button>
            <Button variant="secondary" onClick={() => downloadAll('jpg')}>
              Download all JPG
            </Button>
          </div>
          <div className="grid gap-3 sm:grid-cols-2">
            {images.map((item) => (
              <div key={item.page} className="space-y-2 rounded-xl border border-white/15 p-3">
                <p className="text-xs text-its-text-secondary">
                  Page {item.page} • {item.width} × {item.height}
                </p>
                <img src={item.png} alt={`Page ${item.page}`} className="max-h-64 w-full rounded-lg object-contain" />
                <div className="flex gap-2">
                  <Button variant="ghost" onClick={() => download(item.png, `page-${item.page}.png`)}>
                    PNG
                  </Button>
                  <Button variant="ghost" onClick={() => download(item.jpg, `page-${item.page}.jpg`)}>
                    JPG
                  </Button>
                </div>
              </div>
            ))}
          </div>
        </>
      ) : (
        <div className="rounded-xl border border-dashed border-white/15 p-5 text-center text-xs text-its-text-secondary">
          Converted pages will appear here with direct download buttons.
        </div>
      )}
    </Card>
  )
}

export default PDFToImageTool
