import { useState } from "react";
import { Link } from "react-router-dom"; // Import Link
import "./Navbar.css";
import { useNavigate } from "react-router-dom";
export default function Navbar() {
  const [lang] = useState(localStorage.getItem("lang") || "ar");
  const navigate = useNavigate();
  // 1. Defined paths explicitly to match AppRoutes.jsx exactly
  const links = [
    { en: "About Us", ar: "من نحن", path: "/about" },
    { en: "Programs", ar: "البرامج", path: "/programs" },
    { en: "Activities", ar: "النشاطات", path: "/activities" },
    { en: "News", ar: "الأخبار", path: "/news" },
    { en: "Events", ar: "الفعاليات", path: "/events" },
    { en: "Albums", ar: "الألبومات", path: "/gallery" },
    { en: "Contact Us", ar: "اتصل بنا", path: "/contact" },
  ];
  const token = localStorage.getItem("access_token");
  const toggleLang = () => {
    const newLang = lang === "en" ? "ar" : "en";
    localStorage.setItem("lang", newLang);
    window.location.reload();
  };

  const isRTL = lang === "ar";

  return (
    <header className="navbar" dir={isRTL ? "rtl" : "ltr"}>
      <div className="nav-container">
        <div className="logo">
          <Link to="/">
            <span className="logo-text">DonBosco</span>
          </Link>
        </div>

        <nav className="nav-links">
          {/* Home Link */}
          <Link to="/">{lang === "ar" ? "الرئيسية" : "Home"}</Link>

          {/* Mapped Links using explicit paths */}
          {links.map((link, idx) => (
            <Link key={idx} to={link.path}>
              {lang === "ar" ? link.ar : link.en}
            </Link>
          ))}
        </nav>

        <div className="nav-actions">
          {token ? (
            <button
              className="lang-toggle"
              onClick={() => {
                localStorage.removeItem("access_token");
                window.location.reload();
              }}
            >
              {lang === "ar" ? "تسجيل الخروج" : "Logout"}
            </button>
          ) : (
            <button
              className="lang-toggle"
              onClick={() => {
                navigate("/login");
              }}
            >
              {lang === "ar" ? "انضم إلينا" : "Join Us"}
            </button>
          )}

          {/* Language Toggle */}
          <button className="lang-toggle" onClick={toggleLang}>
            {lang === "ar" ? "English" : "عربي"}
          </button>
        </div>
      </div>
    </header>
  );
}
