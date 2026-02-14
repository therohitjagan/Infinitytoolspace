import type { HTMLAttributes, PropsWithChildren } from 'react'
import { cn } from '../../lib/utils'

interface CardProps extends HTMLAttributes<HTMLDivElement> {
  glow?: boolean
}

function Card({ children, className, glow = false, ...props }: PropsWithChildren<CardProps>) {
  return (
    <div
      className={cn(
        'glass-panel rounded-2xl p-5 shadow-card transition duration-300 hover:-translate-y-0.5',
        glow && 'animate-neon-border',
        className,
      )}
      {...props}
    >
      {children}
    </div>
  )
}

export default Card