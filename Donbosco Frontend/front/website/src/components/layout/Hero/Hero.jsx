import { useState, useEffect } from "react";
import api from "../../../api/axios";
import "./Hero.css";

export default function Hero() {
  const [banners, setBanners] = useState([]);
  const [currentIndex, setCurrentIndex] = useState(0);
  const [loading, setLoading] = useState(true);
  const [lang] = useState(localStorage.getItem("lang") || "ar");
  const isRTL = lang === "ar";

  useEffect(() => {
    const fetchBanners = async () => {
      try {
        const response = await api.get("/banners");
        const activeBanners = (response.data || [])
          .filter((banner) => banner.status === "active")
          .sort((a, b) => a.sort_order - b.sort_order);

        setBanners(activeBanners);
        console.log("Fetched hero banners:", activeBanners);
      } catch (err) {
        console.error("Failed to load hero banner slides:", err);
      } finally {
        setLoading(false);
      }
    };

    fetchBanners();
  }, []);

  // Auto-slide cycle every 6 seconds
  useEffect(() => {
    if (banners.length <= 1) return;
    const interval = setInterval(() => {
      setCurrentIndex((prevIndex) => (prevIndex + 1) % banners.length);
    }, 6000);
    return () => clearInterval(interval);
  }, [banners]);

  if (loading) {
   return (
    <section className="hero-container">
      <div className="hero-skeleton" style={{ height: "80vh", width: "100%" }}>
      </div>
    </section>
  );
  }

  if (banners.length === 0) return null;

  return (
    <section className="hero-container" dir={isRTL ? "rtl" : "ltr"}>
      {banners.map((banner, index) => {
        const isActive = index === currentIndex;

        const gradientDir = isRTL ? "to left" : "to right";

        return (
          <div
            key={banner.id}
            className={`hero-slide ${isActive ? "active" : ""}`}
            style={{
              backgroundImage: `linear-gradient(${gradientDir}, rgba(15, 23, 42, 0.9) 20%, rgba(15, 23, 42, 0.4) 70%), url(${banner.image_url})`,
            }}
          >
            <div className="hero-content">
              <div className={`hero-glass-card ${isActive ? "fade-up" : ""}`}>
                <h1 className="hero-title">{banner.title}</h1>
                <p className="hero-subtitle">{banner.subtitle}</p>

                {banner.button_text && banner.button_url && (
                  <a
                    href={banner.button_url}
                    target={
                      banner.button_url.startsWith("http") ||
                      banner.button_url.includes("chat.whatsapp")
                        ? "_blank"
                        : "_self"
                    }
                    rel="noreferrer"
                    className="btn-primary hero-btn"
                  >
                    {banner.button_text}
                  </a>
                )}
              </div>
            </div>
          </div>
        );
      })}

      {banners.length > 1 && (
        <div className="hero-indicators">
          {banners.map((_, index) => (
            <button
              key={index}
              className={`indicator ${index === currentIndex ? "active" : ""}`}
              onClick={() => setCurrentIndex(index)}
              aria-label={`Go to slide ${index + 1}`}
            />
          ))}
        </div>
      )}
    </section>
  );
}
