import { useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

function indentHtmlLike(input: string) {
  const lines = input.replace(/></g, '>\n<').split('\n')
  let depth = 0
  return lines
    .map((line) => {
      const trimmed = line.trim()
      if (trimmed.startsWith('</')) depth = Math.max(0, depth - 1)
      const output = `${'  '.repeat(depth)}${trimmed}`
      if (trimmed.startsWith('<') && !trimmed.startsWith('</') && !trimmed.endsWith('/>')) depth += 1
      return output
    })
    .join('\n')
}

function FormatterTool() {
  const [input, setInput] = useState('')
  const [output, setOutput] = useState('')

  function format(type: 'json' | 'html' | 'css' | 'js') {
    if (type === 'json') {
      try {
        setOutput(JSON.stringify(JSON.parse(input), null, 2))
      } catch {
        setOutput('Invalid JSON')
      }
      return
    }

    if (type === 'html') {
      setOutput(indentHtmlLike(input))
      return
    }

    const lines = input.split('\n').map((line) => line.trim()).filter(Boolean)
    setOutput(lines.join('\n'))
  }

  return (
    <div className="grid gap-4 lg:grid-cols-2">
      <Card className="space-y-3">
        <textarea rows={12} value={input} onChange={(event) => setInput(event.target.value)} className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 font-code text-sm" />
        <div className="flex flex-wrap gap-2">
          <Button onClick={() => format('json')}>Format JSON</Button>
          <Button variant="secondary" onClick={() => format('html')}>Format HTML</Button>
          <Button variant="ghost" onClick={() => format('css')}>Format CSS</Button>
          <Button variant="ghost" onClick={() => format('js')}>Format JS</Button>
        </div>
      </Card>
      <Card>
        <textarea readOnly rows={12} value={output} className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 font-code text-sm" />
      </Card>
    </div>
  )
}

export default FormatterTool
