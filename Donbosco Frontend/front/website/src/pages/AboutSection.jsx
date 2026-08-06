import { useState, useEffect } from "react";
import api from "../api/axios";
import SkeletonAbout from "../components/Loader/SkeletonAbout";

const AboutSection = () => {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);

  const lang = localStorage.getItem("lang") || "ar";

  useEffect(() => {
    const fetchAboutData = async () => {
      try {
        setLoading(true);

        const res = await api.get("/pages");

        if (Array.isArray(res.data)) {
          setData(res.data);
        } else {
          setData([]);
        }
      } catch (err) {
        console.log("ERROR:", err);
        setData([]);
      } finally {
        setLoading(false);
      }
    };

    fetchAboutData();
  }, []);

  const styles = {
    sectionWrapper: {
      direction: lang === "ar" ? "rtl" : "ltr",
      padding: "60px 20px",
      fontFamily: "Segoe UI, Tahoma, Geneva, Verdana, sans-serif",
      color: "#333",
      backgroundColor: "#fff",
      minHeight: "100vh",
    },
    container: {
      maxWidth: "1100px",
      margin: "0 auto",
    },
    headerArea: {
      textAlign: "center",
      marginBottom: "50px",
    },
    mainTitle: {
      fontSize: "2.5rem",
      color: "#0056b3",
      marginBottom: "10px",
    },
    divider: {
      width: "60px",
      height: "4px",
      backgroundColor: "#0056b3",
      margin: "0 auto",
      borderRadius: "2px",
    },
    contentBlock: {
      marginBottom: "30px",
      lineHeight: "1.8",
      fontSize: "1.1rem",
      textAlign: "justify",
      backgroundColor: "#f8f9fa",
      padding: "30px",
      borderRadius: "15px",
      borderRight: lang==="ar" ? "6px solid #0056b3" : "none",
      borderLeft: lang === "en" ? "6px solid #0056b3" : "none",
      boxShadow: "0 5px 20px rgba(0,0,0,0.05)",
    },
  };

  if (loading) {
    return (
      <SkeletonAbout count={data.length || 4} styles={styles} lang={lang}/>
    );
  }

  return (
    <div style={styles.sectionWrapper}>
      <div style={styles.container}>
        <div style={styles.headerArea}>
          <h1 style={styles.mainTitle}>
            {lang === "ar" ? "من نحن" : "About Us"}
          </h1>

          <div style={styles.divider}></div>
        </div>

        {data.length === 0 ? (
          <div style={{ textAlign: "center", color: "#999" }}>
            {lang === "ar" ? "لا يوجد بيانات" : "No data available"}
          </div>
        ) : (
          data.map((item) => (
            <section key={item.id} style={styles.contentBlock}>
              <h2 style={{ color: "#0056b3", marginBottom: "15px" }}>
                {item.title}
              </h2>

              <div
                style={{ color: "#555" }}
                dangerouslySetInnerHTML={{ __html: item.content }}
              />
            </section>
          ))
        )}
      </div>
    </div>
  );
};

export default AboutSection;
