import { useMemo, useState } from 'react'
import Card from '../../components/ui/Card'

function WordCounter() {
  const [text, setText] = useState('')

  const stats = useMemo(() => {
    const trimmed = text.trim()
    const words = trimmed ? trimmed.split(/\s+/).length : 0
    const characters = text.length
    const charactersNoSpaces = text.replace(/\s/g, '').length
    const sentences = trimmed ? trimmed.split(/[.!?]+/).filter(Boolean).length : 0
    const readingTimeMinutes = words / 200

    return {
      words,
      characters,
      charactersNoSpaces,
      sentences,
      readingTime: readingTimeMinutes,
    }
  }, [text])

  return (
    <div className="space-y-4">
      <Card className="space-y-3">
        <textarea
          value={text}
          onChange={(event) => setText(event.target.value)}
          rows={10}
          placeholder="Paste or type text here..."
          className="focus-ring w-full rounded-xl border border-white/20 bg-white/5 p-3 text-sm text-its-text-primary placeholder:text-its-text-secondary/70"
        />
      </Card>

      <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
        <Card>
          <p className="text-xs text-its-text-secondary">Words</p>
          <p className="font-display text-2xl">{stats.words}</p>
        </Card>
        <Card>
          <p className="text-xs text-its-text-secondary">Characters</p>
          <p className="font-display text-2xl">{stats.characters}</p>
        </Card>
        <Card>
          <p className="text-xs text-its-text-secondary">No spaces</p>
          <p className="font-display text-2xl">{stats.charactersNoSpaces}</p>
        </Card>
        <Card>
          <p className="text-xs text-its-text-secondary">Sentences</p>
          <p className="font-display text-2xl">{stats.sentences}</p>
        </Card>
        <Card>
          <p className="text-xs text-its-text-secondary">Read time</p>
          <p className="font-display text-2xl">{stats.readingTime.toFixed(2)}m</p>
        </Card>
      </div>
    </div>
  )
}

export default WordCounter
