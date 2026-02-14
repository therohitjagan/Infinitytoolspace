import { AlertCircle, AlertTriangle, CheckCircle2, Info } from 'lucide-react'
import { useEffect } from 'react'
import type { ToastItem } from '../../hooks/useToast'
import { cn } from '../../lib/utils'

interface ToastProps {
  item: ToastItem
  onDismiss: (id: string) => void
  durationMs?: number
}

const toastTone: Record<ToastItem['type'], string> = {
  success: 'border-its-status-success/40 bg-its-status-success/10',
  error: 'border-its-status-error/40 bg-its-status-error/10',
  warning: 'border-its-status-warning/40 bg-its-status-warning/10',
  info: 'border-its-accent-cyan/40 bg-its-accent-cyan/10',
}

const toastIcon = {
  success: CheckCircle2,
  error: AlertCircle,
  warning: AlertTriangle,
  info: Info,
}

function Toast({ item, onDismiss, durationMs = 2800 }: ToastProps) {
  const Icon = toastIcon[item.type]

  useEffect(() => {
    const timer = window.setTimeout(() => onDismiss(item.id), durationMs)
    return () => window.clearTimeout(timer)
  }, [item.id, durationMs, onDismiss])

  return (
    <div
      className={cn(
        'glass-panel animate-slide-in flex w-full items-start gap-3 rounded-xl border px-4 py-3 text-sm text-its-text-primary',
        toastTone[item.type],
      )}
      role="status"
      aria-live="polite"
    >
      <Icon className="mt-0.5 h-4 w-4" />
      <div>
        <p className="font-semibold">{item.title}</p>
        {item.message ? <p className="text-its-text-secondary">{item.message}</p> : null}
      </div>
    </div>
  )
}

export default Toast