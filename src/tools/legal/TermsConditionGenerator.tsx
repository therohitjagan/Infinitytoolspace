import { useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

const steps = ['Business', 'Commercial', 'Risk/Disputes', 'Review']

function TermsConditionGenerator() {
  const [step, setStep] = useState(0)

  const [business, setBusiness] = useState('My Business')
  const [websiteUrl, setWebsiteUrl] = useState('https://example.com')
  const [country, setCountry] = useState('India')
  const [stateRegion, setStateRegion] = useState('')
  const [contactEmail, setContactEmail] = useState('legal@example.com')
  const [contactAddress, setContactAddress] = useState('')
  const [serviceName, setServiceName] = useState('Online Tool Platform')

  const [minimumAge, setMinimumAge] = useState(18)
  const [billingCycle, setBillingCycle] = useState('monthly')
  const [terminationNoticeDays, setTerminationNoticeDays] = useState(7)
  const [refundWindowDays, setRefundWindowDays] = useState(7)
  const [gracePeriodDays, setGracePeriodDays] = useState(3)
  const [maxLiabilityAmount, setMaxLiabilityAmount] = useState('100')
  const [prohibitedActions, setProhibitedActions] = useState('abuse, scraping, reverse engineering, unlawful use')

  const [hasArbitration, setHasArbitration] = useState(false)
  const [arbitrationVenue, setArbitrationVenue] = useState('')
  const [providesApi, setProvidesApi] = useState(false)
  const [slaCommitment, setSlaCommitment] = useState('99.0%')
  const [allowsUserContent, setAllowsUserContent] = useState(false)
  const [allowsCommercialUse, setAllowsCommercialUse] = useState(true)

  const [result, setResult] = useState('')

  function generate() {
    setResult(`TERMS & CONDITIONS\n\nEffective Date: ${new Date().toISOString().slice(0, 10)}\nProvider: ${business}\nService: ${serviceName}\nWebsite: ${websiteUrl}\n\n1. Acceptance of Terms\nBy accessing or using ${serviceName}, you agree to these Terms and all applicable laws and regulations.\n\n2. Eligibility and Accounts\nYou must be at least ${minimumAge} years old to create an account or purchase services. You are responsible for maintaining account confidentiality and all activity under your account.\n\n3. Permitted and Prohibited Use\nYou may use the service only for lawful purposes. Prohibited actions include: ${prohibitedActions}.\n${allowsCommercialUse ? '- Commercial use is permitted within your subscribed plan limits.' : '- Commercial use is not permitted unless expressly authorized in writing.'}\n\n4. Plans, Billing, and Renewals\nPaid plans are billed on a ${billingCycle} basis and renew automatically unless canceled before renewal.\nFailed payments may trigger a grace period of ${gracePeriodDays} days before suspension.\n\n5. Refunds\nRefund requests, where eligible, must be submitted within ${refundWindowDays} day(s) of payment unless otherwise required by law.\n\n6. User Content and Data\n${allowsUserContent ? 'You retain ownership of content you upload. You grant us a limited license to process that content solely to operate the service.' : 'This service does not provide public user-generated content publishing.'}\nYou represent that you hold all necessary rights for uploaded or processed data.\n\n7. API and Automation${providesApi ? `\nAPI access may be available under fair use, authentication, and rate limits. Service objective target: ${slaCommitment}.` : '\nNo public API access is guaranteed unless stated in your plan.'}\n\n8. Suspension and Termination\nWe may suspend or terminate accounts for violations, fraud, legal risk, or non-payment. Unless immediate action is required, notice period is ${terminationNoticeDays} day(s).\n\n9. Disclaimers\nThe service is provided on an "as is" and "as available" basis. We do not guarantee uninterrupted, error-free, or fully secure operation at all times.\n\n10. Limitation of Liability\nTo the maximum extent permitted by law, aggregate liability is limited to the greater of fees paid in the previous 12 months or ${maxLiabilityAmount} (local currency), excluding liabilities that cannot be limited by law.\n\n11. Indemnification\nYou agree to indemnify and hold harmless ${business} from claims arising from your misuse of the service, violation of these terms, or infringement of third-party rights.\n\n12. Governing Law and Dispute Resolution\nThese Terms are governed by the laws of ${country}${stateRegion ? `, ${stateRegion}` : ''}.\n${hasArbitration ? `Disputes will be resolved by binding arbitration in ${arbitrationVenue || country}, except where prohibited.` : 'Disputes may be submitted to the competent courts of the governing jurisdiction.'}\n\n13. Changes to Terms\nWe may update these Terms periodically. Continued use after the effective date of updates constitutes acceptance of revised Terms.\n\n14. Contact\nLegal inquiries: ${contactEmail}${contactAddress ? `\nRegistered contact address: ${contactAddress}` : ''}.`)
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
          <input value={business} onChange={(event) => setBusiness(event.target.value)} placeholder="Business Name" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={serviceName} onChange={(event) => setServiceName(event.target.value)} placeholder="Service Name" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={websiteUrl} onChange={(event) => setWebsiteUrl(event.target.value)} placeholder="Website URL" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={country} onChange={(event) => setCountry(event.target.value)} placeholder="Country/Jurisdiction" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={stateRegion} onChange={(event) => setStateRegion(event.target.value)} placeholder="State/Region (optional)" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={contactEmail} onChange={(event) => setContactEmail(event.target.value)} placeholder="Legal Email" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
          <input value={contactAddress} onChange={(event) => setContactAddress(event.target.value)} placeholder="Legal Address" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
        </div>
      ) : null}

      {step === 1 ? (
        <div className="space-y-3">
          <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
            <input type="number" value={minimumAge} onChange={(event) => setMinimumAge(Number(event.target.value))} placeholder="Minimum age" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
            <input value={billingCycle} onChange={(event) => setBillingCycle(event.target.value)} placeholder="Billing cycle" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
            <input type="number" value={refundWindowDays} onChange={(event) => setRefundWindowDays(Number(event.target.value))} placeholder="Refund Window Days" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
            <input type="number" value={gracePeriodDays} onChange={(event) => setGracePeriodDays(Number(event.target.value))} placeholder="Grace period days" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
            <input type="number" value={terminationNoticeDays} onChange={(event) => setTerminationNoticeDays(Number(event.target.value))} placeholder="Termination notice days" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
            <input value={prohibitedActions} onChange={(event) => setProhibitedActions(event.target.value)} placeholder="Prohibited actions" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2 sm:col-span-2 lg:col-span-3" />
          </div>
          <div className="grid gap-2 sm:grid-cols-2 text-sm">
            <label><input type="checkbox" checked={allowsUserContent} onChange={(event) => setAllowsUserContent(event.target.checked)} /> Allows user-generated content</label>
            <label><input type="checkbox" checked={allowsCommercialUse} onChange={(event) => setAllowsCommercialUse(event.target.checked)} /> Allows commercial use</label>
          </div>
        </div>
      ) : null}

      {step === 2 ? (
        <div className="space-y-3">
          <div className="grid gap-2 sm:grid-cols-2">
            <input value={maxLiabilityAmount} onChange={(event) => setMaxLiabilityAmount(event.target.value)} placeholder="Max liability amount" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
            <input value={slaCommitment} onChange={(event) => setSlaCommitment(event.target.value)} placeholder="SLA target (optional)" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2" />
            <input value={arbitrationVenue} onChange={(event) => setArbitrationVenue(event.target.value)} placeholder="Arbitration venue (if enabled)" className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-2 sm:col-span-2" />
          </div>
          <div className="grid gap-2 sm:grid-cols-2 text-sm">
            <label><input type="checkbox" checked={hasArbitration} onChange={(event) => setHasArbitration(event.target.checked)} /> Arbitration clause</label>
            <label><input type="checkbox" checked={providesApi} onChange={(event) => setProvidesApi(event.target.checked)} /> Provides API</label>
          </div>
        </div>
      ) : null}

      {step === 3 ? (
        <div className="space-y-2 rounded-xl border border-white/15 p-3 text-sm text-its-text-secondary">
          <p><strong className="text-its-text-primary">Provider:</strong> {business}</p>
          <p><strong className="text-its-text-primary">Service:</strong> {serviceName}</p>
          <p><strong className="text-its-text-primary">Jurisdiction:</strong> {country}{stateRegion ? `, ${stateRegion}` : ''}</p>
          <p><strong className="text-its-text-primary">Billing:</strong> {billingCycle}</p>
          <p><strong className="text-its-text-primary">Refund window:</strong> {refundWindowDays} days</p>
          <p><strong className="text-its-text-primary">Arbitration:</strong> {hasArbitration ? `Yes (${arbitrationVenue || country})` : 'No'}</p>
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
          <Button onClick={generate}>Generate Terms</Button>
        )}
        <Button variant="secondary" onClick={() => result && navigator.clipboard.writeText(result)} disabled={!result}>
          Copy
        </Button>
      </div>

      <textarea rows={16} readOnly value={result} className="focus-ring w-full rounded-xl border border-white/15 bg-white/5 p-3 text-sm" />
    </Card>
  )
}

export default TermsConditionGenerator
