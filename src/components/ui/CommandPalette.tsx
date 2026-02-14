import { motion } from 'framer-motion'
import { CornerDownLeft, Search } from 'lucide-react'
import { useEffect, useMemo, useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { useRecentTools } from '../../hooks/useRecentTools'
import { getMatchingTools } from '../../lib/toolSearch'
import { toolsData } from '../../lib/toolsData'
import { cn } from '../../lib/utils'

interface CommandPaletteProps {
  onClose: () => void
}

type PaletteItem = {
  id: string
  label: string
  description: string
  route: string
  kind: 'tool' | 'action'
}

const quickActions: PaletteItem[] = [
  {
    id: 'action-home',
    label: 'Go to Home',
    description: 'Return to the homepage',
    route: '/',
    kind: 'action',
  },
  {
    id: 'action-tools',
    label: 'Browse All Tools',
    description: 'Open tool category',
    route: '/category/all',
    kind: 'action',
  },
  {
    id: 'action-about',
    label: 'About InfinityToolSpace',
    description: 'View project overview',
    route: '/about',
    kind: 'action',
  },
  {
    id: 'action-contact',
    label: 'Contact Us',
    description: 'Open contact page',
    route: '/contact',
    kind: 'action',
  },
  {
    id: 'action-legal',
    label: 'Privacy & Terms',
    description: 'Open legal and policy page',
    route: '/privacy-terms',
    kind: 'action',
  },
]

function CommandPalette({ onClose }: CommandPaletteProps) {
  const navigate = useNavigate()
  const { recentTools } = useRecentTools()
  const [query, setQuery] = useState('')
  const [activeIndex, setActiveIndex] = useState(0)

  const toolItems = useMemo<PaletteItem[]>(() => {
    const sourceTools = query.trim() ? getMatchingTools(toolsData, query) : recentTools

    return sourceTools.map((tool) => ({
      id: `tool-${tool.id}`,
      label: tool.name,
      description: tool.description,
      route: tool.route,
      kind: 'tool',
    }))
  }, [query, recentTools])

  const results = useMemo(() => [...toolItems, ...quickActions], [toolItems])

  const boundedActiveIndex = results.length === 0 ? 0 : Math.min(activeIndex, results.length - 1)

  useEffect(() => {
    function handlePaletteNavigation(event: KeyboardEvent) {
      if (event.key === 'Escape') {
        event.preventDefault()
        onClose()
      }

      if (event.key === 'ArrowDown') {
        event.preventDefault()
        setActiveIndex((current) => (current + 1) % Math.max(results.length, 1))
      }

      if (event.key === 'ArrowUp') {
        event.preventDefault()
        setActiveIndex((current) => (current - 1 + Math.max(results.length, 1)) % Math.max(results.length, 1))
      }

      if (event.key === 'Enter' && results[boundedActiveIndex]) {
        event.preventDefault()
        navigate(results[boundedActiveIndex].route)
        onClose()
      }
    }

    window.addEventListener('keydown', handlePaletteNavigation)
    return () => window.removeEventListener('keydown', handlePaletteNavigation)
  }, [boundedActiveIndex, navigate, onClose, results])

  return (
    <motion.div
      className="fixed inset-0 z-[70] bg-black/60 p-4 sm:p-8"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      onClick={onClose}
    >
      <motion.section
        className="glass-panel mx-auto w-full max-w-2xl overflow-hidden rounded-2xl border border-white/20"
        initial={{ y: 20, opacity: 0, scale: 0.98 }}
        animate={{ y: 0, opacity: 1, scale: 1 }}
        exit={{ y: 12, opacity: 0, scale: 0.98 }}
        transition={{ duration: 0.2, ease: 'easeOut' }}
        onClick={(event) => event.stopPropagation()}
      >
        <div className="flex items-center gap-2 border-b border-white/10 px-4 py-3">
          <Search className="h-4 w-4 text-its-text-secondary" />
          <input
            autoFocus
            value={query}
            onChange={(event) => setQuery(event.target.value)}
            placeholder="Search tools or actions..."
            className="focus-ring w-full border-none bg-transparent text-sm text-its-text-primary placeholder:text-its-text-secondary/70"
            aria-label="Search command palette"
          />
        </div>

        <div className="max-h-[420px] overflow-y-auto p-2">
          {results.length === 0 ? (
            <div className="rounded-xl px-3 py-8 text-center text-sm text-its-text-secondary">
              No matches found.
            </div>
          ) : (
            <ul className="space-y-1">
              {results.map((item, index) => (
                <li key={item.id}>
                  <button
                    onClick={() => {
                      navigate(item.route)
                      onClose()
                    }}
                    className={cn(
                      'focus-ring flex w-full items-center justify-between rounded-xl px-3 py-2 text-left transition',
                      boundedActiveIndex === index
                        ? 'bg-white/10 text-its-text-primary'
                        : 'text-its-text-secondary hover:bg-white/5',
                    )}
                    aria-current={boundedActiveIndex === index}
                  >
                    <span>
                      <span className="block text-sm font-semibold">{item.label}</span>
                      <span className="block text-xs text-its-text-secondary/80">{item.description}</span>
                    </span>
                    <span className="rounded-md border border-white/10 px-2 py-1 text-[10px] uppercase tracking-wide text-its-accent-cyan">
                      {item.kind}
                    </span>
                  </button>
                </li>
              ))}
            </ul>
          )}
        </div>

        <div className="flex items-center justify-between border-t border-white/10 px-4 py-2 text-xs text-its-text-secondary">
          <span className="hidden sm:inline">Use ↑/↓ to navigate</span>
          <span className="inline-flex items-center gap-1">
            <CornerDownLeft className="h-3.5 w-3.5" />
            Enter to open
          </span>
        </div>
      </motion.section>
    </motion.div>
  )
}

export default CommandPalette
