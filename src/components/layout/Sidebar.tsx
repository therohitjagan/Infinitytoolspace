import type { PropsWithChildren } from 'react'
import Card from '../ui/Card'

function Sidebar({ children }: PropsWithChildren) {
  return (
    <aside className="w-full lg:w-72">
      <Card>{children}</Card>
    </aside>
  )
}

export default Sidebar