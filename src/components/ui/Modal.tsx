import { X } from 'lucide-react'
import type { PropsWithChildren } from 'react'
import { useEffect } from 'react'
import { cn } from '../../lib/utils'

interface ModalProps {
  open: boolean
  onClose: () => void
  title: string
}

function Modal({ open, onClose, title, children }: PropsWithChildren<ModalProps>) {
  useEffect(() => {
    if (!open) {
      return
    }

    function handleEscape(event: KeyboardEvent) {
      if (event.key === 'Escape') {
        onClose()
      }
    }

    window.addEventListener('keydown', handleEscape)
    return () => window.removeEventListener('keydown', handleEscape)
  }, [open, onClose])

  if (!open) {
    return null
  }

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
      <div
        className={cn('glass-panel animate-slide-in w-full max-w-lg rounded-2xl border border-white/20 p-5')}
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-title"
      >
        <div className="mb-4 flex items-center justify-between">
          <h2 id="modal-title" className="font-display text-lg text-its-text-primary">
            {title}
          </h2>
          <button className="focus-ring rounded-lg p-1 text-its-text-secondary" onClick={onClose}>
            <X className="h-4 w-4" />
          </button>
        </div>
        <div>{children}</div>
      </div>
    </div>
  )
}

export default Modal