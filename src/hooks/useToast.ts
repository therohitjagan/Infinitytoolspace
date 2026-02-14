import { useState } from 'react'

export type ToastType = 'success' | 'error' | 'warning' | 'info'

export interface ToastItem {
  id: string
  type: ToastType
  title: string
  message?: string
}

export function useToast() {
  const [toasts, setToasts] = useState<ToastItem[]>([])

  function push(toast: Omit<ToastItem, 'id'>) {
    const id = crypto.randomUUID()
    setToasts((current) => [...current, { ...toast, id }])
    return id
  }

  function remove(id: string) {
    setToasts((current) => current.filter((item) => item.id !== id))
  }

  return { toasts, push, remove }
}