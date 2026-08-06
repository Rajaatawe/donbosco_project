import { useState, useEffect } from "react";
import { FaFacebook, FaInstagram, FaWhatsapp } from "react-icons/fa"; // Swapped FaPhone to FaWhatsapp for community context
import api from "../../../api/axios"; // Adjust path to match your axios instance
import "./Footer.css";

export default function Footer() {
  const [settings, setSettings] = useState({});
  const [loading, setLoading] = useState(true);
  const [lang] = useState(localStorage.getItem("lang") || "ar");
  const isRTL = lang === "ar";
  const cleanUrl = (url) => {
    if (!url) return "#";
    // Remove quotes and fix double slashes if they exist
    return url.replace(/['"]/g, "").replace(/([^:]\/)\/+/g, "$1");
  };

  const fbUrl = cleanUrl(settings.facebook_url);
  const instaUrl = cleanUrl(settings.instagram_url);
  const waUrl = cleanUrl(settings.whatsapp_community);
  useEffect(() => {
    const fetchSettings = async () => {
      try {
        const response = await api.get("/settings");

        // Convert Laravel's key-value array collection into a clean object mapping
        const settingsMap = response.data.reduce((acc, item) => {
          acc[item.key] = item.value;
          return acc;
        }, {});

        setSettings(settingsMap);
      } catch (err) {
        console.error("Failed to load site configurations:", err);
      } finally {
        setLoading(false);
      }
    };

    fetchSettings();
  }, []);

  // Safeguard layout framework while loading background values
  if (loading) return null;

  // Gracefully fallback on missing keys from parsed state
  const siteName =
    settings.site_name || (isRTL ? "مركز دون بوسكو" : "DonBosco Center");
  const siteSlogan = settings.site_slogan || "";
  const tvetPhone = settings.tvet_phone || "";
  const phone1 = settings.management_phone_1 || "";
  const phone2 = settings.management_phone_2 || "";

  return (
    <footer className="footer" dir={isRTL ? "rtl" : "ltr"}>
      <div className="footer-container">
        {/* Column 1: Brand Section */}
        <div className="footer-brand">
          <h2 className="footer-title">{siteName}</h2>
          {siteSlogan && <p className="footer-slogan">{siteSlogan}</p>}
        </div>

        {/* Column 2: Premium Interactive Map Embed Container */}
        <div className="footer-map-container">
          <h3>{isRTL ? "موقعنا على الخريطة" : "Our Location"}</h3>
          <div className="map-frame-wrapper">
            <iframe
              title="Don Bosco Center Jaramana Location"
              src="https://maps.google.com/maps?q=F8VM%2B9QJ, Damascus, Syria&z=16&output=embed"
              width="100%"
              height="180"
              style={{ border: 0 }}
              allowFullScreen=""
              loading="lazy"
              referrerPolicy="no-referrer-when-downgrade"
            ></iframe>
          </div>
        </div>

        {/* Column 3: Dynamic Contact Column */}
        <div className="footer-contact">
          <h3>{isRTL ? "معلومات الاتصال" : "Contact Info"}</h3>

          {tvetPhone && (
            <p className="contact-item">
              <strong>
                {isRTL ? "قسم التعليم المهني TVET:" : "TVET Dept:"}
              </strong>
              <span className="phone-number">{tvetPhone}</span>
            </p>
          )}
          {phone1 && (
            <p className="contact-item">
              <strong>{isRTL ? "الإدارة 1:" : "Management 1:"}</strong>
              <span className="phone-number">{phone1}</span>
            </p>
          )}
          {phone2 && (
            <p className="contact-item">
              <strong>{isRTL ? "الإدارة 2:" : "Management 2:"}</strong>
              <span className="phone-number">{phone2}</span>
            </p>
          )}

          {/* Luxury Micro-interacted Icon Actions */}
          <div className="footer-contact">
            <h3>{isRTL ? "معلومات الاتصال" : "Contact Info"}</h3>

            {/* ... (Keep your phone number mapping as is) ... */}

            {/* FIXED SOCIALS SECTION */}
            <div className="socials">
              <a
                href={fbUrl}
                target="_blank"
                rel="noopener noreferrer"
                className="socials-label"
              >
                <FaFacebook size={20} />
              </a>

              <a
                href={instaUrl}
                target="_blank"
                rel="noopener noreferrer"
                className="socials-label"
              >
                <FaInstagram size={20} />
              </a>

              <a
                href={waUrl}
                target="_blank"
                rel="noopener noreferrer"
                className="socials-label"
              >
                <FaWhatsapp size={20} />
              </a>
            </div>
          </div>
        </div>
      </div>

      <div className="footer-bottom">
        <p>© 2026 {siteName}. All rights reserved.</p>
      </div>
    </footer>
  );
}
