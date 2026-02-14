import { useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

type Mode =
  | 'b64e'
  | 'b64d'
  | 'urle'
  | 'urld'
  | 'hexe'
  | 'hexd'
  | 'bine'
  | 'bind'
  | 'rot13'
  | 'htmlE'
  | 'htmlD'
  | 'jwt'

function utf8ToBase64(value: string) {
  return btoa(unescape(encodeURIComponent(value)))
}

function base64ToUtf8(value: string) {
  return decodeURIComponent(escape(atob(value)))
}

function stringToHex(value: string) {
  return Array.from(value)
    .map((char) => char.charCodeAt(0).toString(16).padStart(2, '0'))
    .join(' ')
}

function hexToString(value: string) {
  const clean = value.replace(/[^0-9a-fA-F]/g, '')
  if (clean.length % 2 !== 0) throw new Error('Invalid hex input')
  let output = ''
  for (let index = 0; index < clean.length; index += 2) {
    output += String.fromCharCode(Number.parseInt(clean.slice(index, index + 2), 16))
  }
  return output
}

function stringToBinary(value: string) {
  return Array.from(value)
    .map((char) => char.charCodeAt(0).toString(2).padStart(8, '0'))
    .join(' ')
}

function binaryToString(value: string) {
  return value
    .trim()
    .split(/\s+/)
    .map((chunk) => String.fromCharCode(Number.parseInt(chunk, 2)))
    .join('')
}

function runRot13(value: string) {
  return value.replace(/[a-zA-Z]/g, (char) => {
    const base = char <= 'Z' ? 65 : 97
    return String.fromCharCode(((char.charCodeAt(0) - base + 13) % 26) + base)
  })
}

function htmlEncode(value: string) {
  return value
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;')
}

function htmlDecode(value: string) {
  return value
    .replace(/&lt;/g, '<')
    .replace(/&gt;/g, '>')
    .replace(/&quot;/g, '"')
    .replace(/&#39;/g, "'")
    .replace(/&amp;/g, '&')
}

function jwtDecode(token: string) {
  const [header, payload, signature] = token.split('.')
  if (!header || !payload) {
    throw new Error('Invalid JWT token')
  }

  const decodePart = (part: string) => {
    const normalized = part.replace(/-/g, '+').replace(/_/g, '/')
    const pad = normalized.length % 4
    const padded = normalized + (pad ? '='.repeat(4 - pad) : '')
    return JSON.parse(base64ToUtf8(padded))
  }

  return JSON.stringify(
    {
      header: decodePart(header),
      payload: decodePart(payload),
      signature: signature ?? '',
    },
    null,
    2,
  )
}

function EncoderDecoder() {
  const [input, setInput] = useState('')
  const [output, setOutput] = useState('')
  const [error, setError] = useState('')
  const [activeMode, setActiveMode] = useState<Mode | null>(null)

  function run(action: Mode) {
    try {
      setError('')
      setActiveMode(action)
      if (action === 'b64e') setOutput(utf8ToBase64(input))
      if (action === 'b64d') setOutput(base64ToUtf8(input))
      if (action === 'urle') setOutput(encodeURIComponent(input))
      if (action === 'urld') setOutput(decodeURIComponent(input))
      if (action === 'hexe') setOutput(stringToHex(input))
      if (action === 'hexd') setOutput(hexToString(input))
      if (action === 'bine') setOutput(stringToBinary(input))
      if (action === 'bind') setOutput(binaryToString(input))
      if (action === 'rot13') setOutput(runRot13(input))
      if (action === 'htmlE') setOutput(htmlEncode(input))
      if (action === 'htmlD') setOutput(htmlDecode(input))
      if (action === 'jwt') setOutput(jwtDecode(input))
    } catch {
      setError('Unable to process input with selected mode.')
      setOutput('')
    }
  }

  return (
    <div className="grid gap-4 lg:grid-cols-2">
      <Card className="space-y-3">
        <textarea rows={12} value={input} onChange={(event) => setInput(event.target.value)} className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm" />
        <div className="flex flex-wrap gap-2">
          <Button onClick={() => run('b64e')}>Base64 Encode</Button>
          <Button variant="secondary" onClick={() => run('b64d')}>Base64 Decode</Button>
          <Button variant="ghost" onClick={() => run('urle')}>URL Encode</Button>
          <Button variant="ghost" onClick={() => run('urld')}>URL Decode</Button>
          <Button variant="secondary" onClick={() => run('hexe')}>Hex Encode</Button>
          <Button variant="secondary" onClick={() => run('hexd')}>Hex Decode</Button>
          <Button variant="ghost" onClick={() => run('bine')}>Binary Encode</Button>
          <Button variant="ghost" onClick={() => run('bind')}>Binary Decode</Button>
          <Button variant="ghost" onClick={() => run('rot13')}>ROT13</Button>
          <Button variant="secondary" onClick={() => run('htmlE')}>HTML Encode</Button>
          <Button variant="secondary" onClick={() => run('htmlD')}>HTML Decode</Button>
          <Button variant="ghost" onClick={() => run('jwt')}>JWT Decode</Button>
        </div>
      </Card>
      <Card className="space-y-2">
        <textarea rows={12} readOnly value={output} className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm" />
        {activeMode ? <p className="text-xs text-its-text-secondary">Mode: {activeMode}</p> : null}
        {error ? <p className="text-sm text-its-status-error">{error}</p> : null}
      </Card>
    </div>
  )
}

export default EncoderDecoder
