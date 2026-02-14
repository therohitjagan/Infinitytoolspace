import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

const sets: Record<string, string> = {
  bold: '𝗮𝗯𝗰𝗱𝗲𝗳𝗴𝗵𝗶𝗷𝗸𝗹𝗺𝗻𝗼𝗽𝗾𝗿𝘀𝘁𝘂𝘃𝘄𝘅𝘆𝘇',
  italic: '𝘢𝘣𝘤𝘥𝘦𝘧𝘨𝘩𝘪𝘫𝘬𝘭𝘮𝘯𝘰𝘱𝘲𝘳𝘴𝘵𝘶𝘷𝘸𝘹𝘺𝘻',
  boldItalic: '𝙖𝙗𝙘𝙙𝙚𝙛𝙜𝙝𝙞𝙟𝙠𝙡𝙢𝙣𝙤𝙥𝙦𝙧𝙨𝙩𝙪𝙫𝙬𝙭𝙮𝙯',
  script: '𝒶𝒷𝒸𝒹𝑒𝒻𝑔𝒽𝒾𝒿𝓀𝓁𝓂𝓃𝑜𝓅𝓆𝓇𝓈𝓉𝓊𝓋𝓌𝓍𝓎𝓏',
  gothic: '𝖆𝖇𝖈𝖉𝖊𝖋𝖌𝖍𝖎𝖏𝖐𝖑𝖒𝖓𝖔𝖕𝖖𝖗𝖘𝖙𝖚𝖛𝖜𝖝𝖞𝖟',
  doubleStruck: '𝕒𝕓𝕔𝕕𝕖𝕗𝕘𝕙𝕚𝕛𝕜𝕝𝕞𝕟𝕠𝕡𝕢𝕣𝕤𝕥𝕦𝕧𝕨𝕩𝕪𝕫',
  sans: '𝖺𝖻𝖼𝖽𝖾𝖿𝗀𝗁𝗂𝗃𝗄𝗅𝗆𝗇𝗈𝗉𝗊𝗋𝗌𝗍𝗎𝗏𝗐𝗑𝗒𝗓',
  sansBold: '𝗮𝗯𝗰𝗱𝗲𝗳𝗴𝗵𝗶𝗷𝗸𝗹𝗺𝗻𝗼𝗽𝗾𝗿𝘀𝘁𝘂𝘃𝘄𝘅𝘆𝘇',
  mono: '𝚊𝚋𝚌𝚍𝚎𝚏𝚐𝚑𝚒𝚓𝚔𝚕𝚖𝚗𝚘𝚙𝚚𝚛𝚜𝚝𝚞𝚟𝚠𝚡𝚢𝚣',
  wide: 'ａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚ',
  parenthesized: '⒜⒝⒞⒟⒠⒡⒢⒣⒤⒥⒦⒧⒨⒩⒪⒫⒬⒭⒮⒯⒰⒱⒲⒳⒴⒵',
  squared: '🄰🄱🄲🄳🄴🄵🄶🄷🄸🄹🄺🄻🄼🄽🄾🄿🅀🅁🅂🅃🅄🅅🅆🅇🅈🅉',
}

function transform(text: string, target: string) {
  const ascii = 'abcdefghijklmnopqrstuvwxyz'
  return text
    .split('')
    .map((char) => {
      const lower = char.toLowerCase()
      const index = ascii.indexOf(lower)
      if (index < 0) return char
      const mapped = target[index] ?? char
      return char === lower ? mapped : mapped
    })
    .join('')
}

function FontGenerator() {
  const [input, setInput] = useState('InfinityToolSpace')
  const variants = useMemo(
    () => [
      { label: 'Bold', value: transform(input, sets.bold) },
      { label: 'Italic', value: transform(input, sets.italic) },
      { label: 'Bold Italic', value: transform(input, sets.boldItalic) },
      { label: 'Script', value: transform(input, sets.script) },
      { label: 'Gothic', value: transform(input, sets.gothic) },
      { label: 'Double Struck', value: transform(input, sets.doubleStruck) },
      { label: 'Sans', value: transform(input, sets.sans) },
      { label: 'Sans Bold', value: transform(input, sets.sansBold) },
      { label: 'Monospace', value: transform(input, sets.mono) },
      { label: 'Wide', value: transform(input, sets.wide) },
      { label: 'Parenthesized', value: transform(input, sets.parenthesized) },
      { label: 'Squared', value: transform(input, sets.squared) },
    ],
    [input],
  )

  return (
    <Card className="space-y-4">
      <input
        value={input}
        onChange={(event) => setInput(event.target.value)}
        className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm"
      />
      <div className="space-y-2">
        {variants.map((item) => (
          <div key={item.label} className="flex items-center justify-between rounded-xl border border-white/15 p-3">
            <div>
              <p className="text-xs text-its-text-secondary">{item.label}</p>
              <p>{item.value}</p>
            </div>
            <Button variant="ghost" onClick={() => navigator.clipboard.writeText(item.value)}>
              Copy
            </Button>
          </div>
        ))}
      </div>
    </Card>
  )
}

export default FontGenerator
