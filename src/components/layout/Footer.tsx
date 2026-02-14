import { Link } from 'react-router-dom'
import Container from './Container'

function Footer() {
  return (
    <footer className="border-t border-white/10 py-10">
      <Container className="flex flex-col items-center justify-between gap-4 text-sm text-its-text-secondary md:flex-row">
        <p>© {new Date().getFullYear()} InfinityToolSpace</p>
        <div className="flex items-center gap-4">
          <Link to="/contact" className="hover:text-its-text-primary">
            Contact
          </Link>
          <Link to="/privacy-terms" className="hover:text-its-text-primary">
            Privacy & Terms
          </Link>
        </div>
      </Container>
    </footer>
  )
}

export default Footer