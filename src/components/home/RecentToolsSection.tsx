import { useRecentTools } from '../../hooks/useRecentTools'
import ToolCard from '../tools/ToolCard'

function RecentToolsSection() {
  const { recentTools } = useRecentTools()

  if (recentTools.length === 0) {
    return null
  }

  return (
    <section className="space-y-4">
      <h2 className="font-display text-2xl tracking-wide">Recent Tools</h2>
      <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        {recentTools.slice(0, 3).map((tool) => (
          <ToolCard key={tool.id} tool={tool} />
        ))}
      </div>
    </section>
  )
}

export default RecentToolsSection
