import { useMemo, useState } from 'react'
import Card from '../../components/ui/Card'

const lengthUnits = { m: 1, km: 1000, cm: 0.01, in: 0.0254, ft: 0.3048 }
const weightUnits = { kg: 1, g: 0.001, lb: 0.453592, oz: 0.0283495 }

function UnitConverter() {
  const [type, setType] = useState<'length' | 'weight' | 'temperature'>('length')
  const [value, setValue] = useState(1)
  const [from, setFrom] = useState('m')
  const [to, setTo] = useState('km')

  const result = useMemo(() => {
    if (type === 'temperature') {
      if (from === to) return value
      if (from === 'c' && to === 'f') return (value * 9) / 5 + 32
      if (from === 'f' && to === 'c') return ((value - 32) * 5) / 9
      if (from === 'c' && to === 'k') return value + 273.15
      if (from === 'k' && to === 'c') return value - 273.15
      if (from === 'f' && to === 'k') return ((value - 32) * 5) / 9 + 273.15
      if (from === 'k' && to === 'f') return ((value - 273.15) * 9) / 5 + 32
      return value
    }

    const map = type === 'length' ? lengthUnits : weightUnits
    const fromRatio = map[from as keyof typeof map]
    const toRatio = map[to as keyof typeof map]
    return (value * fromRatio) / toRatio
  }, [type, value, from, to])

  const options =
    type === 'length' ? Object.keys(lengthUnits) : type === 'weight' ? Object.keys(weightUnits) : ['c', 'f', 'k']

  return (
    <Card className="space-y-4">
      <div className="flex flex-wrap gap-2">
        <button className="rounded-lg border border-white/15 px-3 py-1" onClick={() => { setType('length'); setFrom('m'); setTo('km') }}>Length</button>
        <button className="rounded-lg border border-white/15 px-3 py-1" onClick={() => { setType('weight'); setFrom('kg'); setTo('g') }}>Weight</button>
        <button className="rounded-lg border border-white/15 px-3 py-1" onClick={() => { setType('temperature'); setFrom('c'); setTo('f') }}>Temperature</button>
      </div>
      <div className="grid gap-3 sm:grid-cols-4">
        <input type="number" value={value} onChange={(event) => setValue(Number(event.target.value))} className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2" />
        <select value={from} onChange={(event) => setFrom(event.target.value)} className="focus-ring rounded-xl border border-white/15 bg-its-bg-secondary p-2">{options.map((option) => <option key={option} value={option}>{option}</option>)}</select>
        <select value={to} onChange={(event) => setTo(event.target.value)} className="focus-ring rounded-xl border border-white/15 bg-its-bg-secondary p-2">{options.map((option) => <option key={option} value={option}>{option}</option>)}</select>
        <div className="rounded-xl border border-white/15 p-2">{Number.isFinite(result) ? result.toFixed(4) : '—'}</div>
      </div>
    </Card>
  )
}

export default UnitConverter
