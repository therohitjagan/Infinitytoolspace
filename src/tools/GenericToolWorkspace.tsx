import { useState } from 'react'
import type { ToolItem } from '../lib/toolsData'
import Button from '../components/ui/Button'
import Card from '../components/ui/Card'

interface GenericToolWorkspaceProps {
  tool: ToolItem
}

function GenericToolWorkspace({ tool }: GenericToolWorkspaceProps) {
  const [input, setInput] = useState('')
  const [output, setOutput] = useState('')

  function run() {
    if (!input.trim()) {
      setOutput('Enter input to process.')
      return
    }

    setOutput(`Tool: ${tool.name}\n\nProcessed output:\n${input}`)
  }

  return (
    <Card className="space-y-3">
      <p className="text-xs text-its-text-secondary">
        Dynamic workspace fallback. You can add tools in the catalog without creating new component
        files.
      </p>
      <textarea
        rows={8}
        value={input}
        onChange={(event) => setInput(event.target.value)}
        placeholder={`Use ${tool.name}...`}
        className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm"
      />
      <div className="flex flex-wrap gap-2">
        <Button onClick={run}>Process</Button>
        <Button variant="secondary" onClick={() => output && navigator.clipboard.writeText(output)} disabled={!output}>
          Copy
        </Button>
      </div>
      <textarea
        rows={8}
        readOnly
        value={output}
        className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm"
      />
    </Card>
  )
}

export default GenericToolWorkspace
