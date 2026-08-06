import { useState, useEffect } from "react";
import axios from "axios";
import { ArrowLeft, Sparkles } from "lucide-react";

const HeroSection = () => {
  const [banners, setBanners] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchBanners = async () => {
      try {
        const res = await axios.get("http://localhost:8000/api/banners");
        console.log(res);
        if (Array.isArray(res.data)) {
          const sorted = res.data.sort((a, b) => a.sort_order - b.sort_order);
          setBanners(sorted);
        }
      } catch (err) {
        console.log(err);
      } finally {
        setLoading(false);
      }
    };

    fetchBanners();
  }, []);

  const styles = {
    section: {
      padding: "80px 20px",
      direction: "rtl",
      maxWidth: "1200px",
      margin: "0 auto",
    },
    container: {
      display: "flex",
      alignItems: "center",
      gap: "40px",
      flexWrap: "wrap",
      marginBottom: "80px",
    },
    textSide: {
      flex: "1 1 500px",
    },
    imageSide: {
      flex: "1 1 400px",
      position: "relative",
    },
    image: {
      width: "100%",
      height: "420px",
      objectFit: "cover",
      borderRadius: "2.5rem",
      boxShadow: "0 20px 40px rgba(0,0,0,0.08)",
    },
    badge: {
      background: "#e6f0ff",
      color: "#0056b3",
      padding: "8px 20px",
      borderRadius: "12px",
      display: "inline-flex",
      alignItems: "center",
      gap: "8px",
      marginBottom: "20px",
    },
    title: {
      fontSize: "2.7rem",
      color: "#0056b3",
      fontWeight: "800",
      marginBottom: "20px",
    },
    subtitle: {
      fontSize: "1.2rem",
      color: "#555",
      marginBottom: "30px",
      lineHeight: "1.8",
    },
    btn: {
      backgroundColor: "#0056b3",
      color: "#fff",
      padding: "14px 30px",
      borderRadius: "15px",
      border: "none",
      display: "flex",
      alignItems: "center",
      gap: "10px",
      cursor: "pointer",
    },
  };

  if (loading) return null;

  return (
    <section style={styles.section}>
      {banners.map((item, index) => (
        <div
          key={item.id}
          style={{
            ...styles.container,
            flexDirection: index % 2 === 0 ? "row" : "row-reverse",
          }}
        >
          {/* النص */}
          <div style={styles.textSide}>
            <div style={styles.badge}>
              <Sparkles size={18} />
              قسم مميز
            </div>

            <h1 style={styles.title}>{item.title}</h1>

            <p style={styles.subtitle}>{item.subtitle}</p>

            <button
              style={styles.btn}
              onClick={() => {
                if (item.button_url.startsWith("http")) {
                  window.open(item.button_url, "_blank");
                } else {
                  window.location.href = item.button_url;
                }
              }}
            >
              {item.button_text}
              <ArrowLeft size={20} />
            </button>
          </div>

          {/* الصورة */}
          <div style={styles.imageSide}>
            <img src={item.image_url} alt="" style={styles.image} />
          </div>
        </div>
      ))}
    </section>
  );
};

export default HeroSection;