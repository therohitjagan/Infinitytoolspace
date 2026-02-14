import Container from '../components/layout/Container'
import Card from '../components/ui/Card'
import { siteConfig } from '../lib/siteConfig'

function About() {
  return (
    <Container className="grid gap-4 pb-20 pt-6 lg:grid-cols-3">
      <Card className="space-y-4 lg:col-span-2">
        <h1 className="font-display text-3xl tracking-wide">About {siteConfig.name}</h1>
        <p className="text-its-text-secondary">
          Built by {siteConfig.developerName}, {siteConfig.name} is a practical web toolkit focused
          on productivity, creativity, and developer-friendly utility workflows.
        </p>
        <p className="text-its-text-secondary">
          I’m a BCA student passionate about AI, ML, and full-stack product development. My work
          combines clean UX with useful tools that solve real-world daily problems for students,
          creators, and developers.
        </p>
        <p className="text-its-text-secondary">
          Core strengths include Java, Python, Kotlin, frontend engineering, and cloud-backed
          thinking. I enjoy building practical platforms, experimenting fast, and continuously
          improving user experience through feedback.
        </p>
      </Card>

      <Card className="space-y-3">
        <h2 className="font-display text-xl tracking-wide">Developer</h2>
        <p className="text-its-text-secondary">{siteConfig.developerName}</p>
        <p className="text-sm text-its-text-secondary">Full Stack Developer & UI/UX Enthusiast</p>
        <p className="text-sm text-its-text-secondary">BCA IOP (H) AI/ML • 2023 - 2027</p>
      </Card>

      <Card className="space-y-3 lg:col-span-3">
        <h2 className="font-display text-xl tracking-wide">Tech Stack</h2>
        <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
          {siteConfig.techStack.map((item) => (
            <div key={item} className="rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm">
              {item}
            </div>
          ))}
        </div>
      </Card>

      <Card className="space-y-3 lg:col-span-3">
        <h2 className="font-display text-xl tracking-wide">Featured Work</h2>
        <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
          {[
            'InfinityToolSpace: Web-based useful tools',
            'Image to Color Palette Generator',
            'Gemini with Kotlin App',
            'Toolify Android Utility App',
          ].map((project) => (
            <div key={project} className="rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm">
              {project}
            </div>
          ))}
        </div>
      </Card>
    </Container>
  )
}

export default About