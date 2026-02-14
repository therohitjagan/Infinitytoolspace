import { Link } from 'react-router-dom'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

const pdfRoutes = [
  { label: 'PDF Merger', route: '/tool/pdf-merger' },
  { label: 'PDF Splitter', route: '/tool/pdf-splitter' },
  { label: 'PDF Compressor', route: '/tool/pdf-compressor' },
  { label: 'PDF to Image', route: '/tool/pdf-to-image' },
  { label: 'Image to PDF', route: '/tool/image-to-pdf' },
]

function PDFToolHub() {
  return (
    <Card className="space-y-4">
      <p className="text-sm text-its-text-secondary">Choose a PDF workflow:</p>
      <div className="flex flex-wrap gap-2">
        {pdfRoutes.map((item) => (
          <Link key={item.route} to={item.route}>
            <Button variant="ghost">{item.label}</Button>
          </Link>
        ))}
      </div>
    </Card>
  )
}

export default PDFToolHub
