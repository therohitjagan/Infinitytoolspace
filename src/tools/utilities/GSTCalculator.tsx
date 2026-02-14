import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

type GstMode = 'exclusive' | 'inclusive'

function GSTCalculator() {
  const [amount, setAmount] = useState(1000)
  const [rate, setRate] = useState(18)
  const [quantity, setQuantity] = useState(1)
  const [mode, setMode] = useState<GstMode>('exclusive')
  const [isInterState, setIsInterState] = useState(false)
  const [roundOff, setRoundOff] = useState(true)

  const calculations = useMemo(() => {
    const grossInput = amount * quantity
    const taxable = mode === 'exclusive' ? grossInput : grossInput / (1 + rate / 100)
    const gst = taxable * (rate / 100)
    const total = taxable + gst
    const cgst = isInterState ? 0 : gst / 2
    const sgst = isInterState ? 0 : gst / 2
    const igst = isInterState ? gst : 0
    const formatter = (value: number) => (roundOff ? Number(value.toFixed(2)) : value)

    return {
      taxable: formatter(taxable),
      gst: formatter(gst),
      total: formatter(total),
      cgst: formatter(cgst),
      sgst: formatter(sgst),
      igst: formatter(igst),
      perUnitTaxable: formatter(taxable / Math.max(1, quantity)),
      perUnitTotal: formatter(total / Math.max(1, quantity)),
    }
  }, [amount, isInterState, mode, quantity, rate, roundOff])

  return (
    <Card className="space-y-4">
      <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
        <input type="number" value={amount} onChange={(event) => setAmount(Math.max(0, Number(event.target.value) || 0))} placeholder="Amount" className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2" />
        <input type="number" value={rate} onChange={(event) => setRate(Math.max(0, Number(event.target.value) || 0))} placeholder="GST %" className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2" />
        <input type="number" value={quantity} onChange={(event) => setQuantity(Math.max(1, Number(event.target.value) || 1))} placeholder="Qty" className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2" />
        <select value={mode} onChange={(event) => setMode(event.target.value as GstMode)} className="focus-ring rounded-xl border border-white/15 bg-white/5 p-2">
          <option value="exclusive">Amount is Tax Exclusive</option>
          <option value="inclusive">Amount is Tax Inclusive</option>
        </select>
      </div>

      <div className="flex flex-wrap gap-2">
        {[0, 3, 5, 12, 18, 28].map((slab) => (
          <Button key={slab} variant={rate === slab ? 'primary' : 'ghost'} onClick={() => setRate(slab)}>
            {slab}%
          </Button>
        ))}
      </div>

      <div className="grid gap-2 sm:grid-cols-2 text-sm">
        <label><input type="checkbox" checked={isInterState} onChange={(event) => setIsInterState(event.target.checked)} /> Inter-state supply (IGST)</label>
        <label><input type="checkbox" checked={roundOff} onChange={(event) => setRoundOff(event.target.checked)} /> Round values to 2 decimals</label>
      </div>

      <div className="grid gap-2 sm:grid-cols-2">
        <p className="rounded-xl border border-white/15 p-2 text-sm">Taxable Value: {calculations.taxable.toFixed(2)}</p>
        <p className="rounded-xl border border-white/15 p-2 text-sm">GST Amount: {calculations.gst.toFixed(2)}</p>
        <p className="rounded-xl border border-white/15 p-2 text-sm">Total (Incl GST): {calculations.total.toFixed(2)}</p>
        <p className="rounded-xl border border-white/15 p-2 text-sm">Per Unit Total: {calculations.perUnitTotal.toFixed(2)}</p>
        <p className="rounded-xl border border-white/15 p-2 text-sm">Per Unit Taxable: {calculations.perUnitTaxable.toFixed(2)}</p>
        <p className="rounded-xl border border-white/15 p-2 text-sm">CGST: {calculations.cgst.toFixed(2)} • SGST: {calculations.sgst.toFixed(2)} • IGST: {calculations.igst.toFixed(2)}</p>
      </div>
    </Card>
  )
}

export default GSTCalculator
