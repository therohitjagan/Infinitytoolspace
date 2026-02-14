import { useMemo, useState } from 'react'
import Card from '../../components/ui/Card'

function DateCalculator() {
  const [start, setStart] = useState('')
  const [end, setEnd] = useState('')
  const [offset, setOffset] = useState(0)

  const diff = useMemo(() => {
    if (!start || !end) return null
    const startDate = new Date(start)
    const endDate = new Date(end)
    const ms = endDate.getTime() - startDate.getTime()
    return Math.round(ms / (1000 * 60 * 60 * 24))
  }, [start, end])

  const shifted = useMemo(() => {
    if (!start) return ''
    const date = new Date(start)
    date.setDate(date.getDate() + offset)
    return date.toISOString().slice(0, 10)
  }, [start, offset])

  return (
    <Card className="space-y-4">
      <div className="grid gap-3 sm:grid-cols-2">
        <input type="date" value={start} onChange={(event) => setStart(event.target.value)} className="focus-ring rounded-xl border border-white/15 bg-its-bg-secondary p-2" />
        <input type="date" value={end} onChange={(event) => setEnd(event.target.value)} className="focus-ring rounded-xl border border-white/15 bg-its-bg-secondary p-2" />
      </div>
      <p className="text-sm text-its-text-secondary">Difference: {diff ?? '—'} day(s)</p>
      <div className="grid gap-3 sm:grid-cols-2">
        <input type="number" value={offset} onChange={(event) => setOffset(Number(event.target.value))} className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2" />
        <div className="rounded-xl border border-white/15 p-2 text-sm">Result date: {shifted || '—'}</div>
      </div>
    </Card>
  )
}

export default DateCalculator
