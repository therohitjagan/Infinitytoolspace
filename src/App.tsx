import { BrowserRouter, Route, Routes } from 'react-router-dom'
import AnimatedBackground from './components/layout/AnimatedBackground'
import Footer from './components/layout/Footer'
import Header from './components/layout/Header'
import { ToastProvider } from './components/ui/ToastProvider'
import About from './pages/About'
import Contact from './pages/Contact'
import Home from './pages/Home'
import PrivacyTerms from './pages/PrivacyTerms'
import ToolCategory from './pages/ToolCategory'
import ToolPage from './pages/ToolPage'

function App() {
  return (
    <BrowserRouter>
      <a href="#main-content" className="skip-link">
        Skip to main content
      </a>
      <ToastProvider>
        <div className="min-h-screen bg-its-bg-primary text-its-text-primary">
          <AnimatedBackground />
          <Header />
          <main id="main-content">
            <Routes>
              <Route path="/" element={<Home />} />
              <Route path="/about" element={<About />} />
              <Route path="/contact" element={<Contact />} />
              <Route path="/privacy-terms" element={<PrivacyTerms />} />
              <Route path="/category/:category" element={<ToolCategory />} />
              <Route path="/tool/:toolId" element={<ToolPage />} />
            </Routes>
          </main>
          <Footer />
        </div>
      </ToastProvider>
    </BrowserRouter>
  )
}

export default App
