import { useMemo, useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

const steps = [
  'Company',
  'Collection',
  'Processing',
  'Retention/Rights',
  'Review',
]

function PrivacyPolicyGenerator() {
  const [step, setStep] = useState(0)

  const [siteName, setSiteName] = useState('My Website')
  const [websiteUrl, setWebsiteUrl] = useState('https://example.com')
  const [companyName, setCompanyName] = useState('My Company')
  const [country, setCountry] = useState('India')
  const [businessAddress, setBusinessAddress] = useState('')
  const [email, setEmail] = useState('contact@example.com')
  const [phone, setPhone] = useState('')
  const [dpoEmail, setDpoEmail] = useState('')
  const [appType, setAppType] = useState('website')
  const [audience, setAudience] = useState('general')

  const [collectsName, setCollectsName] = useState(true)
  const [collectsEmail, setCollectsEmail] = useState(true)
  const [collectsPhone, setCollectsPhone] = useState(false)
  const [collectsAddress, setCollectsAddress] = useState(false)
  const [collectsPaymentInfo, setCollectsPaymentInfo] = useState(false)
  const [collectsLocation, setCollectsLocation] = useState(false)
  const [collectsUsageData, setCollectsUsageData] = useState(true)
  const [collectsSensitiveData, setCollectsSensitiveData] = useState(false)
  const [hasAccounts, setHasAccounts] = useState(false)
  const [allowsUploads, setAllowsUploads] = useState(false)

  const [usesAnalytics, setUsesAnalytics] = useState(true)
  const [usesCookies, setUsesCookies] = useState(true)
  const [usesAds, setUsesAds] = useState(false)
  const [usesPush, setUsesPush] = useState(false)
  const [usesCrashReporting, setUsesCrashReporting] = useState(true)
  const [usesThirdPartyAuth, setUsesThirdPartyAuth] = useState(false)
  const [internationalTransfers, setInternationalTransfers] = useState(false)
  const [lawfulBasis, setLawfulBasis] = useState('consent, contract, legal obligation')
  const [subprocessors, setSubprocessors] = useState('Cloud hosting, analytics provider')
  const [cookiePolicyUrl, setCookiePolicyUrl] = useState('')

  const [requestResponseDays, setRequestResponseDays] = useState(30)
  const [retentionDays, setRetentionDays] = useState(180)
  const [result, setResult] = useState('')

  const collectedData = useMemo(
    () =>
      [
        collectsName ? 'Name' : null,
        collectsEmail ? 'Email address' : null,
        collectsPhone ? 'Phone number' : null,
        collectsAddress ? 'Postal address' : null,
        collectsPaymentInfo ? 'Payment details (processed via payment providers)' : null,
        collectsLocation ? 'Location data' : null,
        collectsUsageData ? 'Usage/device analytics' : null,
        collectsSensitiveData ? 'Sensitive personal information' : null,
        hasAccounts ? 'Account credentials and profile details' : null,
        allowsUploads ? 'User uploaded files/content' : null,
      ].filter(Boolean),
    [
      allowsUploads,
      collectsAddress,
      collectsEmail,
      collectsLocation,
      collectsName,
      collectsPaymentInfo,
      collectsPhone,
      collectsSensitiveData,
      collectsUsageData,
      hasAccounts,
    ],
  )

  function generate() {
    setResult(`PRIVACY POLICY\n\nEffective Date: ${new Date().toISOString().slice(0, 10)}\nEntity: ${companyName}\nProduct: ${siteName}\nType: ${appType}\nWebsite/App URL: ${websiteUrl}\nAudience: ${audience}\nRegistered Address: ${businessAddress || 'Not specified'}\nJurisdiction: ${country}\nLawful Basis: ${lawfulBasis}\n\n1. Data Controller and Contact\nFor this policy, the data controller is ${companyName}.\nPrimary contact: ${email}${phone ? `\nPhone: ${phone}` : ''}${dpoEmail ? `\nData Protection Officer: ${dpoEmail}` : ''}.\n\n2. Personal Data We Collect\n${collectedData.length ? collectedData.map((item) => `- ${item}`).join('\n') : '- No personally identifiable data is collected directly.'}\n\n3. Sources of Data\n- Data you provide directly through forms, account registration, or support interactions\n- Data generated automatically through use of the service\n\n4. How We Use Personal Data\n- To deliver, maintain, and improve service features\n- To authenticate users and protect account security\n- To respond to support and legal requests\n${usesAnalytics ? '- To evaluate usage trends and improve product decisions' : ''}\n${usesCrashReporting ? '- To detect, investigate, and resolve app errors' : ''}\n${usesAds ? '- To deliver and measure advertisements where enabled' : ''}\n${usesPush ? '- To send push notifications and service alerts' : ''}\n\n5. Cookies and Tracking Technologies\n${usesCookies ? '- We use cookies/local storage for session continuity, preferences, and security.' : '- We do not use non-essential cookies.'}\n${cookiePolicyUrl ? `- Cookie details are available at: ${cookiePolicyUrl}` : ''}\n\n6. Third-Party Services and Sharing\n- We do not sell personal data.\n- We share limited information only with subprocessors necessary to operate the service.\n- Subprocessors/partners: ${subprocessors}.\n${usesThirdPartyAuth ? '- Third-party login providers may process profile identifiers for sign-in.' : ''}\n\n7. International Data Transfers\n${internationalTransfers ? '- Personal data may be transferred across borders under contractual and technical safeguards.' : '- Data is primarily processed within declared operating regions.'}\n\n8. Data Retention\n- Personal data is retained only as needed for service operation, legal compliance, and dispute resolution.\n- Standard retention period: up to ${retentionDays} days unless longer retention is required by law.\n\n9. Data Subject Rights\nDepending on your jurisdiction, you may have rights to access, correction, deletion, restriction, portability, and objection.\nWe respond to verified requests within ${requestResponseDays} days.\n\n10. Children\n${audience === 'children' ? '- This service is intended for minors and uses parental/guardian controls where applicable.' : '- This service is not directed to children unless explicitly stated.'}\n\n11. Security\nWe implement organizational, administrative, and technical controls to protect personal data, including access controls and encrypted transport where applicable.\n\n12. Changes to this Policy\nWe may update this policy from time to time. Material changes will be communicated through in-product notices or website updates.\n\nContact for privacy requests: ${dpoEmail || email}`)
  }

  const canNext =
    (step === 0 && !!siteName.trim() && !!companyName.trim() && !!websiteUrl.trim() && !!email.trim()) ||
    (step > 0 && step < steps.length - 1)

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
          <input value={siteName} onChange={(event) => setSiteName(event.target.value)} placeholder="Product / Site Name" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={companyName} onChange={(event) => setCompanyName(event.target.value)} placeholder="Company Name" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={websiteUrl} onChange={(event) => setWebsiteUrl(event.target.value)} placeholder="Website URL" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={country} onChange={(event) => setCountry(event.target.value)} placeholder="Country/Jurisdiction" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={appType} onChange={(event) => setAppType(event.target.value)} placeholder="Product Type (website/app/saas)" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={audience} onChange={(event) => setAudience(event.target.value)} placeholder="Audience (general/teens/children)" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={businessAddress} onChange={(event) => setBusinessAddress(event.target.value)} placeholder="Business Address" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={email} onChange={(event) => setEmail(event.target.value)} placeholder="Support Email" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={phone} onChange={(event) => setPhone(event.target.value)} placeholder="Support Phone" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={dpoEmail} onChange={(event) => setDpoEmail(event.target.value)} placeholder="DPO/Privacy Email" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
        </div>
      ) : null}

      {step === 1 ? (
        <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-3 text-sm">
          <label><input type="checkbox" checked={collectsName} onChange={(event) => setCollectsName(event.target.checked)} /> Collects name</label>
          <label><input type="checkbox" checked={collectsEmail} onChange={(event) => setCollectsEmail(event.target.checked)} /> Collects email</label>
          <label><input type="checkbox" checked={collectsPhone} onChange={(event) => setCollectsPhone(event.target.checked)} /> Collects phone</label>
          <label><input type="checkbox" checked={collectsAddress} onChange={(event) => setCollectsAddress(event.target.checked)} /> Collects address</label>
          <label><input type="checkbox" checked={collectsPaymentInfo} onChange={(event) => setCollectsPaymentInfo(event.target.checked)} /> Collects payment data</label>
          <label><input type="checkbox" checked={collectsLocation} onChange={(event) => setCollectsLocation(event.target.checked)} /> Collects location</label>
          <label><input type="checkbox" checked={collectsUsageData} onChange={(event) => setCollectsUsageData(event.target.checked)} /> Collects usage data</label>
          <label><input type="checkbox" checked={collectsSensitiveData} onChange={(event) => setCollectsSensitiveData(event.target.checked)} /> Sensitive data</label>
          <label><input type="checkbox" checked={hasAccounts} onChange={(event) => setHasAccounts(event.target.checked)} /> Has user accounts</label>
          <label><input type="checkbox" checked={allowsUploads} onChange={(event) => setAllowsUploads(event.target.checked)} /> User uploads</label>
        </div>
      ) : null}

      {step === 2 ? (
        <div className="space-y-3">
          <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-3 text-sm">
            <label><input type="checkbox" checked={usesAnalytics} onChange={(event) => setUsesAnalytics(event.target.checked)} /> Uses analytics</label>
            <label><input type="checkbox" checked={usesCookies} onChange={(event) => setUsesCookies(event.target.checked)} /> Uses cookies</label>
            <label><input type="checkbox" checked={usesAds} onChange={(event) => setUsesAds(event.target.checked)} /> Uses ads</label>
            <label><input type="checkbox" checked={usesPush} onChange={(event) => setUsesPush(event.target.checked)} /> Uses push notifications</label>
            <label><input type="checkbox" checked={usesCrashReporting} onChange={(event) => setUsesCrashReporting(event.target.checked)} /> Crash reporting</label>
            <label><input type="checkbox" checked={usesThirdPartyAuth} onChange={(event) => setUsesThirdPartyAuth(event.target.checked)} /> Third-party auth</label>
            <label><input type="checkbox" checked={internationalTransfers} onChange={(event) => setInternationalTransfers(event.target.checked)} /> International transfer</label>
          </div>
          <div className="grid gap-2 sm:grid-cols-2">
            <input value={lawfulBasis} onChange={(event) => setLawfulBasis(event.target.value)} placeholder="Lawful basis" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
            <input value={subprocessors} onChange={(event) => setSubprocessors(event.target.value)} placeholder="Subprocessors" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
            <input value={cookiePolicyUrl} onChange={(event) => setCookiePolicyUrl(event.target.value)} placeholder="Cookie Policy URL (optional)" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2 sm:col-span-2" />
          </div>
        </div>
      ) : null}

      {step === 3 ? (
        <div className="grid gap-2 sm:grid-cols-2">
          <input type="number" value={retentionDays} onChange={(event) => setRetentionDays(Number(event.target.value))} placeholder="Retention Days" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input type="number" value={requestResponseDays} onChange={(event) => setRequestResponseDays(Number(event.target.value))} placeholder="Rights response days" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
        </div>
      ) : null}

      {step === 4 ? (
        <div className="space-y-2 rounded-xl border border-white/15 p-3 text-sm text-its-text-secondary">
          <p><strong className="text-its-text-primary">Entity:</strong> {companyName}</p>
          <p><strong className="text-its-text-primary">Product:</strong> {siteName}</p>
          <p><strong className="text-its-text-primary">URL:</strong> {websiteUrl}</p>
          <p><strong className="text-its-text-primary">Jurisdiction:</strong> {country}</p>
          <p><strong className="text-its-text-primary">Contact:</strong> {email}</p>
          <p><strong className="text-its-text-primary">Collected Fields:</strong> {collectedData.join(', ') || 'None selected'}</p>
          <p><strong className="text-its-text-primary">Subprocessors:</strong> {subprocessors}</p>
        </div>
      ) : null}

      <div className="flex flex-wrap gap-2">
        <Button variant="ghost" onClick={() => setStep((current) => Math.max(0, current - 1))} disabled={step === 0}>
          Previous
        </Button>
        {step < steps.length - 1 ? (
          <Button onClick={() => setStep((current) => Math.min(steps.length - 1, current + 1))} disabled={!canNext}>
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

export default PrivacyPolicyGenerator
