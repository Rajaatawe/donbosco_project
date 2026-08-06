import { useState, useEffect } from "react";
import api from "../api/axios";

const EventsSection = () => {
  const [events, setEvents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);

  const fetchEvents = async (page = 1) => {
    try {
      setLoading(true);
      // Added per_page=10 to the API call
      const res = await api.get(`/events?page=${page}&per_page=10`);

      if (Array.isArray(res.data?.data)) {
        setEvents(res.data.data);
        setCurrentPage(res.data.current_page);
        setLastPage(res.data.last_page);
      } else {
        setEvents([]);
      }
    } catch (err) {
      console.log("ERROR:", err);
      setEvents([]);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchEvents(1);
  }, []);

  if (loading)
    return (
      <div style={{ textAlign: "center", padding: "50px" }}>
        جاري تحميل الفعاليات...
      </div>
    );

  return (
    <div style={{ padding: "40px", direction: "rtl" }}>
      <h1
        style={{
          textAlign: "center",
          marginBottom: "40px",
          fontSize: "2.5rem",
          color: "#0056b3",
          fontWeight: "bold",
        }}
      >
        الفعاليات
      </h1>

      {events.length === 0 ? (
        <div style={{ textAlign: "center", color: "#999" }}>
          لا يوجد فعاليات
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
            {events.map((item) => (
              <div
                key={item.id}
                style={{
                  backgroundColor: "#fff",
                  borderRadius: "20px",
                  overflow: "hidden",
                  boxShadow: "0 5px 15px rgba(0,0,0,0.08)",
                  border: "1px solid #eee",
                  transition: "all 0.3s ease",
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
                <img
                  src={item.cover_image}
                  alt={item.title}
                  style={{ width: "100%", height: "200px", objectFit: "cover" }}
                />
                <div style={{ padding: "20px" }}>
                  <h3
                    style={{
                      color: "#333",
                      marginBottom: "10px",
                      fontSize: "1.2rem",
                    }}
                  >
                    {item.title}
                  </h3>
                  <p
                    style={{
                      color: "#666",
                      fontSize: "0.9rem",
                      lineHeight: "1.6",
                    }}
                  >
                    {item.description}
                  </p>
                  <div
                    style={{
                      marginTop: "15px",
                      fontSize: "0.8rem",
                      color: "#888",
                    }}
                  >
                    📍 {item.location}
                  </div>
                  <div style={{ fontSize: "0.8rem", color: "#888" }}>
                    ⏰ {item.start_time}
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
              onClick={() => fetchEvents(currentPage - 1)}
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
              السابق
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
              onClick={() => fetchEvents(currentPage + 1)}
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
              التالي
            </button>
          </div>
        </>
      )}
    </div>
  );
};

export default EventsSection;
