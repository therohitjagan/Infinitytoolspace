import QRCode from 'qrcode'
import { useEffect, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'
import { useAppToast } from '../../hooks/useAppToast'

type ContentType = 'text' | 'url' | 'email' | 'phone' | 'sms' | 'wifi'
type Ecc = 'L' | 'M' | 'Q' | 'H'

function buildContent(type: ContentType, value: string, wifiSsid: string, wifiPassword: string, wifiSecurity: string) {
  if (type === 'email') return `mailto:${value}`
  if (type === 'phone') return `tel:${value}`
  if (type === 'sms') return `sms:${value}`
  if (type === 'wifi') return `WIFI:T:${wifiSecurity};S:${wifiSsid};P:${wifiPassword};;`
  return value
}

function QRGenerator() {
  const { pushToast } = useAppToast()
  const [value, setValue] = useState('https://infinitytoolspace.dev')
  const [contentType, setContentType] = useState<ContentType>('url')
  const [size, setSize] = useState(256)
  const [margin, setMargin] = useState(1)
  const [ecc, setEcc] = useState<Ecc>('M')
  const [darkColor, setDarkColor] = useState('#e4e4f0')
  const [lightColor, setLightColor] = useState('#0a0e27')
  const [wifiSsid, setWifiSsid] = useState('')
  const [wifiPassword, setWifiPassword] = useState('')
  const [wifiSecurity, setWifiSecurity] = useState('WPA')
  const [qrDataUrl, setQrDataUrl] = useState<string | null>(null)
  const [qrSvg, setQrSvg] = useState<string | null>(null)
  const [error, setError] = useState<string | null>(null)

  const payload = buildContent(contentType, value, wifiSsid, wifiPassword, wifiSecurity)

  useEffect(() => {
    let isMounted = true

    async function generate() {
      try {
        const dataUrl = await QRCode.toDataURL(payload || ' ', {
          width: size,
          margin,
          errorCorrectionLevel: ecc,
          color: {
            dark: darkColor,
            light: lightColor,
          },
        })
        const svg = await QRCode.toString(payload || ' ', {
          type: 'svg',
          margin,
          width: size,
          errorCorrectionLevel: ecc,
          color: {
            dark: darkColor,
            light: lightColor,
          },
        })
        if (isMounted) {
          setQrDataUrl(dataUrl)
          setQrSvg(svg)
          setError(null)
        }
      } catch {
        if (isMounted) {
          setError('Could not generate QR code for this input.')
          setQrDataUrl(null)
          setQrSvg(null)
        }
      }
    }

    generate()

    return () => {
      isMounted = false
    }
  }, [darkColor, ecc, lightColor, margin, payload, size])

  function downloadPng() {
    if (!qrDataUrl) {
      return
    }

    const link = document.createElement('a')
    link.href = qrDataUrl
    link.download = 'qrcode.png'
    link.click()
    pushToast({
      type: 'success',
      title: 'QR downloaded',
      message: 'Saved as qrcode.png',
    })
  }

  function downloadSvg() {
    if (!qrSvg) return
    const blob = new Blob([qrSvg], { type: 'image/svg+xml;charset=utf-8' })
    const link = document.createElement('a')
    link.href = URL.createObjectURL(blob)
    link.download = 'qrcode.svg'
    link.click()
    URL.revokeObjectURL(link.href)
    pushToast({
      type: 'success',
      title: 'QR downloaded',
      message: 'Saved as qrcode.svg',
    })
  }

  return (
    <div className="grid gap-4 lg:grid-cols-2">
      <Card className="space-y-4">
        <label className="block space-y-2 text-sm">
          <span className="text-its-text-secondary">Content Type</span>
          <select
            value={contentType}
            onChange={(event) => setContentType(event.target.value as ContentType)}
            className="focus-ring w-full rounded-xl border border-white/20 bg-white/5 p-2"
          >
            <option value="url">URL</option>
            <option value="text">Text</option>
            <option value="email">Email</option>
            <option value="phone">Phone</option>
            <option value="sms">SMS</option>
            <option value="wifi">WiFi</option>
          </select>
        </label>

        <label className="block space-y-2 text-sm">
          <span className="text-its-text-secondary">Content</span>
          <textarea
            rows={6}
            value={value}
            onChange={(event) => setValue(event.target.value)}
            className="focus-ring w-full rounded-xl border border-white/20 bg-white/5 p-3"
          />
        </label>

        {contentType === 'wifi' ? (
          <div className="grid gap-2 sm:grid-cols-3">
            <input
              value={wifiSsid}
              onChange={(event) => setWifiSsid(event.target.value)}
              placeholder="WiFi SSID"
              className="focus-ring rounded-xl border border-white/20 bg-white/5 p-2"
            />
            <input
              value={wifiPassword}
              onChange={(event) => setWifiPassword(event.target.value)}
              placeholder="WiFi password"
              className="focus-ring rounded-xl border border-white/20 bg-white/5 p-2"
            />
            <select
              value={wifiSecurity}
              onChange={(event) => setWifiSecurity(event.target.value)}
              className="focus-ring rounded-xl border border-white/20 bg-white/5 p-2"
            >
              <option value="WPA">WPA/WPA2</option>
              <option value="WEP">WEP</option>
              <option value="nopass">Open</option>
            </select>
          </div>
        ) : null}

        <label className="block space-y-2 text-sm">
          <span className="text-its-text-secondary">Size: {size}px</span>
          <input
            type="range"
            min={128}
            max={512}
            step={16}
            value={size}
            onChange={(event) => setSize(Number(event.target.value))}
            className="w-full"
          />
        </label>

        <div className="grid gap-2 sm:grid-cols-2">
          <label className="space-y-1 text-sm text-its-text-secondary">
            Margin
            <input type="number" min={0} max={8} value={margin} onChange={(event) => setMargin(Math.max(0, Math.min(8, Number(event.target.value) || 0)))} className="focus-ring w-full rounded-xl border border-white/20 bg-white/5 p-2" />
          </label>
          <label className="space-y-1 text-sm text-its-text-secondary">
            Error correction
            <select value={ecc} onChange={(event) => setEcc(event.target.value as Ecc)} className="focus-ring w-full rounded-xl border border-white/20 bg-white/5 p-2">
              <option value="L">L (7%)</option>
              <option value="M">M (15%)</option>
              <option value="Q">Q (25%)</option>
              <option value="H">H (30%)</option>
            </select>
          </label>
        </div>

        <div className="grid gap-2 sm:grid-cols-2">
          <label className="space-y-1 text-sm text-its-text-secondary">
            Foreground
            <input type="color" value={darkColor} onChange={(event) => setDarkColor(event.target.value)} className="h-10 w-full rounded border border-white/20 bg-transparent" />
          </label>
          <label className="space-y-1 text-sm text-its-text-secondary">
            Background
            <input type="color" value={lightColor} onChange={(event) => setLightColor(event.target.value)} className="h-10 w-full rounded border border-white/20 bg-transparent" />
          </label>
        </div>

        <div className="flex flex-wrap gap-2">
          <Button onClick={downloadPng} disabled={!qrDataUrl}>
            Download PNG
          </Button>
          <Button variant="secondary" onClick={downloadSvg} disabled={!qrSvg}>
            Download SVG
          </Button>
          <Button
            variant="ghost"
            onClick={() =>
              setValue('https://infinitytoolspace.dev/tools/qr-code-generator?from=share')
            }
          >
            Load sample URL
          </Button>
        </div>
      </Card>

      <Card className="flex items-center justify-center">
        {error ? <p className="text-sm text-its-status-error">{error}</p> : null}
        {qrDataUrl ? <img src={qrDataUrl} alt="Generated QR code" className="rounded-xl" /> : null}
      </Card>
    </div>
  )
}

export default QRGenerator
