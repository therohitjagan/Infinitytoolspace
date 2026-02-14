import { Link } from 'react-router-dom'
import Button from '../ui/Button'
import Container from '../layout/Container'

function Hero() {
  return (
    <section className="relative overflow-hidden pb-16 pt-14">
      <div className="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-its-accent-cyan/20 blur-3xl" />
      <div className="pointer-events-none absolute -right-24 top-20 h-72 w-72 rounded-full bg-its-accent-purple/20 blur-3xl" />
      <Container className="relative">
        <div className="mx-auto max-w-3xl text-center">
          <p className="mb-4 inline-flex rounded-full border border-its-accent-cyan/30 bg-its-accent-cyan/10 px-3 py-1 text-xs uppercase tracking-[0.2em] text-its-accent-cyan">
            Gen-Z Futuristic Toolkit
          </p>
          <h1 className="font-display text-4xl tracking-wide sm:text-5xl lg:text-6xl">
            Build, convert, and optimize with <span className="text-gradient">InfinityToolSpace</span>
          </h1>
          <p className="mx-auto mt-5 max-w-2xl text-sm text-its-text-secondary sm:text-base">
            Privacy-first utilities for PDF, image, text, and advanced converters. Fast, modern, and
            fully in-browser.
          </p>
          <div className="mt-8 flex flex-wrap items-center justify-center gap-3">
            <Link to="/category/pdf">
              <Button>Explore Tools</Button>
            </Link>
            <Link to="/about">
              <Button variant="secondary">How It Works</Button>
            </Link>
          </div>
        </div>
      </Container>
    </section>
  )
}

export default Hero