import { PDFDocument } from 'pdf-lib'
import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'
import FileUpload from '../../components/ui/FileUpload'
import ProgressBar from '../../components/ui/ProgressBar'

function PDFMerger() {
  const [files, setFiles] = useState<File[]>([])
  const [isMerging, setIsMerging] = useState(false)
  const [progress, setProgress] = useState(0)
  const [mergedBlob, setMergedBlob] = useState<Blob | null>(null)

  const mergedSizeLabel = useMemo(() => {
    if (!mergedBlob) {
      return null
    }

    return `${(mergedBlob.size / 1024 / 1024).toFixed(2)} MB`
  }, [mergedBlob])

  async function mergePDFs() {
    if (files.length < 2) {
      return
    }

    setIsMerging(true)

    try {
      const mergedPdf = await PDFDocument.create()
      setProgress(5)

      for (const [index, file] of files.entries()) {
        const buffer = await file.arrayBuffer()
        const sourcePdf = await PDFDocument.load(buffer)
        const pages = await mergedPdf.copyPages(sourcePdf, sourcePdf.getPageIndices())
        pages.forEach((page) => mergedPdf.addPage(page))
        setProgress(Math.round(((index + 1) / files.length) * 85))
      }

      const mergedBytes = await mergedPdf.save()
      const outputBytes = new Uint8Array(mergedBytes.byteLength)
      outputBytes.set(mergedBytes)
      const output = new Blob([outputBytes.buffer], { type: 'application/pdf' })
      setMergedBlob(output)
      setProgress(100)
    } finally {
      setIsMerging(false)
    }
  }

  function downloadMergedPDF() {
    if (!mergedBlob) {
      return
    }

    const url = URL.createObjectURL(mergedBlob)
    const link = document.createElement('a')
    link.href = url
    link.download = 'merged.pdf'
    link.click()
    URL.revokeObjectURL(url)
  }

  return (
    <div className="space-y-4">
      <Card className="space-y-3">
        <p className="text-sm text-its-text-secondary">
          Upload 2+ PDF files and merge them in order directly in your browser.
        </p>
        <FileUpload
          files={files}
          onFilesChange={(next) => {
            setFiles(next)
            setMergedBlob(null)
            setProgress(0)
          }}
          accept="application/pdf"
          multiple
          maxFiles={20}
          maxFileSizeMB={60}
          label="Add PDF files"
        />
        <p className="text-xs text-its-text-secondary">Selected files: {files.length}</p>
        <div className="flex flex-wrap gap-2">
          <Button onClick={mergePDFs} isLoading={isMerging} disabled={files.length < 2}>
            Merge PDFs
          </Button>
          <Button variant="secondary" onClick={downloadMergedPDF} disabled={!mergedBlob}>
            Download merged PDF
          </Button>
        </div>
        {isMerging || progress > 0 ? (
          <ProgressBar value={progress} label="Merging progress" />
        ) : null}
        {mergedSizeLabel ? (
          <p className="text-xs text-its-status-success">Output ready • {mergedSizeLabel}</p>
        ) : null}
      </Card>
    </div>
  )
}

export default PDFMerger
