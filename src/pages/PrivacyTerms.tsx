import Container from '../components/layout/Container'
import Card from '../components/ui/Card'

function PrivacyTerms() {
  return (
    <Container className="space-y-4 pb-20 pt-6">
      <Card className="space-y-3">
        <h1 className="font-display text-3xl tracking-wide">Privacy & Terms</h1>
        <p className="text-sm text-its-text-secondary">
          InfinityToolSpace is privacy-first. Most tools process data in your browser and avoid
          server-side storage unless explicitly stated.
        </p>
      </Card>

      <Card className="space-y-2">
        <h2 className="font-display text-xl tracking-wide">Privacy Policy</h2>
        <p className="text-sm text-its-text-secondary">
          We do not sell personal data. Local browser storage may be used for preferences, favorites,
          and recent tools to improve your experience.
        </p>
        <p className="text-sm text-its-text-secondary">
          Third-party external tools linked from this platform may have their own privacy policies.
        </p>
      </Card>

      <Card className="space-y-2">
        <h2 className="font-display text-xl tracking-wide">Terms & Conditions</h2>
        <p className="text-sm text-its-text-secondary">
          Tools are provided as-is without warranties. You are responsible for reviewing generated
          legal or policy content before publishing it.
        </p>
        <p className="text-sm text-its-text-secondary">
          By using this platform, you agree not to abuse the tools for unlawful activity.
        </p>
      </Card>
    </Container>
  )
}

export default PrivacyTerms
