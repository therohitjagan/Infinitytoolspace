import type { InputHTMLAttributes } from 'react'
import { cn } from '../../lib/utils'

function Input({ className, ...props }: InputHTMLAttributes<HTMLInputElement>) {
  return (
    <input
      className={cn(
        'focus-ring w-full rounded-xl border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-its-text-primary placeholder:text-its-text-secondary/70',
        className,
      )}
      {...props}
    />
  )
}

export default Input