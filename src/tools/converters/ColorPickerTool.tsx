import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

function hexToRgb(hex: string) {
  const value = hex.replace('#', '')
  const r = Number.parseInt(value.slice(0, 2), 16)
  const g = Number.parseInt(value.slice(2, 4), 16)
  const b = Number.parseInt(value.slice(4, 6), 16)
  return { r, g, b }
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

function rotateHue(hue: number, by: number) {
  return (hue + by + 360) % 360
}

function ColorPickerTool() {
  const [hex, setHex] = useState('#00f5ff')
  const [alpha, setAlpha] = useState(1)
  const [angle, setAngle] = useState(135)
  const rgb = useMemo(() => hexToRgb(hex), [hex])
  const hsl = useMemo(() => {
    const r = rgb.r / 255
    const g = rgb.g / 255
    const b = rgb.b / 255
    const max = Math.max(r, g, b)
    const min = Math.min(r, g, b)
    const delta = max - min
    let h = 0
    const l = (max + min) / 2
    const s = delta === 0 ? 0 : delta / (1 - Math.abs(2 * l - 1))
    if (delta !== 0) {
      if (max === r) h = 60 * (((g - b) / delta) % 6)
      if (max === g) h = 60 * ((b - r) / delta + 2)
      if (max === b) h = 60 * ((r - g) / delta + 4)
    }
    return { h: Math.round((h + 360) % 360), s: Math.round(s * 100), l: Math.round(l * 100) }
  }, [rgb])

  const rgba = useMemo(() => `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, ${alpha.toFixed(2)})`, [alpha, rgb])
  const complementary = useMemo(() => hslToHex(rotateHue(hsl.h, 180), hsl.s, hsl.l), [hsl])
  const triadA = useMemo(() => hslToHex(rotateHue(hsl.h, 120), hsl.s, hsl.l), [hsl])
  const triadB = useMemo(() => hslToHex(rotateHue(hsl.h, -120), hsl.s, hsl.l), [hsl])
  const gradientCss = useMemo(
    () => `linear-gradient(${angle}deg, ${hex} 0%, ${complementary} 100%)`,
    [angle, complementary, hex],
  )

  return (
    <Card className="space-y-4">
      <div className="grid gap-3 sm:grid-cols-2">
        <input type="color" value={hex} onChange={(event) => setHex(event.target.value)} className="h-20 w-full rounded-xl border border-white/15 bg-transparent" />
        <label className="space-y-2 text-sm">
          <span className="text-its-text-secondary">Opacity: {(alpha * 100).toFixed(0)}%</span>
          <input type="range" min={0} max={1} step={0.01} value={alpha} onChange={(event) => setAlpha(Number(event.target.value))} className="w-full" />
        </label>
      </div>

      <div className="grid gap-2 sm:grid-cols-4">
        <div className="rounded-xl border border-white/15 p-3 text-sm">HEX: {hex}</div>
        <div className="rounded-xl border border-white/15 p-3 text-sm">RGB: {rgb.r}, {rgb.g}, {rgb.b}</div>
        <div className="rounded-xl border border-white/15 p-3 text-sm">HSL: {hsl.h}, {hsl.s}%, {hsl.l}%</div>
        <div className="rounded-xl border border-white/15 p-3 text-sm">RGBA: {rgba}</div>
      </div>

      <div className="grid gap-2 sm:grid-cols-3">
        {[{ label: 'Base', value: hex }, { label: 'Complementary', value: complementary }, { label: 'Triad A', value: triadA }, { label: 'Triad B', value: triadB }].map((item) => (
          <button
            key={item.label}
            className="focus-ring rounded-xl border border-white/15 p-3 text-left text-sm"
            onClick={() => navigator.clipboard.writeText(item.value)}
          >
            <span className="mb-2 block h-10 rounded" style={{ backgroundColor: item.value }} />
            {item.label}: {item.value}
          </button>
        ))}
      </div>

      <label className="block space-y-2 text-sm text-its-text-secondary">
        Gradient Angle: {angle}°
        <input type="range" min={0} max={360} step={1} value={angle} onChange={(event) => setAngle(Number(event.target.value))} className="w-full" />
      </label>

      <div className="h-24 rounded-xl border border-white/15" style={{ background: gradientCss }} />

      <div className="flex flex-wrap gap-2">
        <Button variant="secondary" onClick={() => navigator.clipboard.writeText(hex)}>Copy HEX</Button>
        <Button variant="ghost" onClick={() => navigator.clipboard.writeText(rgba)}>Copy RGBA</Button>
        <Button variant="ghost" onClick={() => navigator.clipboard.writeText(gradientCss)}>Copy Gradient CSS</Button>
        <Button onClick={() => setHex(`#${Math.floor(Math.random() * 0xffffff).toString(16).padStart(6, '0')}`)}>
          Random Color
        </Button>
      </div>
    </Card>
  )
}

export default ColorPickerTool
