import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'
import FileUpload from '../../components/ui/FileUpload'
import ProgressBar from '../../components/ui/ProgressBar'

function ImageCompressor() {
  const [file, setFile] = useState<File | null>(null)
  const [quality, setQuality] = useState(80)
  const [maxWidth, setMaxWidth] = useState(1600)
  const [isProcessing, setIsProcessing] = useState(false)
  const [progress, setProgress] = useState(0)
  const [resultBlob, setResultBlob] = useState<Blob | null>(null)

  const previewUrl = useMemo(() => (file ? URL.createObjectURL(file) : null), [file])
  const outputSize = resultBlob ? `${(resultBlob.size / 1024).toFixed(1)} KB` : null

  async function compressImage() {
    if (!file) {
      return
    }

    setIsProcessing(true)
    setProgress(10)

    try {
      const bitmap = await createImageBitmap(file)
      const scale = Math.min(1, maxWidth / bitmap.width)
      const width = Math.max(1, Math.floor(bitmap.width * scale))
      const height = Math.max(1, Math.floor(bitmap.height * scale))

      const canvas = document.createElement('canvas')
      canvas.width = width
      canvas.height = height
      const context = canvas.getContext('2d')

      if (!context) {
        return
      }

      context.drawImage(bitmap, 0, 0, width, height)
      setProgress(60)

      const blob = await new Promise<Blob | null>((resolve) => {
        canvas.toBlob(resolve, 'image/jpeg', quality / 100)
      })

      if (blob) {
        setResultBlob(blob)
        setProgress(100)
      }
    } finally {
      setIsProcessing(false)
    }
  }

  function downloadImage() {
    if (!resultBlob) {
      return
    }

    const url = URL.createObjectURL(resultBlob)
    const link = document.createElement('a')
    link.href = url
    link.download = 'compressed.jpg'
    link.click()
    URL.revokeObjectURL(url)
  }

  return (
    <div className="space-y-4">
      <Card className="space-y-4">
        <FileUpload
          files={file ? [file] : []}
          onFilesChange={(next) => {
            setFile(next[0] ?? null)
            setResultBlob(null)
            setProgress(0)
          }}
          accept="image/png,image/jpeg,image/webp"
          label="Upload one image"
          maxFileSizeMB={25}
        />

        <div className="grid gap-4 sm:grid-cols-2">
          <label className="space-y-2 text-sm">
            <span className="text-its-text-secondary">Quality: {quality}%</span>
            <input
              type="range"
              min={20}
              max={100}
              value={quality}
              onChange={(event) => setQuality(Number(event.target.value))}
              className="w-full"
            />
          </label>

          <label className="space-y-2 text-sm">
            <span className="text-its-text-secondary">Max width: {maxWidth}px</span>
            <input
              type="range"
              min={400}
              max={2400}
              step={100}
              value={maxWidth}
              onChange={(event) => setMaxWidth(Number(event.target.value))}
              className="w-full"
            />
          </label>
        </div>

        <div className="flex flex-wrap gap-2">
          <Button onClick={compressImage} isLoading={isProcessing} disabled={!file}>
            Compress image
          </Button>
          <Button variant="secondary" onClick={downloadImage} disabled={!resultBlob}>
            Download result
          </Button>
        </div>
        {progress > 0 ? <ProgressBar value={progress} label="Compressing image" /> : null}
      </Card>

      {previewUrl ? (
        <Card className="space-y-2">
          <p className="text-sm text-its-text-secondary">Preview</p>
          <img src={previewUrl} alt="Selected" className="max-h-80 rounded-xl object-contain" />
          {outputSize ? <p className="text-xs text-its-status-success">Output size: {outputSize}</p> : null}
        </Card>
      ) : null}
    </div>
  )
}

export default ImageCompressor
