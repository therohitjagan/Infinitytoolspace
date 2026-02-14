import { useFavorites } from '../../hooks/useFavorites'
import ToolCard from '../tools/ToolCard'

function FavoritesSection() {
  const { favoriteTools } = useFavorites()

  if (favoriteTools.length === 0) {
    return null
  }

  return (
    <section className="space-y-4">
      <h2 className="font-display text-2xl tracking-wide">Favorites</h2>
      <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        {favoriteTools.slice(0, 3).map((tool) => (
          <ToolCard key={tool.id} tool={tool} />
        ))}
      </div>
    </section>
  )
}

export default FavoritesSection
