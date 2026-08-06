import { useState, useEffect } from "react";
import api from "../api/axios";
import { useNavigate } from "react-router-dom";
import ImageWithLoader from "../components/Loader/ImageWithLoader";
import { NewsSkeleton } from "../components/Loader/NewsSkeleton";

const NewsSection = () => {
  const navigate = useNavigate();
  const [news, setNews] = useState([]);
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const lang = localStorage.getItem("lang") || "ar";
  const fetchNews = async (page = 1) => {
    try {
      setLoading(true);
      // Fetches 10 items per page
      const res = await api.get(`/news?page=${page}`);

      if (Array.isArray(res.data?.data)) {
        setNews(res.data.data);
        setCurrentPage(res.data.current_page);
        setLastPage(res.data.last_page);
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
    fetchNews(1);
  }, []);

  if (loading)
    return (
      <NewsSkeleton count={10} lang={lang} />
    );

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
        <>
          <div
            style={{
              display: "grid",
              gridTemplateColumns: "repeat(auto-fill,minmax(320px,1fr))",
              gap: "30px",
            }}
          >
            {news.map((item) => (
              <div
                key={item.id}
               
                style={{
                  backgroundColor: "#fff",
                  borderRadius: "20px",
                  overflow: "hidden",
                  boxShadow: "0 5px 15px rgba(0,0,0,0.08)",
                  border: "1px solid #f0f0f0",
                  transition: "all 0.4s ease",
                }}
                onMouseEnter={(e) => {
                  e.currentTarget.style.transform = "translateY(-5px)";
                  e.currentTarget.style.boxShadow =
                    "0 15px 30px rgba(0,0,0,0.15)";
                }}
                onMouseLeave={(e) => {
                  e.currentTarget.style.transform = "translateY(0)";
                  e.currentTarget.style.boxShadow =
                    "0 5px 15px rgba(0,0,0,0.08)";
                }}
              >
                <div style={{ position: "relative" }}>
                 <ImageWithLoader src={item.image_url} alt={item.title} />
                </div>

                <div style={{ padding: "22px" }}>
                  <h3
                    style={{
                      color: "#333",
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

          {/* New Modern Pagination Design */}
          <div
            style={{
              display: "flex",
              justifyContent: "center",
              alignItems: "center",
              gap: "10px",
              marginTop: "50px",
            }}
          >
            <button
              disabled={currentPage === 1}
              onClick={() => fetchNews(currentPage - 1)}
              style={{
                padding: "8px 20px",
                borderRadius: "50px",
                border: "none",
                backgroundColor: currentPage === 1 ? "#eee" : "#0056b3",
                color: currentPage === 1 ? "#aaa" : "#fff",
                cursor: currentPage === 1 ? "not-allowed" : "pointer",
                transition: "0.3s",
                fontWeight: "bold",
              }}
            >
              {lang === "ar" ? "السابق" : "Previous"}
            </button>

            <div
              style={{
                padding: "8px 15px",
                backgroundColor: "#f8f9fa",
                borderRadius: "10px",
                fontWeight: "bold",
                color: "#333",
              }}
            >
              {currentPage} / {lastPage}
            </div>

            <button
              disabled={currentPage === lastPage}
              onClick={() => fetchNews(currentPage + 1)}
              style={{
                padding: "8px 20px",
                borderRadius: "50px",
                border: "none",
                backgroundColor: currentPage === lastPage ? "#eee" : "#0056b3",
                color: currentPage === lastPage ? "#aaa" : "#fff",
                cursor: currentPage === lastPage ? "not-allowed" : "pointer",
                transition: "0.3s",
                fontWeight: "bold",
              }}
            >
              {lang === "ar" ? "التالي" : "Next"}
            </button>
          </div>
        </>
      )}
    </div>
  );
};

export default NewsSection;
