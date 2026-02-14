import { Code2, FileText, Files, Gamepad2, ImageIcon, ScanSearch, Shield, Sparkles, type LucideIcon } from 'lucide-react'

export type ToolCategory = string

export type ToolImplementationKey =
  | 'pdf-merger'
  | 'pdf-splitter'
  | 'pdf-compressor'
  | 'pdf-to-image'
  | 'image-to-pdf'
  | 'word-counter'
  | 'notepad'
  | 'font-generator'
  | 'email-obfuscator'
  | 'image-compressor'
  | 'image-resizer'
  | 'image-to-color'
  | 'color-picker'
  | 'palette-generator'
  | 'json-formatter'
  | 'encoder-decoder'
  | 'formatter-tool'
  | 'unit-converter'
  | 'date-calculator'
  | 'gst-calculator'
  | 'password-generator'
  | 'qr-generator'
  | 'privacy-policy-generator'
  | 'terms-condition-generator'
  | 'pp-generator'
  | 'pdf-tool'
  | 'semxy-games'

export interface ToolItem {
  id: string
  slug: string
  name: string
  category: ToolCategory
  description: string
  shortDescription?: string
  title?: string
  keywords?: string
  image?: string
  implementationKey: ToolImplementationKey
  featured?: boolean
  route: string
  icon: LucideIcon
}

const categoryIcons: Record<string, LucideIcon> = {
  pdf: Files,
  text: FileText,
  image: ImageIcon,
  converters: ScanSearch,
  utilities: Sparkles,
  legal: Shield,
  games: Gamepad2,
}

function createTool(tool: Omit<ToolItem, 'route' | 'icon'>): ToolItem {
  return {
    ...tool,
    route: `/tool/${tool.slug}`,
    icon: categoryIcons[tool.category] ?? Code2,
  }
}

export const toolsData: ToolItem[] = [
  createTool({ id: 'pdf-merger', slug: 'pdf-merger', name: 'PDF Merger', category: 'pdf', description: 'Combine multiple PDF documents into a single file.', implementationKey: 'pdf-merger', featured: true }),
  createTool({ id: 'pdf-splitter', slug: 'pdf-splitter', name: 'PDF Splitter', category: 'pdf', description: 'Split PDF files into separate pages or custom ranges.', implementationKey: 'pdf-splitter' }),
  createTool({ id: 'pdf-compressor', slug: 'pdf-compressor', name: 'PDF Compressor', category: 'pdf', description: 'Reduce file size while maintaining quality.', implementationKey: 'pdf-compressor' }),
  createTool({ id: 'pdf-to-image', slug: 'pdf-to-image', name: 'PDF to Image', category: 'pdf', description: 'Convert PDF pages to JPG/PNG.', implementationKey: 'pdf-to-image' }),
  createTool({ id: 'image-to-pdf', slug: 'image-to-pdf', name: 'Image to PDF', category: 'pdf', description: 'Upload JPG/PNG and merge into one PDF.', implementationKey: 'image-to-pdf' }),
  createTool({ id: 'pdf-tool', slug: 'pdf-tool', name: 'PDFPro - Premium PDF Tools', category: 'pdf', description: 'Discover free, powerful tools for seamless PDF workflows.', implementationKey: 'pdf-tool' }),

  createTool({ id: 'word-counter', slug: 'word-counter', name: 'Word Counter', category: 'text', description: 'Count words, characters, and sentences in real time.', implementationKey: 'word-counter', featured: true }),
  createTool({ id: 'notepad', slug: 'notepad', name: 'Quick Online Notepad', category: 'text', description: 'Simple online notepad for instant note-taking and case conversion.', implementationKey: 'notepad', featured: true }),
  createTool({ id: 'font-generator', slug: 'font-generator', name: 'Stylish Font Generator', category: 'text', description: 'Generate unique and stylish fonts for social media.', implementationKey: 'font-generator' }),

  createTool({ id: 'image-compressor', slug: 'image-compressor', name: 'Image Compressor', category: 'image', description: 'Reduce image size with quality controls and previews.', implementationKey: 'image-compressor', featured: true }),
  createTool({ id: 'image-resizer', slug: 'image-resizer', name: 'Image Resizer', category: 'image', description: 'Resize images for social media and custom dimensions.', implementationKey: 'image-resizer' }),
  createTool({ id: 'image-to-color', slug: 'image-to-color', name: 'Image to Color', category: 'image', description: 'Extract and explore color values from uploaded images.', implementationKey: 'image-to-color' }),

  createTool({ id: 'json-formatter', slug: 'json-formatter', name: 'JSON Formatter', category: 'converters', description: 'Beautify and validate JSON with one click.', implementationKey: 'json-formatter', featured: true }),
  createTool({ id: 'encoder-decoder', slug: 'encoder-decoder', name: 'Encoder & Decoder', category: 'converters', description: 'Encode and decode text with Base64 and URL formats.', implementationKey: 'encoder-decoder' }),
  createTool({ id: 'color-picker', slug: 'color-picker', name: 'Color Picker', category: 'converters', description: 'Pick colors and copy RGB, HEX, and HSL values instantly.', implementationKey: 'color-picker' }),
  createTool({ id: 'palette-generator', slug: 'palette', name: 'Color Palette Generator', category: 'converters', description: 'Generate harmonious color palettes.', implementationKey: 'palette-generator' }),
  createTool({ id: 'formatter-tool', slug: 'formatter', name: 'Formatter Tool', category: 'converters', description: 'Beautify JSON, HTML, CSS, and JavaScript snippets.', implementationKey: 'formatter-tool' }),
  createTool({ id: 'unit-converter', slug: 'unit-converter', name: 'Unit Converter', category: 'converters', description: 'Convert length, weight, and temperature units.', implementationKey: 'unit-converter' }),

  createTool({ id: 'password-generator', slug: 'password-generator', name: 'Password Generator', category: 'utilities', description: 'Generate strong, secure passwords instantly.', implementationKey: 'password-generator', featured: true }),
  createTool({ id: 'qr-generator', slug: 'qr-generator', name: 'QR Generator', category: 'utilities', description: 'Generate high-quality QR codes in seconds.', implementationKey: 'qr-generator', featured: true }),
  createTool({ id: 'gst-calculator', slug: 'gst-calculator', name: 'GST Calculator', category: 'utilities', description: 'Add or remove GST from amounts instantly.', implementationKey: 'gst-calculator' }),
  createTool({ id: 'date-calculator', slug: 'date-calculator', name: 'Date Calculator', category: 'utilities', description: 'Calculate difference between dates and date arithmetic.', implementationKey: 'date-calculator' }),
  createTool({ id: 'email-obfuscator', slug: 'email-obfuscator', name: 'Email Obfuscator', category: 'utilities', description: 'Protect email addresses from spam bots.', implementationKey: 'email-obfuscator' }),

  createTool({ id: 'privacy-policy-generator', slug: 'privacy-policy-generator', name: 'Privacy Policy Generator', category: 'legal', description: 'Generate a custom privacy policy draft.', implementationKey: 'privacy-policy-generator' }),
  createTool({ id: 'terms-condition-generator', slug: 'terms-condition-generator', name: 'Terms & Conditions Generator', category: 'legal', description: 'Generate a terms and conditions draft.', implementationKey: 'terms-condition-generator' }),
  createTool({ id: 'pp-generator', slug: 'pp-generator', name: 'Play Store Privacy Policy Generator', category: 'legal', description: 'Generate Android app privacy policy text.', implementationKey: 'pp-generator' }),

  createTool({ id: 'semxy-games', slug: 'semxy-games', name: 'Semxy Games', category: 'games', description: 'Play instant in-browser mini games.', implementationKey: 'semxy-games' }),
]

export const toolCategories: Array<{ id: ToolCategory | 'all'; label: string }> = [
  { id: 'all', label: 'All' },
  ...Array.from(new Set(toolsData.map((tool) => tool.category))).map((category) => ({
    id: category,
    label: category.charAt(0).toUpperCase() + category.slice(1),
  })),
]

export function getToolBySlug(slug: string) {
  return toolsData.find((tool) => tool.slug === slug)
}

export function getCategoryLabel(category: string) {
  return category ? category.charAt(0).toUpperCase() + category.slice(1) : 'All'
}
