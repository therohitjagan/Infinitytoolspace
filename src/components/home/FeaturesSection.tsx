import Card from '../ui/Card'

const featureItems = [
  {
    title: 'Privacy-first by default',
    description: 'File processing is designed for in-browser execution whenever possible.',
  },
  {
    title: 'High performance architecture',
    description: 'Vite + route-based structure with lightweight reusable components.',
  },
  {
    title: 'Accessibility built in',
    description: 'Keyboard focus states, ARIA labels, and reduced-motion support from day one.',
  },
]

function FeaturesSection() {
  return (
    <section className="space-y-4">
      <h2 className="font-display text-2xl tracking-wide">Core Features</h2>
      <div className="grid gap-4 md:grid-cols-3">
        {featureItems.map((feature) => (
          <Card key={feature.title}>
            <h3 className="font-display text-lg">{feature.title}</h3>
            <p className="mt-2 text-sm text-its-text-secondary">{feature.description}</p>
          </Card>
        ))}
      </div>
    </section>
  )
}

export default FeaturesSection