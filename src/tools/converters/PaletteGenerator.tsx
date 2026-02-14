import { useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

function randomHex() {
  return `#${Math.floor(Math.random() * 0xffffff)
    .toString(16)
    .padStart(6, '0')}`
}

function hexToHsl(hex: string) {
  const value = hex.replace('#', '')
  const r = Number.parseInt(value.slice(0, 2), 16) / 255
  const g = Number.parseInt(value.slice(2, 4), 16) / 255
  const b = Number.parseInt(value.slice(4, 6), 16) / 255
  const max = Math.max(r, g, b)
  const min = Math.min(r, g, b)
  const delta = max - min
  let h = 0
  const l = (max + min) / 2
  const s = delta === 0 ? 0 : delta / (1 - Math.abs(2 * l - 1))

  if (delta !== 0) {
    if (max === r) h = 60 * (((g - b) / delta) % 6)
    else if (max === g) h = 60 * ((b - r) / delta + 2)
    else h = 60 * ((r - g) / delta + 4)
  }

  return { h: (h + 360) % 360, s: s * 100, l: l * 100 }
}

function hslToHex(h: number, s: number, l: number) {
  const sat = s / 100
  const light = l / 100
  const chroma = (1 - Math.abs(2 * light - 1)) * sat
  const x = chroma * (1 - Math.abs(((h / 60) % 2) - 1))
  const m = light - chroma / 2
  let r = 0
  let g = 0
  let b = 0

  if (h < 60) [r, g, b] = [chroma, x, 0]
  else if (h < 120) [r, g, b] = [x, chroma, 0]
  else if (h < 180) [r, g, b] = [0, chroma, x]
  else if (h < 240) [r, g, b] = [0, x, chroma]
  else if (h < 300) [r, g, b] = [x, 0, chroma]
  else [r, g, b] = [chroma, 0, x]

  const toHex = (value: number) => Math.round((value + m) * 255).toString(16).padStart(2, '0')
  return `#${toHex(r)}${toHex(g)}${toHex(b)}`
}

type PaletteMode = 'random' | 'monochrome' | 'analogous' | 'complementary' | 'triadic'

function PaletteGenerator() {
  const [baseColor, setBaseColor] = useState('#6d5eff')
  const [mode, setMode] = useState<PaletteMode>('random')
  const [count, setCount] = useState(5)
  const [palette, setPalette] = useState(() => Array.from({ length: 5 }).map(() => randomHex()))

  function generatePalette() {
    if (mode === 'random') {
      setPalette(Array.from({ length: count }).map(() => randomHex()))
      return
    }

    const { h, s, l } = hexToHsl(baseColor)
    const next: string[] = []
    for (let index = 0; index < count; index += 1) {
      if (mode === 'monochrome') {
        next.push(hslToHex(h, s, Math.min(92, Math.max(12, 18 + (index * 74) / Math.max(1, count - 1)))))
      }
      if (mode === 'analogous') {
        const offset = ((index - (count - 1) / 2) * 30) % 360
        next.push(hslToHex((h + offset + 360) % 360, s, l))
      }
      if (mode === 'complementary') {
        next.push(hslToHex((h + (index % 2 === 0 ? 0 : 180)) % 360, s, Math.max(20, Math.min(85, l + (index - 2) * 8))))
      }
      if (mode === 'triadic') {
        next.push(hslToHex((h + (index % 3) * 120) % 360, s, Math.max(20, Math.min(85, l + (index - 2) * 7))))
      }
    }

    setPalette(next)
  }

  return (
    <Card className="space-y-4">
      <div className="grid gap-2 sm:grid-cols-3">
        <label className="space-y-1 text-xs text-its-text-secondary">
          Base color
          <input type="color" value={baseColor} onChange={(event) => setBaseColor(event.target.value)} className="h-10 w-full rounded border border-white/15 bg-transparent" />
        </label>
        <label className="space-y-1 text-xs text-its-text-secondary">
          Mode
          <select value={mode} onChange={(event) => setMode(event.target.value as PaletteMode)} className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2 text-sm">
            <option value="random">Random</option>
            <option value="monochrome">Monochrome</option>
            <option value="analogous">Analogous</option>
            <option value="complementary">Complementary</option>
            <option value="triadic">Triadic</option>
          </select>
        </label>
        <label className="space-y-1 text-xs text-its-text-secondary">
          Colors count
          <input type="number" min={3} max={12} value={count} onChange={(event) => setCount(Math.max(3, Math.min(12, Number(event.target.value) || 5)))} className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2 text-sm" />
        </label>
      </div>

      <div className="grid gap-2 sm:grid-cols-5">
        {palette.map((color, index) => (
          <button
            key={`${color}-${index}`}
            className="focus-ring h-24 rounded-xl border border-white/15"
            style={{ backgroundColor: color }}
            onClick={() => navigator.clipboard.writeText(color)}
            title={`Copy ${color}`}
          />
        ))}
      </div>

      <div className="flex flex-wrap gap-2">
        <Button onClick={generatePalette}>Generate Palette</Button>
        <Button variant="secondary" onClick={() => navigator.clipboard.writeText(palette.join(', '))}>
          Copy palette list
        </Button>
        <Button variant="ghost" onClick={() => navigator.clipboard.writeText(JSON.stringify(palette, null, 2))}>
          Copy JSON
        </Button>
      </div>
    </Card>
  )
}

export default PaletteGenerator
