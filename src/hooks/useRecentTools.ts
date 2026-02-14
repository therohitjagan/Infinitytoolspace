import { useCallback, useMemo, useState } from 'react'
import { toolsData, type ToolItem } from '../lib/toolsData'

const RECENT_TOOLS_STORAGE_KEY = 'its-recent-tools'
const MAX_RECENT_TOOLS = 6

function readRecentToolIds() {
  try {
    const raw = window.localStorage.getItem(RECENT_TOOLS_STORAGE_KEY)
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

function writeRecentToolIds(ids: string[]) {
  window.localStorage.setItem(RECENT_TOOLS_STORAGE_KEY, JSON.stringify(ids))
}

export function useRecentTools() {
  const [recentToolIds, setRecentToolIds] = useState<string[]>(() => readRecentToolIds())

  const addRecentTool = useCallback((toolId: string) => {
    setRecentToolIds((current) => {
      const next = [toolId, ...current.filter((id) => id !== toolId)].slice(0, MAX_RECENT_TOOLS)
      writeRecentToolIds(next)
      return next
    })
  }, [])

  const recentTools = useMemo(
    () =>
      recentToolIds
        .map((id) => toolsData.find((tool) => tool.id === id))
        .filter((tool): tool is ToolItem => Boolean(tool)),
    [recentToolIds],
  )

  return { recentToolIds, recentTools, addRecentTool }
}
