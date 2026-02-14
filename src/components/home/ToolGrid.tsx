import { getMatchingTools } from '../../lib/toolSearch'
import { useMemo, useState } from 'react'
import { toolCategories, toolsData, type ToolCategory } from '../../lib/toolsData'
import ToolCard from '../tools/ToolCard'
import Button from '../ui/Button'
import Input from '../ui/Input'

function ToolGrid() {
  const [query, setQuery] = useState('')
  const [category, setCategory] = useState<ToolCategory | 'all'>('all')

  const filteredTools = useMemo(() => {
    const categoryFiltered = toolsData.filter((tool) => {
      const matchesCategory = category === 'all' || tool.category === category
      return matchesCategory
    })

    return getMatchingTools(categoryFiltered, query)
  }, [category, query])

  return (
    <section className="space-y-5">
      <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 className="font-display text-2xl tracking-wide">Tool Catalog</h2>
        <div className="w-full sm:max-w-sm">
          <Input
            aria-label="Search tools"
            value={query}
            onChange={(event) => setQuery(event.target.value)}
            placeholder="Search tools..."
          />
        </div>
      </div>

      <div className="flex flex-wrap gap-2">
        {toolCategories.map((item) => (
          <Button
            key={item.id}
            variant={category === item.id ? 'primary' : 'ghost'}
            onClick={() => setCategory(item.id)}
            aria-pressed={category === item.id}
          >
            {item.label}
          </Button>
        ))}
      </div>

      <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        {filteredTools.map((tool) => (
          <ToolCard key={tool.id} tool={tool} />
        ))}
      </div>

      {filteredTools.length === 0 ? (
        <p className="rounded-xl border border-dashed border-white/15 p-4 text-sm text-its-text-secondary">
          No tools matched your filters. Try another search term.
        </p>
      ) : null}
    </section>
  )
}

export default ToolGrid