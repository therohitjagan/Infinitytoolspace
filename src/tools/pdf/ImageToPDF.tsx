import { PDFDocument } from 'pdf-lib'
import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'
import FileUpload from '../../components/ui/FileUpload'
import ProgressBar from '../../components/ui/ProgressBar'

function ImageToPDF() {
  const [files, setFiles] = useState<File[]>([])
  const [output, setOutput] = useState<Blob | null>(null)
  const [progress, setProgress] = useState(0)

  const previews = useMemo(() => files.map((file) => ({ file, url: URL.createObjectURL(file) })), [files])

  async function convert() {
    if (!files.length) return
    setProgress(10)
    const pdf = await PDFDocument.create()

    for (const [index, file] of files.entries()) {
      const bytes = new Uint8Array(await file.arrayBuffer())
      const isJpeg = file.type.includes('jpeg') || file.type.includes('jpg')
      const embedded = isJpeg ? await pdf.embedJpg(bytes) : await pdf.embedPng(bytes)
      const page = pdf.addPage([embedded.width, embedded.height])
      page.drawImage(embedded, { x: 0, y: 0, width: embedded.width, height: embedded.height })
      setProgress(Math.round(((index + 1) / files.length) * 85))
    }

    const saved = await pdf.save()
    const arr = new Uint8Array(saved.byteLength)
    arr.set(saved)
    setOutput(new Blob([arr.buffer], { type: 'application/pdf' }))
    setProgress(100)
  }

  function download() {
    if (!output) return
    const url = URL.createObjectURL(output)
    const link = document.createElement('a')
    link.href = url
    link.download = 'images.pdf'
    link.click()
    URL.revokeObjectURL(url)
  }

  return (
    <Card className="space-y-3">
      <FileUpload
        files={files}
        onFilesChange={(next) => {
          setFiles(next)
          setOutput(null)
          setProgress(0)
        }}
        accept="image/png,image/jpeg,image/webp"
        multiple
        maxFiles={20}
        maxFileSizeMB={20}
        label="Add images to convert"
      />
      <p className="text-xs text-its-text-secondary">Selected: {files.length}</p>
      <div className="flex gap-2">
        <Button onClick={convert} disabled={!files.length}>Convert</Button>
        <Button variant="secondary" onClick={download} disabled={!output}>Download PDF</Button>
      </div>
      {progress > 0 ? <ProgressBar value={progress} label="Converting images" /> : null}
      {previews.length ? (
        <div className="grid grid-cols-2 gap-2 sm:grid-cols-4">
          {previews.map((item) => (
            <img key={`${item.file.name}-${item.file.size}`} src={item.url} alt={item.file.name} className="h-24 w-full rounded-lg object-cover" />
          ))}
        </div>
      ) : null}
    </Card>
  )
}

export default ImageToPDF
