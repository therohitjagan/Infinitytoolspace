import { PDFDocument } from 'pdf-lib'
import { useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'
import FileUpload from '../../components/ui/FileUpload'
import ProgressBar from '../../components/ui/ProgressBar'

function PDFCompressor() {
  const [file, setFile] = useState<File | null>(null)
  const [result, setResult] = useState<Blob | null>(null)
  const [stats, setStats] = useState<string>('')
  const [progress, setProgress] = useState(0)

  async function compress() {
    if (!file) return
    setProgress(10)
    const sourceBytes = await file.arrayBuffer()
    const sourceSize = sourceBytes.byteLength
    const pdf = await PDFDocument.load(sourceBytes)
    setProgress(50)
    pdf.setTitle(pdf.getTitle() ?? '')
    const saved = await pdf.save({ useObjectStreams: true })
    const arr = new Uint8Array(saved.byteLength)
    arr.set(saved)
    const blob = new Blob([arr.buffer], { type: 'application/pdf' })
    setResult(blob)
    const ratio = ((1 - blob.size / sourceSize) * 100).toFixed(1)
    setStats(`Original ${(sourceSize / 1024).toFixed(1)}KB → ${(blob.size / 1024).toFixed(1)}KB (${ratio}% reduction)`)
    setProgress(100)
  }

  function download() {
    if (!result) return
    const url = URL.createObjectURL(result)
    const link = document.createElement('a')
    link.href = url
    link.download = 'compressed.pdf'
    link.click()
    URL.revokeObjectURL(url)
  }

  return (
    <Card className="space-y-3">
      <FileUpload
        files={file ? [file] : []}
        onFilesChange={(next) => {
          setFile(next[0] ?? null)
          setResult(null)
          setStats('')
          setProgress(0)
        }}
        accept="application/pdf"
        label="Upload one PDF"
        maxFileSizeMB={60}
      />
      <div className="flex gap-2">
        <Button onClick={compress} disabled={!file}>Compress</Button>
        <Button variant="secondary" onClick={download} disabled={!result}>Download</Button>
      </div>
      {progress > 0 ? <ProgressBar value={progress} label="Compression progress" /> : null}
      {stats ? <p className="text-xs text-its-text-secondary">{stats}</p> : null}
    </Card>
  )
}

export default PDFCompressor
