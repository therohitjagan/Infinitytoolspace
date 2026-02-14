import { Facebook, Github, Instagram, Linkedin, Mail, Send } from 'lucide-react'
import { type FormEvent, useState } from 'react'
import Container from '../components/layout/Container'
import Button from '../components/ui/Button'
import Card from '../components/ui/Card'
import Input from '../components/ui/Input'
import { useAppToast } from '../hooks/useAppToast'
import { siteConfig } from '../lib/siteConfig'

function Contact() {
  const { pushToast } = useAppToast()
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [message, setMessage] = useState('')

  function submitContact(event: FormEvent) {
    event.preventDefault()

    const subject = encodeURIComponent(`InfinityToolSpace Contact from ${name || 'Visitor'}`)
    const body = encodeURIComponent(`Name: ${name}\nEmail: ${email}\n\n${message}`)
    window.open(`mailto:${siteConfig.contactEmail}?subject=${subject}&body=${body}`, '_blank')

    pushToast({
      type: 'success',
      title: 'Contact draft opened',
      message: 'Your email client should open with prefilled details.',
    })
  }

  return (
    <Container className="grid gap-4 pb-20 pt-6 lg:grid-cols-3">
      <Card className="space-y-3 lg:col-span-2">
        <h1 className="font-display text-3xl tracking-wide">Contact Us</h1>
        <p className="text-sm text-its-text-secondary">
          Have a collaboration idea, tool request, project feedback, or partnership proposal? Send
          a message and let’s build something impactful.
        </p>

        <form className="space-y-3" onSubmit={submitContact}>
          <Input value={name} onChange={(event) => setName(event.target.value)} placeholder="Your name" />
          <Input
            type="email"
            value={email}
            onChange={(event) => setEmail(event.target.value)}
            placeholder="Your email"
            required
          />
          <textarea
            value={message}
            onChange={(event) => setMessage(event.target.value)}
            placeholder="Your message"
            rows={8}
            required
            className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm"
          />
          <Button type="submit">
            <Send className="h-4 w-4" />
            Send Message
          </Button>
        </form>
      </Card>

      <Card className="space-y-3">
        <h2 className="font-display text-xl tracking-wide">Support</h2>
        <p className="inline-flex items-center gap-2 text-sm text-its-text-secondary">
          <Mail className="h-4 w-4" />
          {siteConfig.contactEmail}
        </p>
        <p className="text-xs text-its-text-secondary">Also connect on social profiles</p>
        <div className="grid gap-2 text-sm">
          <a
            href="https://github.com/therohitjagan"
            target="_blank"
            rel="noreferrer"
            className="inline-flex items-center gap-2 rounded-lg border border-white/15 px-2 py-1 text-its-text-secondary hover:text-its-text-primary"
          >
            <Github className="h-4 w-4" />
            github.com/therohitjagan
          </a>
          <a
            href="https://linkedin.com/in/therohitjagan"
            target="_blank"
            rel="noreferrer"
            className="inline-flex items-center gap-2 rounded-lg border border-white/15 px-2 py-1 text-its-text-secondary hover:text-its-text-primary"
          >
            <Linkedin className="h-4 w-4" />
            linkedin.com/in/therohitjagan
          </a>
          <a
            href="https://instagram.com/jagan.ai"
            target="_blank"
            rel="noreferrer"
            className="inline-flex items-center gap-2 rounded-lg border border-white/15 px-2 py-1 text-its-text-secondary hover:text-its-text-primary"
          >
            <Instagram className="h-4 w-4" />
            instagram.com/jagan.ai
          </a>
          <a
            href="https://facebook.com/therohitjagan"
            target="_blank"
            rel="noreferrer"
            className="inline-flex items-center gap-2 rounded-lg border border-white/15 px-2 py-1 text-its-text-secondary hover:text-its-text-primary"
          >
            <Facebook className="h-4 w-4" />
            facebook.com/therohitjagan
          </a>
        </div>
      </Card>
    </Container>
  )
}

export default Contact
