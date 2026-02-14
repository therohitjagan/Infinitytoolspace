import Card from '../ui/Card'

const stats = [
  { label: 'Planned tools', value: '40+' },
  { label: 'Client-side focused', value: '100%' },
  { label: 'Core categories', value: '5' },
  { label: 'Theme modes', value: '2' },
]

function StatsSection() {
  return (
    <section className="space-y-4">
      <h2 className="font-display text-2xl tracking-wide">Platform Snapshot</h2>
      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {stats.map((stat) => (
          <Card key={stat.label} glow>
            <p className="font-display text-3xl text-its-accent-cyan">{stat.value}</p>
            <p className="text-sm text-its-text-secondary">{stat.label}</p>
          </Card>
        ))}
      </div>
    </section>
  )
}

export default StatsSection