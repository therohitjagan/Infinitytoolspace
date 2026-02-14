import { AnimatePresence, motion } from 'framer-motion'
import { Command, Moon, Sun } from 'lucide-react'
import { Menu, X } from 'lucide-react'
import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import { useTheme } from '../../hooks/useTheme'
import CommandPalette from '../ui/CommandPalette'
import Button from '../ui/Button'
import Container from './Container'

const navItems = [
  { path: '/', label: 'Home' },
  { path: '/category/all', label: 'Tools' },
  { path: '/about', label: 'About' },
  { path: '/contact', label: 'Contact' },
]

function Header() {
  const [isMobileNavOpen, setIsMobileNavOpen] = useState(false)
  const [isPaletteOpen, setIsPaletteOpen] = useState(false)
  const { theme, toggleTheme } = useTheme()

  useEffect(() => {
    function handleOpenPalette(event: KeyboardEvent) {
      if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
        event.preventDefault()
        setIsPaletteOpen((current) => !current)
      }

      if (event.key === 'Escape') {
        setIsPaletteOpen(false)
      }
    }

    window.addEventListener('keydown', handleOpenPalette)
    return () => window.removeEventListener('keydown', handleOpenPalette)
  }, [])

  function closeMobileNav() {
    setIsMobileNavOpen(false)
  }

  return (
    <>
      <header className="sticky top-0 z-40 border-b border-white/10 bg-its-bg-primary/70 backdrop-blur-xl">
        <Container className="flex h-20 items-center justify-between">
          <Link to="/" className="focus-ring flex items-center gap-2 rounded-lg px-2 py-1">
            <span className="animate-pulseSoft inline-flex h-2.5 w-2.5 rounded-full bg-its-accent-cyan" />
            <span className="font-display text-lg font-semibold tracking-wide text-gradient">
              InfinityToolSpace
            </span>
          </Link>

          <nav aria-label="Main navigation" className="hidden items-center gap-6 md:flex">
            {navItems.map((item) => (
              <Link
                key={item.path}
                to={item.path}
                className="focus-ring rounded-md px-2 py-1 text-sm text-its-text-secondary transition hover:text-its-text-primary"
              >
                {item.label}
              </Link>
            ))}
          </nav>

          <div className="flex items-center gap-2">
            <Button
              variant="ghost"
              aria-label="Open command palette"
              className="hidden sm:inline-flex"
              onClick={() => setIsPaletteOpen(true)}
            >
              <Command className="h-4 w-4" />
              <span>Ctrl+K</span>
            </Button>
            <Button variant="ghost" aria-label="Toggle theme" onClick={toggleTheme}>
              {theme === 'dark' ? <Sun className="h-4 w-4" /> : <Moon className="h-4 w-4" />}
            </Button>
            <Button
              variant="ghost"
              className="md:hidden"
              aria-label="Open mobile menu"
              onClick={() => setIsMobileNavOpen(true)}
            >
              <Menu className="h-4 w-4" />
            </Button>
          </div>
        </Container>
      </header>

      <AnimatePresence>
        {isMobileNavOpen ? (
          <motion.div
            className="fixed inset-0 z-50 bg-black/60 md:hidden"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            onClick={closeMobileNav}
          >
            <motion.aside
              className="glass-panel ml-auto flex h-full w-72 flex-col border-l border-white/20 p-4"
              initial={{ x: 300 }}
              animate={{ x: 0 }}
              exit={{ x: 300 }}
              transition={{ duration: 0.22, ease: 'easeOut' }}
              onClick={(event) => event.stopPropagation()}
            >
              <div className="mb-6 flex items-center justify-between">
                <p className="font-display text-lg text-its-text-primary">Menu</p>
                <Button variant="ghost" aria-label="Close mobile menu" onClick={closeMobileNav}>
                  <X className="h-4 w-4" />
                </Button>
              </div>
              <nav aria-label="Mobile navigation" className="space-y-2">
                {navItems.map((item) => (
                  <Link
                    key={item.path}
                    to={item.path}
                    className="focus-ring block rounded-xl border border-white/10 px-3 py-2 text-sm text-its-text-secondary transition hover:bg-white/10 hover:text-its-text-primary"
                    onClick={closeMobileNav}
                  >
                    {item.label}
                  </Link>
                ))}
              </nav>
            </motion.aside>
          </motion.div>
        ) : null}
      </AnimatePresence>

      <AnimatePresence>
        {isPaletteOpen ? <CommandPalette onClose={() => setIsPaletteOpen(false)} /> : null}
      </AnimatePresence>
    </>
  )
}

export default Header