import { lazy, Suspense, type ComponentType, useEffect, useMemo } from 'react'
import { Link, useParams } from 'react-router-dom'
import { useRecentTools } from '../hooks/useRecentTools'
import Container from '../components/layout/Container'
import Button from '../components/ui/Button'
import Card from '../components/ui/Card'
import { getToolBySlug, toolsData, type ToolImplementationKey } from '../lib/toolsData'
import GenericToolWorkspace from '../tools/GenericToolWorkspace'
const PDFMerger = lazy(() => import('../tools/pdf/PDFMerger'))
const PDFSplitter = lazy(() => import('../tools/pdf/PDFSplitter'))
const PDFCompressor = lazy(() => import('../tools/pdf/PDFCompressor'))
const PDFToImageTool = lazy(() => import('../tools/pdf/PDFToImageTool'))
const ImageToPDF = lazy(() => import('../tools/pdf/ImageToPDF'))
const PDFToolHub = lazy(() => import('../tools/pdf/PDFToolHub'))
const WordCounter = lazy(() => import('../tools/text/WordCounter'))
const Notepad = lazy(() => import('../tools/text/Notepad'))
const FontGenerator = lazy(() => import('../tools/text/FontGenerator'))
const ImageCompressor = lazy(() => import('../tools/image/ImageCompressor'))
const ImageResizerTool = lazy(() => import('../tools/image/ImageResizerTool'))
const ImageToColorTool = lazy(() => import('../tools/image/ImageToColorTool'))
const JSONFormatter = lazy(() => import('../tools/converters/JSONFormatter'))
const EncoderDecoder = lazy(() => import('../tools/converters/EncoderDecoder'))
const ColorPickerTool = lazy(() => import('../tools/converters/ColorPickerTool'))
const PaletteGenerator = lazy(() => import('../tools/converters/PaletteGenerator'))
const FormatterTool = lazy(() => import('../tools/converters/FormatterTool'))
const UnitConverter = lazy(() => import('../tools/converters/UnitConverter'))
const QRGenerator = lazy(() => import('../tools/utilities/QRGenerator'))
const PasswordGenerator = lazy(() => import('../tools/utilities/PasswordGenerator'))
const EmailObfuscator = lazy(() => import('../tools/utilities/EmailObfuscator'))
const DateCalculator = lazy(() => import('../tools/utilities/DateCalculator'))
const GSTCalculator = lazy(() => import('../tools/utilities/GSTCalculator'))
const PrivacyPolicyGenerator = lazy(() => import('../tools/legal/PrivacyPolicyGenerator'))
const TermsConditionGenerator = lazy(() => import('../tools/legal/TermsConditionGenerator'))
const PlayStorePolicyGenerator = lazy(() => import('../tools/legal/PlayStorePolicyGenerator'))
const SemxyGames = lazy(() => import('../tools/games/SemxyGames'))

const toolComponents: Partial<Record<ToolImplementationKey, ComponentType>> = {
  'pdf-merger': PDFMerger,
  'pdf-splitter': PDFSplitter,
  'pdf-compressor': PDFCompressor,
  'pdf-to-image': PDFToImageTool,
  'image-to-pdf': ImageToPDF,
  'pdf-tool': PDFToolHub,
  'word-counter': WordCounter,
  notepad: Notepad,
  'font-generator': FontGenerator,
  'image-compressor': ImageCompressor,
  'image-resizer': ImageResizerTool,
  'image-to-color': ImageToColorTool,
  'json-formatter': JSONFormatter,
  'encoder-decoder': EncoderDecoder,
  'color-picker': ColorPickerTool,
  'palette-generator': PaletteGenerator,
  'formatter-tool': FormatterTool,
  'unit-converter': UnitConverter,
  'qr-generator': QRGenerator,
  'password-generator': PasswordGenerator,
  'email-obfuscator': EmailObfuscator,
  'date-calculator': DateCalculator,
  'gst-calculator': GSTCalculator,
  'privacy-policy-generator': PrivacyPolicyGenerator,
  'terms-condition-generator': TermsConditionGenerator,
  'pp-generator': PlayStorePolicyGenerator,
  'semxy-games': SemxyGames,
}

function ToolPage() {
  const { toolId = '' } = useParams()
  const { addRecentTool } = useRecentTools()

  const tool = useMemo(() => getToolBySlug(toolId), [toolId])

  useEffect(() => {
    if (tool?.id) {
      addRecentTool(tool.id)
    }
  }, [addRecentTool, tool?.id])

  const ToolComponent = tool?.implementationKey ? toolComponents[tool.implementationKey] : undefined

  const relatedTools = useMemo(() => {
    if (!tool) {
      return []
    }

    return toolsData.filter((item) => item.category === tool.category && item.id !== tool.id).slice(0, 3)
  }, [tool])

  return (
    <Container className="pb-20 pt-6">
      <Card className="space-y-4">
        <h1 className="font-display text-3xl tracking-wide">{tool?.name ?? 'Tool not found'}</h1>
        <p className="text-its-text-secondary">
          {tool?.description ?? 'This tool is not configured yet.'}
        </p>

        {ToolComponent ? (
          <Suspense
            fallback={
              <div className="rounded-xl border border-dashed border-white/20 p-6 text-sm text-its-text-secondary">
                Loading tool workspace...
              </div>
            }
          >
            <ToolComponent />
          </Suspense>
        ) : (
          tool ? <GenericToolWorkspace tool={tool} /> : null
        )}

        {relatedTools.length ? (
          <div className="space-y-3">
            <p className="text-sm font-semibold text-its-text-secondary">Related tools</p>
            <div className="flex flex-wrap gap-2">
              {relatedTools.map((item) => (
                <Link key={item.id} to={item.route}>
                  <Button variant="ghost">{item.name}</Button>
                </Link>
              ))}
            </div>
          </div>
        ) : null}

      </Card>
    </Container>
  )
}

export default ToolPage