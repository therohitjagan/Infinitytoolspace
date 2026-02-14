import { Loader2 } from 'lucide-react'
import type { ButtonHTMLAttributes, PropsWithChildren } from 'react'
import { cn } from '../../lib/utils'

type ButtonVariant = 'primary' | 'secondary' | 'ghost'

interface ButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
  variant?: ButtonVariant
  isLoading?: boolean
}

const variantClasses: Record<ButtonVariant, string> = {
  primary:
    'bg-its-accent-cyan text-its-bg-primary hover:shadow-neon hover:brightness-110 active:scale-[0.98]',
  secondary:
    'bg-its-accent-purple/15 text-its-text-primary border border-its-accent-purple/40 hover:border-its-accent-purple hover:shadow-neon',
  ghost:
    'bg-transparent text-its-text-secondary hover:text-its-text-primary hover:bg-white/10 border border-white/10',
}

function Button({
  children,
  className,
  variant = 'primary',
  isLoading = false,
  disabled,
  ...props
}: PropsWithChildren<ButtonProps>) {
  return (
    <button
      className={cn(
        'focus-ring inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition duration-200',
        variantClasses[variant],
        (disabled || isLoading) && 'cursor-not-allowed opacity-60',
        className,
      )}
      disabled={disabled || isLoading}
      {...props}
    >
      {isLoading ? <Loader2 className="h-4 w-4 animate-spin" aria-hidden="true" /> : null}
      <span>{children}</span>
    </button>
  )
}

export default Button