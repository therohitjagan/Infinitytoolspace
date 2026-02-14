import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{ts,tsx}'],
  theme: {
    extend: {
      colors: {
        its: {
          bg: {
            primary: 'rgb(var(--its-bg-primary) / <alpha-value>)',
            secondary: 'rgb(var(--its-bg-secondary) / <alpha-value>)',
          },
          accent: {
            cyan: 'rgb(var(--its-accent-cyan) / <alpha-value>)',
            purple: 'rgb(var(--its-accent-purple) / <alpha-value>)',
            green: 'rgb(var(--its-accent-green) / <alpha-value>)',
          },
          status: {
            success: 'rgb(var(--its-status-success) / <alpha-value>)',
            warning: 'rgb(var(--its-status-warning) / <alpha-value>)',
            error: 'rgb(var(--its-status-error) / <alpha-value>)',
          },
          text: {
            primary: 'rgb(var(--its-text-primary) / <alpha-value>)',
            secondary: 'rgb(var(--its-text-secondary) / <alpha-value>)',
          },
        },
      },
      fontFamily: {
        display: ['Orbitron', 'Rajdhani', 'sans-serif'],
        body: ['Inter', 'Manrope', 'sans-serif'],
        code: ['JetBrains Mono', 'monospace'],
      },
      boxShadow: {
        neon: '0 0 20px rgba(0, 245, 255, 0.35)',
        card: '0 12px 50px rgba(0, 0, 0, 0.35)',
      },
      backgroundImage: {
        'its-gradient':
          'linear-gradient(135deg, rgba(0,245,255,0.14), rgba(178,75,243,0.16) 55%, rgba(57,255,20,0.12))',
      },
      animation: {
        float: 'float 6s ease-in-out infinite',
        pulseSoft: 'pulseSoft 2.4s ease-in-out infinite',
        shimmer: 'shimmer 8s ease-in-out infinite',
      },
      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        pulseSoft: {
          '0%, 100%': { opacity: '0.7' },
          '50%': { opacity: '1' },
        },
        shimmer: {
          '0%, 100%': { filter: 'hue-rotate(0deg)' },
          '50%': { filter: 'hue-rotate(40deg)' },
        },
      },
    },
  },
  plugins: [forms, typography],
}