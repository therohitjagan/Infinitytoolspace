import Container from '../components/layout/Container'
import FavoritesSection from '../components/home/FavoritesSection'
import FeaturesSection from '../components/home/FeaturesSection'
import Hero from '../components/home/Hero'
import RecentToolsSection from '../components/home/RecentToolsSection'
import StatsSection from '../components/home/StatsSection'
import ToolGrid from '../components/home/ToolGrid'

function Home() {
  return (
    <>
      <Hero />
      <Container className="space-y-14 pb-20">
        <StatsSection />
        <FavoritesSection />
        <RecentToolsSection />
        <ToolGrid />
        <FeaturesSection />
      </Container>
    </>
  )
}

export default Home