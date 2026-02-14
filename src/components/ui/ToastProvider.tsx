import { useCallback, useMemo, useState, type PropsWithChildren } from 'react'
import Toast from './Toast'
import type { ToastItem } from '../../hooks/useToast'
import { ToastContext } from '../../hooks/useAppToast'

export function ToastProvider({ children }: PropsWithChildren) {
  const [toasts, setToasts] = useState<ToastItem[]>([])

  const removeToast = useCallback((id: string) => {
    setToasts((current) => current.filter((item) => item.id !== id))
  }, [])

  const pushToast = useCallback((toast: Omit<ToastItem, 'id'>) => {
    const id = crypto.randomUUID()
    setToasts((current) => [...current, { ...toast, id }])
    return id
  }, [])

  const value = useMemo(
    () => ({
      pushToast,
      removeToast,
    }),
    [pushToast, removeToast],
  )

  return (
    <ToastContext.Provider value={value}>
      {children}
      <div className="pointer-events-none fixed bottom-4 right-4 z-[80] flex w-[340px] max-w-[calc(100vw-2rem)] flex-col gap-2">
        {toasts.map((item) => (
          <div key={item.id} className="pointer-events-auto">
            <Toast item={item} onDismiss={removeToast} />
          </div>
        ))}
      </div>
    </ToastContext.Provider>
  )
}
