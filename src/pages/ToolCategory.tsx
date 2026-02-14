import { useMemo } from 'react'
import { useParams } from 'react-router-dom'
import Container from '../components/layout/Container'
import ToolCard from '../components/tools/ToolCard'
import { getCategoryLabel, toolsData } from '../lib/toolsData'

function ToolCategory() {
  const { category = '' } = useParams()

  const categoryTools = useMemo(() => {
    if (category === 'all') {
      return toolsData
    }

    return toolsData.filter((tool) => tool.category === category)
  }, [category])

  return (
    <Container className="space-y-6 pb-20 pt-6">
      <h1 className="font-display text-3xl tracking-wide">{getCategoryLabel(category)} Tools</h1>
      {categoryTools.length === 0 ? (
        <p className="text-its-text-secondary">No tools found for this category yet.</p>
      ) : (
        <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
          {categoryTools.map((tool) => (
            <ToolCard key={tool.id} tool={tool} />
          ))}
        </div>
      )}
    </Container>
  )
}

export default ToolCategory