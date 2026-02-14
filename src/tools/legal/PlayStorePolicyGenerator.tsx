import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

const steps = ['App Info', 'Data Types', 'SDK/Permissions', 'Compliance', 'Review']

function PlayStorePolicyGenerator() {
  const [step, setStep] = useState(0)

  const [appName, setAppName] = useState('My Android App')
  const [packageName, setPackageName] = useState('com.example.app')
  const [developer, setDeveloper] = useState('Developer Name')
  const [developerAddress, setDeveloperAddress] = useState('')
  const [website, setWebsite] = useState('')
  const [supportEmail, setSupportEmail] = useState('support@example.com')
  const [supportPhone, setSupportPhone] = useState('')
  const [targetAudience, setTargetAudience] = useState('general')
  const [minAge, setMinAge] = useState(13)

  const [collectsLocation, setCollectsLocation] = useState(false)
  const [collectsContacts, setCollectsContacts] = useState(false)
  const [collectsDeviceId, setCollectsDeviceId] = useState(true)
  const [collectsMedia, setCollectsMedia] = useState(false)
  const [collectsHealth, setCollectsHealth] = useState(false)
  const [collectsFinancial, setCollectsFinancial] = useState(false)

  const [sdkList, setSdkList] = useState('Firebase Analytics, Crashlytics')
  const [permissions, setPermissions] = useState('Internet, Camera')
  const [usesAds, setUsesAds] = useState(false)
  const [usesPurchases, setUsesPurchases] = useState(false)
  const [usesAuth, setUsesAuth] = useState(false)

  const [allowsDeletionRequest, setAllowsDeletionRequest] = useState(true)
  const [internationalTransfer, setInternationalTransfer] = useState(false)
  const [retentionDays, setRetentionDays] = useState(180)

  const [result, setResult] = useState('')

  const dataItems = useMemo(
    () =>
      [
        collectsLocation ? 'Approximate/precise location' : null,
        collectsContacts ? 'Contacts information' : null,
        collectsDeviceId ? 'Device identifiers and diagnostics' : null,
        collectsMedia ? 'Media files/photos/videos' : null,
        collectsHealth ? 'Health and fitness data' : null,
        collectsFinancial ? 'Financial/payment related information' : null,
      ].filter(Boolean),
    [
      collectsContacts,
      collectsDeviceId,
      collectsFinancial,
      collectsHealth,
      collectsLocation,
      collectsMedia,
    ],
  )

  function generate() {
    setResult(`PLAY STORE PRIVACY POLICY\n\nEffective Date: ${new Date().toISOString().slice(0, 10)}\nApp Name: ${appName}\nPackage Name: ${packageName}\nDeveloper: ${developer}\nDeveloper Address: ${developerAddress || 'Not specified'}\nWebsite: ${website || 'Not specified'}\nSupport Email: ${supportEmail}${supportPhone ? `\nSupport Phone: ${supportPhone}` : ''}\nAudience: ${targetAudience}\nMinimum Age: ${minAge}+\n\n1. Information We Collect\n${dataItems.length ? dataItems.map((item) => `- ${item}`).join('\n') : '- No personal data is collected directly by the app beyond operational diagnostics.'}\n\n2. Data Processing Purpose\n- Deliver app functionality and requested features\n- Secure the app and prevent abuse/fraud\n- Improve performance and reliability\n${usesPurchases ? '- Process purchases and transaction verification' : ''}\n${usesAuth ? '- Authenticate users and secure account sessions' : ''}\n${usesAds ? '- Serve and measure advertising content where applicable' : ''}\n\n3. Permissions and Device Access\nPermissions requested: ${permissions}.\nPermissions are used only for feature-specific operations disclosed in Play listing and in-app prompts.\n\n4. Third-Party SDKs and Services\nIntegrated SDKs/services: ${sdkList}.\nThese providers may process limited technical data to provide analytics, crash reporting, notifications, or monetization features.\n\n5. Data Sharing\n- Personal data is not sold.\n- Data sharing is restricted to processors/service providers required for app operation and compliance.\n${internationalTransfer ? '- Data may be transferred across regions with suitable safeguards.' : '- Data processing is primarily regional based on infrastructure and compliance requirements.'}\n\n6. Data Retention\nData is retained for up to ${retentionDays} days unless a longer period is required for legal obligations, fraud prevention, or dispute resolution.\n\n7. Children and Families\n${targetAudience === 'children' ? '- This app may be used by children and follows Google Play Families policies with parental/guardian controls where applicable.' : '- This app is intended for general audiences and is not specifically directed to children unless declared.'}\n\n8. User Controls and Rights\nUsers can request access, correction, or deletion of eligible personal data by contacting ${supportEmail}.\n${allowsDeletionRequest ? '- Data deletion requests are supported for account-linked data, subject to legal/operational exceptions.' : '- Deletion requests may be limited for legal compliance and security obligations.'}\n\n9. Security\nWe use reasonable administrative, technical, and organizational controls, including encrypted transport and controlled access.\n\n10. Policy Updates\nThis policy may be updated as features, legal requirements, or Play policies evolve. Updated versions will include revised effective dates.\n\n11. Contact\nFor privacy and policy questions: ${supportEmail}.`)
  }

  return (
    <Card className="space-y-4">
      <div className="flex flex-wrap gap-2 text-xs">
        {steps.map((label, index) => (
          <span
            key={label}
            className={`rounded-full border px-3 py-1 ${index === step ? 'border-its-accent-cyan text-its-accent-cyan' : 'border-white/15 text-its-text-secondary'}`}
          >
            {index + 1}. {label}
          </span>
        ))}
      </div>

      {step === 0 ? (
        <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
          <input value={appName} onChange={(event) => setAppName(event.target.value)} placeholder="App Name" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={packageName} onChange={(event) => setPackageName(event.target.value)} placeholder="Package Name" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={developer} onChange={(event) => setDeveloper(event.target.value)} placeholder="Developer Name" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={developerAddress} onChange={(event) => setDeveloperAddress(event.target.value)} placeholder="Developer Address" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={website} onChange={(event) => setWebsite(event.target.value)} placeholder="Developer Website" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={supportEmail} onChange={(event) => setSupportEmail(event.target.value)} placeholder="Support Email" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={supportPhone} onChange={(event) => setSupportPhone(event.target.value)} placeholder="Support Phone" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={targetAudience} onChange={(event) => setTargetAudience(event.target.value)} placeholder="Audience (general/children)" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input type="number" value={minAge} onChange={(event) => setMinAge(Number(event.target.value))} placeholder="Minimum age" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
        </div>
      ) : null}

      {step === 1 ? (
        <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-3 text-sm">
          <label><input type="checkbox" checked={collectsLocation} onChange={(event) => setCollectsLocation(event.target.checked)} /> Collects location</label>
          <label><input type="checkbox" checked={collectsContacts} onChange={(event) => setCollectsContacts(event.target.checked)} /> Collects contacts</label>
          <label><input type="checkbox" checked={collectsDeviceId} onChange={(event) => setCollectsDeviceId(event.target.checked)} /> Collects device identifiers</label>
          <label><input type="checkbox" checked={collectsMedia} onChange={(event) => setCollectsMedia(event.target.checked)} /> Collects media files</label>
          <label><input type="checkbox" checked={collectsHealth} onChange={(event) => setCollectsHealth(event.target.checked)} /> Collects health data</label>
          <label><input type="checkbox" checked={collectsFinancial} onChange={(event) => setCollectsFinancial(event.target.checked)} /> Collects financial data</label>
        </div>
      ) : null}

      {step === 2 ? (
        <div className="space-y-3">
          <input value={permissions} onChange={(event) => setPermissions(event.target.value)} placeholder="Permissions list" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={sdkList} onChange={(event) => setSdkList(event.target.value)} placeholder="Third-party SDK list" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <div className="grid gap-2 sm:grid-cols-3 text-sm">
            <label><input type="checkbox" checked={usesAds} onChange={(event) => setUsesAds(event.target.checked)} /> Uses ads</label>
            <label><input type="checkbox" checked={usesPurchases} onChange={(event) => setUsesPurchases(event.target.checked)} /> In-app purchases</label>
            <label><input type="checkbox" checked={usesAuth} onChange={(event) => setUsesAuth(event.target.checked)} /> Authentication</label>
          </div>
        </div>
      ) : null}

      {step === 3 ? (
        <div className="space-y-3">
          <div className="grid gap-2 sm:grid-cols-2">
            <input type="number" value={retentionDays} onChange={(event) => setRetentionDays(Number(event.target.value))} placeholder="Retention days" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          </div>
          <div className="grid gap-2 sm:grid-cols-2 text-sm">
            <label><input type="checkbox" checked={allowsDeletionRequest} onChange={(event) => setAllowsDeletionRequest(event.target.checked)} /> Allows deletion requests</label>
            <label><input type="checkbox" checked={internationalTransfer} onChange={(event) => setInternationalTransfer(event.target.checked)} /> International transfer</label>
          </div>
        </div>
      ) : null}

      {step === 4 ? (
        <div className="space-y-2 rounded-xl border border-white/15 p-3 text-sm text-its-text-secondary">
          <p><strong className="text-its-text-primary">App:</strong> {appName}</p>
          <p><strong className="text-its-text-primary">Package:</strong> {packageName}</p>
          <p><strong className="text-its-text-primary">Audience:</strong> {targetAudience}</p>
          <p><strong className="text-its-text-primary">Data Categories:</strong> {dataItems.join(', ') || 'None selected'}</p>
          <p><strong className="text-its-text-primary">Permissions:</strong> {permissions}</p>
          <p><strong className="text-its-text-primary">SDKs:</strong> {sdkList}</p>
        </div>
      ) : null}

      <div className="flex flex-wrap gap-2">
        <Button variant="ghost" onClick={() => setStep((current) => Math.max(0, current - 1))} disabled={step === 0}>
          Previous
        </Button>
        {step < steps.length - 1 ? (
          <Button onClick={() => setStep((current) => Math.min(steps.length - 1, current + 1))}>
            Next
          </Button>
        ) : (
          <Button onClick={generate}>Generate Policy</Button>
        )}
        <Button variant="secondary" onClick={() => result && navigator.clipboard.writeText(result)} disabled={!result}>
          Copy
        </Button>
      </div>

      <textarea rows={16} readOnly value={result} className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm" />
    </Card>
  )
}

export default PlayStorePolicyGenerator
