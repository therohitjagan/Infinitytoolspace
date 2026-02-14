import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

function EmailObfuscator() {
  const [email, setEmail] = useState('')
  const [mode, setMode] = useState<'html' | 'text'>('html')

  const output = useMemo(() => {
    if (!email) return ''
    const chars = email.split('')
    if (mode === 'text') {
      return chars.map((ch) => `&#${ch.charCodeAt(0)};`).join('')
    }

    return `<a href="mailto:${email}">${chars.map((ch) => `&#${ch.charCodeAt(0)};`).join('')}</a>`
  }, [email, mode])

  return (
    <Card className="space-y-3">
      <input value={email} onChange={(event) => setEmail(event.target.value)} placeholder="name@example.com" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm" />
      <div className="flex gap-2">
        <Button variant={mode === 'html' ? 'primary' : 'ghost'} onClick={() => setMode('html')}>HTML</Button>
        <Button variant={mode === 'text' ? 'primary' : 'ghost'} onClick={() => setMode('text')}>Text</Button>
      </div>
      <textarea readOnly rows={5} value={output} className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 font-code text-sm" />
      <Button variant="secondary" onClick={() => output && navigator.clipboard.writeText(output)} disabled={!output}>Copy Obfuscated</Button>
    </Card>
  )
}

export default EmailObfuscator
