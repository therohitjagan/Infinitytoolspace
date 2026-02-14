import { useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

function PasswordGenerator() {
  const [length, setLength] = useState(14)
  const [upper, setUpper] = useState(true)
  const [lower, setLower] = useState(true)
  const [number, setNumber] = useState(true)
  const [symbol, setSymbol] = useState(true)
  const [password, setPassword] = useState('')

  function generatePassword() {
    let charset = ''
    if (upper) charset += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
    if (lower) charset += 'abcdefghijklmnopqrstuvwxyz'
    if (number) charset += '0123456789'
    if (symbol) charset += '!@#$%^&*()-_=+[]{};:,.?'
    if (!charset) {
      setPassword('')
      return
    }

    const next = Array.from({ length })
      .map(() => charset[Math.floor(Math.random() * charset.length)])
      .join('')
    setPassword(next)
  }

  return (
    <Card className="space-y-4">
      <div className="rounded-xl border border-white/15 bg-white/5 p-3 font-code">{password || 'Select at least one character set.'}</div>
      <label className="block text-sm text-its-text-secondary">Length: {length}</label>
      <input type="range" min={6} max={64} value={length} onChange={(event) => setLength(Number(event.target.value))} className="w-full" />
      <div className="grid gap-2 sm:grid-cols-2">
        <label><input type="checkbox" checked={upper} onChange={(event) => setUpper(event.target.checked)} /> Uppercase</label>
        <label><input type="checkbox" checked={lower} onChange={(event) => setLower(event.target.checked)} /> Lowercase</label>
        <label><input type="checkbox" checked={number} onChange={(event) => setNumber(event.target.checked)} /> Numbers</label>
        <label><input type="checkbox" checked={symbol} onChange={(event) => setSymbol(event.target.checked)} /> Symbols</label>
      </div>
      <div className="flex gap-2">
        <Button onClick={generatePassword}>Generate</Button>
        <Button variant="secondary" onClick={() => password && navigator.clipboard.writeText(password)} disabled={!password}>Copy</Button>
      </div>
    </Card>
  )
}

export default PasswordGenerator
