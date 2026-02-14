import { useMemo, useState } from 'react'

interface FileUploadOptions {
  acceptedTypes?: string[]
  maxFileSizeMb?: number
  multiple?: boolean
}

export function useFileUpload(options: FileUploadOptions = {}) {
  const [files, setFiles] = useState<File[]>([])
  const [error, setError] = useState<string | null>(null)

  const maxBytes = useMemo(
    () => (options.maxFileSizeMb ? options.maxFileSizeMb * 1024 * 1024 : undefined),
    [options.maxFileSizeMb],
  )

  function updateFiles(nextFiles: File[]) {
    setError(null)

    if (!options.multiple && nextFiles.length > 1) {
      setError('Please select one file only.')
      return
    }

    if (maxBytes && nextFiles.some((file) => file.size > maxBytes)) {
      setError(`Files must be under ${options.maxFileSizeMb}MB.`)
      return
    }

    if (
      options.acceptedTypes?.length &&
      nextFiles.some((file) => !options.acceptedTypes?.includes(file.type))
    ) {
      setError('One or more files have unsupported formats.')
      return
    }

    setFiles(nextFiles)
  }

  function clearFiles() {
    setFiles([])
    setError(null)
  }

  return { files, error, updateFiles, clearFiles }
}