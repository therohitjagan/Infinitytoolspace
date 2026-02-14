import { useState } from 'react'
import { useAppToast } from '../../hooks/useAppToast'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

function JSONFormatter() {
  const { pushToast } = useAppToast()
  const [input, setInput] = useState('')
  const [output, setOutput] = useState('')
  const [error, setError] = useState<string | null>(null)

  function formatJSON(pretty: boolean) {
    try {
      const parsed = JSON.parse(input)
      setOutput(JSON.stringify(parsed, null, pretty ? 2 : 0))
      setError(null)
      pushToast({
        type: 'success',
        title: pretty ? 'JSON formatted' : 'JSON minified',
      })
    } catch {
      setError('Invalid JSON input. Please check syntax and try again.')
      setOutput('')
      pushToast({
        type: 'error',
        title: 'JSON parse failed',
        message: 'Please fix syntax and try again.',
      })
    }
  }

  async function copyOutput() {
    if (!output) {
      return
    }
    await navigator.clipboard.writeText(output)
    pushToast({
      type: 'info',
      title: 'Copied to clipboard',
    })
  }

  return (
    <div className="grid gap-4 lg:grid-cols-2">
      <Card className="space-y-3">
        <h3 className="font-display text-lg">Input</h3>
        <textarea
          value={input}
          onChange={(event) => setInput(event.target.value)}
          rows={14}
          className="focus-ring w-full rounded-xl border border-white/20 bg-white/5 p-3 font-code text-sm"
          placeholder='{"hello":"world"}'
        />
        <div className="flex flex-wrap gap-2">
          <Button onClick={() => formatJSON(true)}>Format</Button>
          <Button variant="secondary" onClick={() => formatJSON(false)}>
            Minify
          </Button>
          <Button variant="ghost" onClick={() => setInput('')}>
            Clear
          </Button>
        </div>
      </Card>

      <Card className="space-y-3">
        <h3 className="font-display text-lg">Output</h3>
        <textarea
          value={output}
          readOnly
          rows={14}
          className="focus-ring w-full rounded-xl border border-white/20 bg-white/5 p-3 font-code text-sm"
          placeholder="Formatted JSON will appear here"
        />
        {error ? <p className="text-sm text-its-status-error">{error}</p> : null}
        <Button variant="secondary" onClick={copyOutput} disabled={!output}>
          Copy output
        </Button>
      </Card>
    </div>
  )
}

export default JSONFormatter
