import { useState, useEffect } from "react";
import Footer from "../components/layout/Footer/Footer";
import Navbar from "../components/layout/Navbar/Navbar";
import Hero from "../components/layout/Hero/Hero";
import EventsSection from "../components/sections/EventsSection";
import NewsSection from "../components/sections/NewsSection";
export default function Home() {
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const timer = setTimeout(() => {
      setIsLoading(false);
    }, 1200);

    return () => clearTimeout(timer);
  }, []);

  return (
    <>
      <main>
        <Hero />
        <EventsSection/>
        <NewsSection/>
      </main>
    </>
  );
}
