import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'
import FileUpload from '../../components/ui/FileUpload'
import ProgressBar from '../../components/ui/ProgressBar'

function ImageResizerTool() {
  const [file, setFile] = useState<File | null>(null)
  const [width, setWidth] = useState(1080)
  const [height, setHeight] = useState(1080)
  const [result, setResult] = useState<string>('')
  const [progress, setProgress] = useState(0)

  const preview = useMemo(() => (file ? URL.createObjectURL(file) : ''), [file])

  async function resize() {
    if (!file) return
    setProgress(10)
    const bitmap = await createImageBitmap(file)
    const canvas = document.createElement('canvas')
    canvas.width = width
    canvas.height = height
    const context = canvas.getContext('2d')
    if (!context) return
    context.drawImage(bitmap, 0, 0, width, height)
    setProgress(70)
    setResult(canvas.toDataURL('image/png'))
    setProgress(100)
  }

  return (
    <Card className="space-y-4">
      <FileUpload
        files={file ? [file] : []}
        onFilesChange={(next) => {
          setFile(next[0] ?? null)
          setResult('')
          setProgress(0)
        }}
        accept="image/png,image/jpeg,image/webp"
        label="Upload one image"
        maxFileSizeMB={25}
      />
      <div className="grid gap-3 sm:grid-cols-2">
        <input type="number" value={width} onChange={(event) => setWidth(Number(event.target.value))} className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2" />
        <input type="number" value={height} onChange={(event) => setHeight(Number(event.target.value))} className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2" />
      </div>
      <Button onClick={resize} disabled={!file}>Resize</Button>
      {progress > 0 ? <ProgressBar value={progress} label="Resizing image" /> : null}
      <div className="grid gap-3 sm:grid-cols-2">
        {preview ? <img src={preview} alt="Original" className="rounded-xl" /> : null}
        {result ? <img src={result} alt="Resized" className="rounded-xl" /> : null}
      </div>
    </Card>
  )
}

export default ImageResizerTool
