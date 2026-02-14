import { FileImage, FileText, Upload, X } from 'lucide-react'
import { useMemo, useRef, useState } from 'react'
import { cn } from '../../lib/utils'

interface FileUploadProps {
  files: File[]
  onFilesChange: (files: File[]) => void
  accept?: string
  multiple?: boolean
  maxFiles?: number
  maxFileSizeMB?: number
  label?: string
}

function formatBytes(size: number) {
  if (size < 1024) return `${size} B`
  if (size < 1024 * 1024) return `${(size / 1024).toFixed(1)} KB`
  return `${(size / 1024 / 1024).toFixed(2)} MB`
}

function FileUpload({
  files,
  onFilesChange,
  accept,
  multiple = false,
  maxFiles = 10,
  maxFileSizeMB = 25,
  label = 'Upload files',
}: FileUploadProps) {
  const inputRef = useRef<HTMLInputElement | null>(null)
  const [isDragActive, setIsDragActive] = useState(false)
  const [error, setError] = useState('')

  const acceptedMimeTypes = useMemo(
    () =>
      accept
        ?.split(',')
        .map((chunk) => chunk.trim())
        .filter(Boolean) ?? [],
    [accept],
  )

  function validate(nextFiles: File[]) {
    const maxBytes = maxFileSizeMB * 1024 * 1024

    if (!multiple && nextFiles.length > 1) {
      setError('Only one file is allowed for this tool.')
      return null
    }

    if (nextFiles.length > maxFiles) {
      setError(`Maximum ${maxFiles} file(s) allowed.`)
      return null
    }

    const tooLarge = nextFiles.find((file) => file.size > maxBytes)
    if (tooLarge) {
      setError(`${tooLarge.name} exceeds ${maxFileSizeMB}MB limit.`)
      return null
    }

    if (acceptedMimeTypes.length) {
      const invalid = nextFiles.find((file) => {
        return !acceptedMimeTypes.some((type) => {
          if (type.endsWith('/*')) {
            return file.type.startsWith(type.replace('/*', '/'))
          }

          return file.type === type
        })
      })

      if (invalid) {
        setError(`${invalid.name} has unsupported file type.`)
        return null
      }
    }

    setError('')
    return nextFiles
  }

  function setFromFileList(fileList: FileList | null) {
    const next = Array.from(fileList ?? [])
    const valid = validate(next)
    if (valid) {
      onFilesChange(valid)
    }
  }

  function removeFile(fileName: string) {
    onFilesChange(files.filter((file) => file.name !== fileName))
  }

  return (
    <div className="space-y-3">
      <div
        className={cn(
          'rounded-2xl border border-dashed border-white/20 bg-white/5 p-5 transition',
          isDragActive && 'border-its-accent-cyan bg-its-accent-cyan/10',
        )}
        onDragOver={(event) => {
          event.preventDefault()
          setIsDragActive(true)
        }}
        onDragLeave={() => setIsDragActive(false)}
        onDrop={(event) => {
          event.preventDefault()
          setIsDragActive(false)
          setFromFileList(event.dataTransfer.files)
        }}
      >
        <input
          ref={inputRef}
          type="file"
          accept={accept}
          multiple={multiple}
          className="hidden"
          onChange={(event) => setFromFileList(event.target.files)}
        />

        <div className="flex flex-col items-center justify-center gap-2 text-center">
          <Upload className="h-5 w-5 text-its-accent-cyan" />
          <p className="text-sm font-semibold">{label}</p>
          <p className="text-xs text-its-text-secondary">Drag & drop or click to browse files</p>
          <button
            type="button"
            className="focus-ring rounded-lg border border-its-accent-cyan/50 px-3 py-1 text-xs text-its-accent-cyan"
            onClick={() => inputRef.current?.click()}
          >
            Choose File{multiple ? 's' : ''}
          </button>
        </div>
      </div>

      {error ? <p className="text-xs text-its-status-error">{error}</p> : null}

      {files.length ? (
        <div className="space-y-2">
          {files.map((file) => {
            const isImage = file.type.startsWith('image/')
            return (
              <div key={`${file.name}-${file.size}`} className="flex items-center justify-between rounded-xl border border-white/15 bg-white/5 p-2.5">
                <div className="flex items-center gap-2">
                  {isImage ? <FileImage className="h-4 w-4 text-its-accent-cyan" /> : <FileText className="h-4 w-4 text-its-accent-cyan" />}
                  <div>
                    <p className="max-w-[220px] truncate text-sm">{file.name}</p>
                    <p className="text-[11px] text-its-text-secondary">{formatBytes(file.size)}</p>
                  </div>
                </div>
                <button
                  type="button"
                  className="focus-ring rounded-md border border-white/15 p-1"
                  onClick={() => removeFile(file.name)}
                  aria-label={`Remove ${file.name}`}
                >
                  <X className="h-3.5 w-3.5" />
                </button>
              </div>
            )
          })}
        </div>
      ) : null}
    </div>
  )
}

export default FileUpload
