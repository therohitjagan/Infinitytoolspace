function AnimatedBackground() {
  return (
    <div className="pointer-events-none fixed inset-0 -z-10 overflow-hidden" aria-hidden="true">
      <div
        className="absolute inset-0"
        style={{
          background:
            'radial-gradient(circle at 12% 12%, var(--its-glow-a), transparent 28%), radial-gradient(circle at 86% 18%, var(--its-glow-b), transparent 34%), radial-gradient(circle at 52% 84%, var(--its-glow-c), transparent 40%)',
        }}
      />
      <div className="absolute inset-0 animate-shimmer bg-its-gradient opacity-60" />

      {Array.from({ length: 14 }).map((_, index) => {
        const size = 4 + (index % 4) * 3
        const left = 6 + index * 7
        const top = 8 + (index % 5) * 16
        const delay = `${(index % 6) * 0.35}s`
        const duration = `${5 + (index % 4)}s`

        return (
          <span
            key={`particle-${left}-${top}`}
            className="absolute animate-float rounded-full bg-its-accent-cyan/40 blur-[1px]"
            style={{
              width: `${size}px`,
              height: `${size}px`,
              left: `${left}%`,
              top: `${top}%`,
              animationDelay: delay,
              animationDuration: duration,
            }}
          />
        )
      })}
    </div>
  )
}

export default AnimatedBackground