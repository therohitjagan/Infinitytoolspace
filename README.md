# InfinityToolSpace (React v2)

InfinityToolSpace is a modern, fast, privacy-focused web toolkit built with React, TypeScript, and Vite.

This repository contains the React v2 codebase.

## Highlights

- Modern tool platform with category pages and dynamic tool routes
- Internal tool workspaces (PDF, text, image, converter, utility, legal)
- Command palette (`Ctrl/Cmd + K`), favorites, and recent tools
- Rich legal policy generators with step-based wizard flows
- File upload UX with progress and validation components
- Light and dark theme support with persisted preference
- Fully client-side architecture for fast interactions

## Tech Stack

- React 19 + TypeScript
- Vite 7
- Tailwind CSS 3
- Framer Motion
- React Router
- Zustand
- pdf-lib + pdfjs-dist + qrcode
- ESLint + Prettier

## Project Scripts

- `npm run dev` - Start development server
- `npm run build` - Type-check and create production build
- `npm run preview` - Preview production build locally
- `npm run lint` - Run ESLint
- `npm run format` - Format source files
- `npm run format:check` - Check formatting

## Quick Start

1. Install dependencies:

```bash
npm install
```

2. Start development server:

```bash
npm run dev
```

3. Open:

```text
http://localhost:5173
```

## Build for Production

```bash
npm run build
npm run preview
```

Output is generated in the `dist` folder.

## Current App Sections

- Home
- About
- Contact
- Privacy & Terms
- Category pages (`/category/:category`)
- Tool pages (`/tool/:toolId`)

## Tool System

Tool listings and routing are driven by catalog metadata and implementation keys.

Primary catalog file:

- `src/lib/toolsData.ts`

Tool implementations live in:

- `src/tools/**`

## Theming

- Theme state is persisted via Zustand
- Global CSS variables drive both dark and light mode palettes
- Tailwind ITS color tokens map to CSS variables for consistent theming

## Deployment

### Vercel

1. Import this repository
2. Framework preset: Vite
3. Build command: `npm run build`
4. Output directory: `dist`

### Netlify

1. Connect this repository
2. Build command: `npm run build`
3. Publish directory: `dist`

## Replacing PHP v1 with React v2 in the Same GitHub Repo

If your old repo branch contains PHP v1 and you want React v2 only:

```bash
git init
git add .
git commit -m "Replace PHP v1 with React v2"
git branch -M main
git remote add origin https://github.com/therohitjagan/Infinitytoolspace.git
git push -u --force origin main
```

This force-push updates `main` to the React v2 codebase.

## Developer

Built by Rohit Singh.
