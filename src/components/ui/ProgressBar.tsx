interface ProgressBarProps {
  value: number
  label?: string
}

function ProgressBar({ value, label }: ProgressBarProps) {
  const clamped = Math.max(0, Math.min(100, value))

  return (
    <div className="space-y-1">
      {label ? <p className="text-xs text-its-text-secondary">{label}</p> : null}
      <div className="h-2 w-full rounded-full bg-white/10">
        <div
          className="h-2 rounded-full bg-its-accent-cyan transition-all duration-300"
          style={{ width: `${clamped}%` }}
        />
      </div>
      <p className="text-right text-[11px] text-its-text-secondary">{clamped.toFixed(0)}%</p>
    </div>
  )
}

export default ProgressBar
