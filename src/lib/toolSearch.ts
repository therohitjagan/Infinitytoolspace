import type { ToolItem } from './toolsData'

function normalize(value: string) {
  return value.toLowerCase().trim()
}

function fuzzyScore(query: string, source: string) {
  const normalizedQuery = normalize(query)
  const normalizedSource = normalize(source)

  if (!normalizedQuery) {
    return 0
  }

  if (normalizedSource.includes(normalizedQuery)) {
    return normalizedQuery.length * 3
  }

  let score = 0
  let pointer = 0

  for (let index = 0; index < normalizedSource.length; index += 1) {
    if (normalizedSource[index] === normalizedQuery[pointer]) {
      score += 1
      pointer += 1
      if (pointer === normalizedQuery.length) {
        return score
      }
    }
  }

  return -1
}

export function getMatchingTools(tools: ToolItem[], query: string) {
  const normalizedQuery = normalize(query)

  if (!normalizedQuery) {
    return tools
  }

  return tools
    .map((tool) => {
      const score = fuzzyScore(
        normalizedQuery,
        `${tool.name} ${tool.description} ${tool.shortDescription ?? ''} ${tool.keywords ?? ''} ${tool.category}`,
      )
      return { score, tool }
    })
    .filter((entry) => entry.score >= 0)
    .sort((left, right) => right.score - left.score)
    .map((entry) => entry.tool)
}
