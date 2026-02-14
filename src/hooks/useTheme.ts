import { useEffect } from 'react'
import { useUIStore } from '../store/uiStore'

export function useTheme() {
  const { theme, toggleTheme, setTheme } = useUIStore()

  useEffect(() => {
    document.documentElement.dataset.theme = theme
  }, [theme])

  return { theme, toggleTheme, setTheme }
}