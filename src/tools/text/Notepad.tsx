import { useEffect, useMemo, useRef, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

const STORAGE_KEY = 'its.notepad.content'

function Notepad() {
  const [text, setText] = useState(() => localStorage.getItem(STORAGE_KEY) ?? '')
  const [query, setQuery] = useState('')
  const [replaceValue, setReplaceValue] = useState('')
  const [matchCase, setMatchCase] = useState(false)
  const [history, setHistory] = useState<string[]>([])
  const [future, setFuture] = useState<string[]>([])
  const [autoSavedAt, setAutoSavedAt] = useState<string>('')
  const [isDirty, setIsDirty] = useState(false)
  const lastTextRef = useRef(localStorage.getItem(STORAGE_KEY) ?? '')

  const stats = useMemo(() => {
    const words = text.trim() ? text.trim().split(/\s+/).length : 0
    const lines = text ? text.split('\n').length : 0
    const charsNoSpaces = text.replace(/\s/g, '').length
    const readingMinutes = Math.max(1, Math.ceil(words / 200))
    return { words, chars: text.length, lines, charsNoSpaces, readingMinutes }
  }, [text])

  useEffect(() => {
    if (!isDirty) return
    const timeout = window.setTimeout(() => {
      localStorage.setItem(STORAGE_KEY, text)
      setAutoSavedAt(new Date().toLocaleTimeString())
      setIsDirty(false)
    }, 500)

    return () => window.clearTimeout(timeout)
  }, [isDirty, text])

  function updateText(next: string) {
    const previous = lastTextRef.current
    if (next !== previous) {
      setHistory((current) => {
        const updated = [...current, previous]
        return updated.slice(-200)
      })
      setFuture([])
      lastTextRef.current = next
      setText(next)
      setIsDirty(true)
    }
  }

  function transform(mode: 'upper' | 'lower' | 'title' | 'sentence') {
    if (mode === 'upper') updateText(text.toUpperCase())
    if (mode === 'lower') updateText(text.toLowerCase())
    if (mode === 'title') {
      updateText(
        text
          .toLowerCase()
          .split(' ')
          .map((chunk) => (chunk ? `${chunk[0].toUpperCase()}${chunk.slice(1)}` : chunk))
          .join(' '),
      )
    }
    if (mode === 'sentence') {
      updateText(
        text
          .toLowerCase()
          .replace(/(^\s*\w|[.!?]\s*\w)/g, (match) => match.toUpperCase()),
      )
    }
  }

  function clean(mode: 'trimLines' | 'removeExtraSpaces' | 'removeBlankLines') {
    if (mode === 'trimLines') {
      updateText(
        text
          .split('\n')
          .map((line) => line.trim())
          .join('\n'),
      )
    }
    if (mode === 'removeExtraSpaces') {
      updateText(text.replace(/[ \t]{2,}/g, ' '))
    }
    if (mode === 'removeBlankLines') {
      updateText(text.replace(/\n{3,}/g, '\n\n'))
    }
  }

  function undo() {
    setHistory((current) => {
      if (!current.length) return current
      const previous = current[current.length - 1]
      setFuture((next) => [text, ...next].slice(0, 200))
      setText(previous)
      lastTextRef.current = previous
      setIsDirty(true)
      return current.slice(0, -1)
    })
  }

  function redo() {
    setFuture((current) => {
      if (!current.length) return current
      const next = current[0]
      setHistory((prev) => [...prev, text].slice(-200))
      setText(next)
      lastTextRef.current = next
      setIsDirty(true)
      return current.slice(1)
    })
  }

  function replaceAll() {
    if (!query) return
    const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')
    const flags = matchCase ? 'g' : 'gi'
    updateText(text.replace(new RegExp(escaped, flags), replaceValue))
  }

  function copyAll() {
    void navigator.clipboard.writeText(text)
  }

  function downloadTxt() {
    const blob = new Blob([text], { type: 'text/plain;charset=utf-8' })
    const link = document.createElement('a')
    link.href = URL.createObjectURL(blob)
    link.download = 'notes.txt'
    link.click()
    URL.revokeObjectURL(link.href)
  }

  function importTxt(file: File) {
    const reader = new FileReader()
    reader.onload = () => {
      updateText(String(reader.result ?? ''))
    }
    reader.readAsText(file)
  }

  return (
    <Card className="space-y-4">
      <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
        <Button variant="secondary" onClick={undo} disabled={!history.length}>
          Undo
        </Button>
        <Button variant="secondary" onClick={redo} disabled={!future.length}>
          Redo
        </Button>
        <Button variant="ghost" onClick={copyAll} disabled={!text}>
          Copy all
        </Button>
        <Button variant="ghost" onClick={downloadTxt} disabled={!text}>
          Download .txt
        </Button>
      </div>

      <label className="block rounded-xl border border-dashed border-white/20 p-3 text-xs text-its-text-secondary">
        Import text file
        <input
          type="file"
          accept=".txt,.md,.log,.csv"
          className="mt-2 block w-full text-xs"
          onChange={(event) => {
            const selected = event.target.files?.[0]
            if (selected) importTxt(selected)
            event.currentTarget.value = ''
          }}
        />
      </label>

      <textarea
        rows={14}
        value={text}
        onChange={(event) => updateText(event.target.value)}
        placeholder="Start typing notes..."
        className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm"
      />

      <div className="flex flex-wrap gap-2">
        <Button variant="ghost" onClick={() => transform('upper')}>
          UPPERCASE
        </Button>
        <Button variant="ghost" onClick={() => transform('lower')}>
          lowercase
        </Button>
        <Button variant="ghost" onClick={() => transform('title')}>
          Title Case
        </Button>
        <Button variant="ghost" onClick={() => transform('sentence')}>
          Sentence case
        </Button>
        <Button variant="ghost" onClick={() => clean('trimLines')}>
          Trim lines
        </Button>
        <Button variant="ghost" onClick={() => clean('removeExtraSpaces')}>
          Remove extra spaces
        </Button>
        <Button variant="ghost" onClick={() => clean('removeBlankLines')}>
          Compact blank lines
        </Button>
        <Button variant="ghost" onClick={() => updateText('')}>
          Clear
        </Button>
      </div>

      <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
        <input
          value={query}
          onChange={(event) => setQuery(event.target.value)}
          placeholder="Find text"
          className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2 text-sm"
        />
        <input
          value={replaceValue}
          onChange={(event) => setReplaceValue(event.target.value)}
          placeholder="Replace with"
          className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2 text-sm"
        />
        <label className="flex items-center gap-2 rounded-xl border border-white/15 px-3 text-sm">
          <input
            type="checkbox"
            checked={matchCase}
            onChange={(event) => setMatchCase(event.target.checked)}
          />
          Match case
        </label>
        <Button variant="secondary" onClick={replaceAll} disabled={!query}>
          Replace all
        </Button>
      </div>

      <p className="text-xs text-its-text-secondary">
        Words: {stats.words} • Characters: {stats.chars} • Characters (no spaces): {stats.charsNoSpaces}{' '}
        • Lines: {stats.lines} • Est. read: {stats.readingMinutes} min • Auto-saved:{' '}
        {autoSavedAt || 'Not yet'}
      </p>
    </Card>
  )
}

export default Notepad
