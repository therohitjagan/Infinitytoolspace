import { useCallback, useMemo, useState } from 'react'
import { toolsData, type ToolItem } from '../lib/toolsData'

const FAVORITES_STORAGE_KEY = 'its-favorite-tools'

function readFavoriteIds() {
  try {
    const raw = window.localStorage.getItem(FAVORITES_STORAGE_KEY)
    if (!raw) {
      return []
    }

    const parsed = JSON.parse(raw)

    if (!Array.isArray(parsed)) {
      return []
    }

    return parsed.filter((item): item is string => typeof item === 'string')
  } catch {
    return []
  }
}

function writeFavoriteIds(ids: string[]) {
  window.localStorage.setItem(FAVORITES_STORAGE_KEY, JSON.stringify(ids))
}

export function useFavorites() {
  const [favoriteToolIds, setFavoriteToolIds] = useState<string[]>(() => readFavoriteIds())

  const toggleFavorite = useCallback((toolId: string) => {
    setFavoriteToolIds((current) => {
      const next = current.includes(toolId)
        ? current.filter((id) => id !== toolId)
        : [toolId, ...current]
      writeFavoriteIds(next)
      return next
    })
  }, [])

  const isFavorite = useCallback(
    (toolId: string) => favoriteToolIds.includes(toolId),
    [favoriteToolIds],
  )

  const favoriteTools = useMemo<ToolItem[]>(
    () =>
      favoriteToolIds
        .map((id) => toolsData.find((tool) => tool.id === id))
        .filter((tool): tool is ToolItem => Boolean(tool)),
    [favoriteToolIds],
  )

  return { favoriteToolIds, favoriteTools, toggleFavorite, isFavorite }
}
