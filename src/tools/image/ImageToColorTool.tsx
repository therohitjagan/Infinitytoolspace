import { useMemo, useRef, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'
import FileUpload from '../../components/ui/FileUpload'
import ProgressBar from '../../components/ui/ProgressBar'

type Swatch = { hex: string; count: number }

function toHex(value: number) {
  return Math.round(value).toString(16).padStart(2, '0')
}

function rgbToHex(r: number, g: number, b: number) {
  return `#${toHex(r)}${toHex(g)}${toHex(b)}`
}

function ImageToColorTool() {
  const [file, setFile] = useState<File | null>(null)
  const [dominant, setDominant] = useState<string>('')
  const [hoverColor, setHoverColor] = useState<string>('')
  const [hoverPosition, setHoverPosition] = useState<{ x: number; y: number } | null>(null)
  const [hoverZoomUrl, setHoverZoomUrl] = useState<string>('')
  const [preview, setPreview] = useState<string>('')
  const [progress, setProgress] = useState(0)
  const [swatches, setSwatches] = useState<Swatch[]>([])
  const canvasRef = useRef<HTMLCanvasElement | null>(null)
  const imageElementRef = useRef<HTMLImageElement | null>(null)

  const averageInfo = useMemo(() => {
    if (!dominant) return ''
    return `Average color: ${dominant}`
  }, [dominant])

  async function handleFile(file: File) {
    setProgress(10)
    const bitmap = await createImageBitmap(file)
    const canvas = document.createElement('canvas')
    canvas.width = bitmap.width
    canvas.height = bitmap.height
    const context = canvas.getContext('2d')
    if (!context) return
    context.drawImage(bitmap, 0, 0)
    const data = context.getImageData(0, 0, canvas.width, canvas.height).data
    let r = 0
    let g = 0
    let b = 0
    const buckets = new Map<string, number>()
    const count = data.length / 4
    for (let index = 0; index < data.length; index += 4) {
      const red = data[index]
      const green = data[index + 1]
      const blue = data[index + 2]
      r += red
      g += green
      b += blue

      const keyR = Math.floor(red / 16) * 16
      const keyG = Math.floor(green / 16) * 16
      const keyB = Math.floor(blue / 16) * 16
      const bucket = rgbToHex(keyR, keyG, keyB)
      buckets.set(bucket, (buckets.get(bucket) ?? 0) + 1)
    }
    setProgress(85)
    setDominant(rgbToHex(r / count, g / count, b / count))

    const topSwatches = [...buckets.entries()]
      .sort((first, second) => second[1] - first[1])
      .slice(0, 36)
      .map(([hex, value]) => ({ hex, count: value }))
    setSwatches(topSwatches)

    if (canvasRef.current) {
      canvasRef.current.width = bitmap.width
      canvasRef.current.height = bitmap.height
      const context2d = canvasRef.current.getContext('2d')
      if (context2d) {
        context2d.drawImage(bitmap, 0, 0)
      }
    }

    setPreview(URL.createObjectURL(file))
    setProgress(100)
  }

  function handleHover(event: React.MouseEvent<HTMLImageElement>) {
    const imageElement = imageElementRef.current
    const canvas = canvasRef.current
    if (!imageElement || !canvas) return

    const rect = imageElement.getBoundingClientRect()
    const xRatio = canvas.width / rect.width
    const yRatio = canvas.height / rect.height
    const x = Math.max(0, Math.min(canvas.width - 1, Math.floor((event.clientX - rect.left) * xRatio)))
    const y = Math.max(0, Math.min(canvas.height - 1, Math.floor((event.clientY - rect.top) * yRatio)))

    const context2d = canvas.getContext('2d')
    if (!context2d) return
    const pixel = context2d.getImageData(x, y, 1, 1).data
    setHoverColor(rgbToHex(pixel[0], pixel[1], pixel[2]))
    setHoverPosition({ x: event.clientX - rect.left, y: event.clientY - rect.top })

    const zoomCanvas = document.createElement('canvas')
    zoomCanvas.width = 120
    zoomCanvas.height = 120
    const zoomContext = zoomCanvas.getContext('2d')
    if (zoomContext) {
      zoomContext.imageSmoothingEnabled = false
      zoomContext.drawImage(canvas, Math.max(0, x - 6), Math.max(0, y - 6), 12, 12, 0, 0, 120, 120)
      zoomContext.strokeStyle = '#ffffff'
      zoomContext.lineWidth = 1
      zoomContext.strokeRect(55, 55, 10, 10)
      setHoverZoomUrl(zoomCanvas.toDataURL('image/png'))
    }
  }

  return (
    <Card className="space-y-4">
      <FileUpload
        files={file ? [file] : []}
        onFilesChange={(next) => {
          const selected = next[0] ?? null
          setFile(selected)
          setDominant('')
          setHoverColor('')
          setHoverPosition(null)
          setHoverZoomUrl('')
          setPreview('')
          setProgress(0)
          setSwatches([])
          if (selected) {
            void handleFile(selected)
          }
        }}
        accept="image/png,image/jpeg,image/webp"
        label="Upload one image"
        maxFileSizeMB={25}
      />
      {progress > 0 ? <ProgressBar value={progress} label="Extracting color profile" /> : null}
      <canvas ref={canvasRef} className="hidden" />

      {preview ? (
        <div className="relative inline-block">
          <img
            ref={imageElementRef}
            src={preview}
            alt="Preview"
            className="max-h-72 rounded-xl"
            onMouseMove={handleHover}
            onMouseLeave={() => setHoverPosition(null)}
          />
          {hoverPosition && hoverZoomUrl ? (
            <div
              className="pointer-events-none absolute z-10 rounded-xl border border-white/20 bg-its-bg-secondary/90 p-2"
              style={{ left: Math.min(hoverPosition.x + 20, 360), top: Math.max(hoverPosition.y - 150, 8) }}
            >
              <img src={hoverZoomUrl} alt="Magnifier" className="h-24 w-24 rounded-lg border border-white/15" />
              <p className="mt-1 text-xs text-its-text-secondary">{hoverColor || 'Hover image'}</p>
            </div>
          ) : null}
        </div>
      ) : null}

      {averageInfo ? (
        <div className="rounded-xl border border-white/15 p-3 text-sm">
          {averageInfo} {hoverColor ? `• Hover pixel: ${hoverColor}` : ''}
        </div>
      ) : null}

      {swatches.length ? (
        <div className="space-y-2">
          <p className="text-xs text-its-text-secondary">Detected color set (tap to copy)</p>
          <div className="grid grid-cols-3 gap-2 sm:grid-cols-6 lg:grid-cols-9">
            {swatches.map((item) => (
              <button
                key={item.hex}
                className="focus-ring rounded-lg border border-white/15 p-1"
                onClick={() => navigator.clipboard.writeText(item.hex)}
                title={`${item.hex} (${item.count} px)`}
              >
                <span className="block h-8 rounded" style={{ backgroundColor: item.hex }} />
                <span className="mt-1 block text-[10px] text-its-text-secondary">{item.hex}</span>
              </button>
            ))}
          </div>
          <Button variant="secondary" onClick={() => navigator.clipboard.writeText(swatches.map((s) => s.hex).join(', '))}>
            Copy all colors
          </Button>
        </div>
      ) : null}
    </Card>
  )
}

export default ImageToColorTool
