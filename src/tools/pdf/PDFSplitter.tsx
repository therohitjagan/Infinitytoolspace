import { PDFDocument } from 'pdf-lib'
import { useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'
import FileUpload from '../../components/ui/FileUpload'
import ProgressBar from '../../components/ui/ProgressBar'

function PDFSplitter() {
  const [file, setFile] = useState<File | null>(null)
  const [range, setRange] = useState('1-1')
  const [output, setOutput] = useState<Blob | null>(null)
  const [progress, setProgress] = useState(0)

  async function split() {
    if (!file) return
    setProgress(10)
    const source = await PDFDocument.load(await file.arrayBuffer())
    setProgress(35)
    const [startRaw, endRaw] = range.split('-').map((value) => Number.parseInt(value.trim(), 10))
    const start = Math.max(1, Number.isFinite(startRaw) ? startRaw : 1)
    const end = Math.max(start, Number.isFinite(endRaw) ? endRaw : start)
    const doc = await PDFDocument.create()
    const indices = source.getPageIndices().filter((index) => index + 1 >= start && index + 1 <= end)
    const pages = await doc.copyPages(source, indices)
    pages.forEach((page) => doc.addPage(page))
    setProgress(80)
    const bytes = await doc.save()
    const arr = new Uint8Array(bytes.byteLength)
    arr.set(bytes)
    setOutput(new Blob([arr.buffer], { type: 'application/pdf' }))
    setProgress(100)
  }

  function download() {
    if (!output) return
    const url = URL.createObjectURL(output)
    const link = document.createElement('a')
    link.href = url
    link.download = 'split.pdf'
    link.click()
    URL.revokeObjectURL(url)
  }

  return (
    <Card className="space-y-3">
      <FileUpload
        files={file ? [file] : []}
        onFilesChange={(next) => {
          setFile(next[0] ?? null)
          setOutput(null)
          setProgress(0)
        }}
        accept="application/pdf"
        label="Upload one PDF"
        maxFileSizeMB={60}
      />
      <input value={range} onChange={(event) => setRange(event.target.value)} placeholder="1-3" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2 text-sm" />
      <div className="flex gap-2">
        <Button onClick={split} disabled={!file}>Split</Button>
        <Button variant="secondary" onClick={download} disabled={!output}>Download</Button>
      </div>
      {progress > 0 ? <ProgressBar value={progress} label="Splitting progress" /> : null}
    </Card>
  )
}

export default PDFSplitter
