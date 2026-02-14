import { Heart } from 'lucide-react'
import { useAppToast } from '../../hooks/useAppToast'
import { useFavorites } from '../../hooks/useFavorites'
import { Link } from 'react-router-dom'
import type { ToolItem } from '../../lib/toolsData'
import { cn } from '../../lib/utils'
import Card from '../ui/Card'

interface ToolCardProps {
  tool: ToolItem
}

function ToolCard({ tool }: ToolCardProps) {
  const Icon = tool.icon
  const { isFavorite, toggleFavorite } = useFavorites()
  const { pushToast } = useAppToast()

  const favorite = isFavorite(tool.id)

  function handleToggleFavorite() {
    toggleFavorite(tool.id)
    pushToast({
      type: 'success',
      title: favorite ? 'Removed from favorites' : 'Added to favorites',
      message: tool.name,
    })
  }

  return (
    <Card className="group relative overflow-hidden">
      <div className="pointer-events-none absolute inset-0 bg-its-gradient opacity-0 transition group-hover:opacity-100" />
      <button
        aria-label={favorite ? 'Remove from favorites' : 'Add to favorites'}
        className="focus-ring absolute right-3 top-3 z-10 rounded-lg border border-white/15 bg-its-bg-primary/70 p-2 text-its-text-secondary"
        onClick={handleToggleFavorite}
      >
        <Heart
          className={cn('h-4 w-4', favorite ? 'fill-its-accent-purple text-its-accent-purple' : '')}
        />
      </button>
      <div className="relative space-y-4">
        <div className="inline-flex rounded-lg border border-its-accent-cyan/30 bg-its-accent-cyan/10 p-2.5">
          <Icon className="h-5 w-5 text-its-accent-cyan" />
        </div>
        <div>
          <h3 className="font-display text-lg tracking-wide">{tool.name}</h3>
          <p className="mt-1 text-sm text-its-text-secondary">{tool.description}</p>
        </div>
        <div className="flex items-center justify-between">
          <span className="rounded-full border border-white/10 px-2.5 py-1 text-xs uppercase tracking-wide text-its-text-secondary">
            {tool.category}
          </span>
          <Link
            to={tool.route}
            className="focus-ring rounded-lg border border-its-accent-cyan/40 px-3 py-1.5 text-xs font-semibold text-its-accent-cyan transition hover:bg-its-accent-cyan/10"
          >
            Quick Access
          </Link>
        </div>
      </div>
    </Card>
  )
}

export default ToolCard