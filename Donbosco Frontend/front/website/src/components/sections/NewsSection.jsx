import { useState, useEffect } from "react";
import api from "../../api/axios";
import { useNavigate } from "react-router-dom";
import Loader from "../Loader/Loader";
import ImageWithLoader from "../Loader/ImageWithLoader";

const NewsSection = () => {
  const navigate = useNavigate();
  const [news, setNews] = useState([]);
  const [loading, setLoading] = useState(true);
  const lang = localStorage.getItem("lang") || "ar";
  const fetchNews = async () => {
    try {
      setLoading(true);
      const res = await api.get(`/news?page=1`);

      if (Array.isArray(res.data?.data)) {
        setNews(res.data.data.slice(0, 2));
        console.log("Fetched news:", res.data.data);
      } else {
        setNews([]);
      }
    } catch (err) {
      console.log("ERROR:", err);
      setNews([]);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchNews();
  }, []);

  if (loading) return <Loader rows={2}/>;
  return (
    <div style={{ padding: "40px", direction: lang === "ar" ? "rtl" : "ltr" }}>
      <h1
        style={{
          textAlign: "center",
          marginBottom: "40px",
          fontSize: "2.5rem",
          color: "#0056b3",
          fontWeight: "bold",
        }}
      >
        {lang === "ar" ? "الأخبار" : "News"}
      </h1>

      {news.length === 0 ? (
        <div style={{ textAlign: "center", color: "#999" }}>
          {lang === "ar" ? "لا يوجد أخبار" : "No news available"}
        </div>
      ) : (
        <div
          style={{
            display: "grid",
            gridTemplateColumns: "repeat(auto-fill, minmax(320px, 1fr))",
            gap: "30px",
            maxWidth: "1000px",
            margin: "0 auto",
          }}
        >
          {news.map((item) => (
            <div
              key={item.id}
              onClick={() => navigate(`/news/${item.id}`)}
              style={{
                backgroundColor: "#fff",
                borderRadius: "25px",
                overflow: "hidden",
                boxShadow: "0 10px 30px rgba(0,0,0,0.05)",
                border: "1px solid #f0f0f0",
                transition: "all 0.4s ease",
                cursor: "pointer",
              }}
              onMouseEnter={(e) => {
                e.currentTarget.style.transform = "translateY(-10px)";
                e.currentTarget.style.boxShadow = "0 20px 50px rgba(0,0,0,0.1)";
              }}
              onMouseLeave={(e) => {
                e.currentTarget.style.transform = "translateY(0)";
                e.currentTarget.style.boxShadow =
                  "0 10px 30px rgba(0,0,0,0.05)";
              }}
            >
              <div style={{ position: "relative" }}>
                <ImageWithLoader src={item.image_url} alt={item.title} />
              </div>

              <div style={{ padding: "22px" }}>
                <h3
                  style={{
                    color: "#0056b3",
                    marginBottom: "10px",
                    fontSize: "1.2rem",
                    fontWeight: "bold",
                  }}
                >
                  {item.title}
                </h3>
                <p
                  style={{
                    color: "#666",
                    fontSize: "0.95rem",
                    lineHeight: "1.7",
                    minHeight: "60px",
                  }}
                >
                  {item.summary}
                </p>
                <div
                  style={{
                    marginTop: "15px",
                    fontSize: "0.8rem",
                    color: "#999",
                    borderTop: "1px solid #eee",
                    paddingTop: "10px",
                  }}
                >
                  📅 {item.published_at}
                </div>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default NewsSection;
