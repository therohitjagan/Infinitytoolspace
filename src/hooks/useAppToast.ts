import { createContext, useContext } from 'react'
import type { ToastItem } from './useToast'

export interface ToastContextValue {
  pushToast: (toast: Omit<ToastItem, 'id'>) => string
  removeToast: (id: string) => void
}

export const ToastContext = createContext<ToastContextValue | null>(null)

export function useAppToast() {
  const context = useContext(ToastContext)

  if (!context) {
    throw new Error('useAppToast must be used within ToastProvider')
  }

  const { pushToast, removeToast } = context

  return {
    pushToast,
    removeToast,
  }
}
