import { useState } from 'react'
import Button from '../../components/ui/Button'
import Card from '../../components/ui/Card'

function SemxyGames() {
  const [score, setScore] = useState(0)
  const [time, setTime] = useState(10)
  const [running, setRunning] = useState(false)

  function start() {
    setRunning(true)
    setScore(0)
    setTime(10)
    const timer = window.setInterval(() => {
      setTime((current) => {
        if (current <= 1) {
          window.clearInterval(timer)
          setRunning(false)
          return 0
        }
        return current - 1
      })
    }, 1000)
  }

  return (
    <Card className="space-y-4 text-center">
      <h3 className="font-display text-xl">Tap Challenge</h3>
      <p className="text-sm text-its-text-secondary">Click as many times as possible in 10 seconds.</p>
      <p className="text-lg">Time: {time}s • Score: {score}</p>
      <div className="flex items-center justify-center gap-2">
        <Button onClick={start} disabled={running}>Start</Button>
        <Button variant="secondary" onClick={() => running && setScore((current) => current + 1)} disabled={!running}>Tap!</Button>
      </div>
    </Card>
  )
}

export default SemxyGames
