import { useState, useEffect } from "react";
import api from "../../api/axios";
import ImageWithLoader from "../Loader/ImageWithLoader";
import Loader from "../Loader/Loader";
const EventsSection = () => {
  const [events, setEvents] = useState([]);
  const [loading, setLoading] = useState(true);
  const lang = localStorage.getItem("lang") || "ar";
  const fetchEvents = async () => {
    try {
      setLoading(true);
      const res = await api.get(`/events?page=1`);

      if (Array.isArray(res.data?.data)) {
        setEvents(res.data.data.slice(0, 2));
        console.log("Fetched events:", res.data.data);
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
    fetchEvents();
  }, []);

  if (loading) {
    return <Loader rows={2}/>;
  }
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
        {lang === "ar" ? "الفعاليات" : "Events"}
      </h1>

      {events.length === 0 ? (
        <div style={{ textAlign: "center", color: "#999" }}>
          {lang === "ar" ? "لا يوجد فعاليات" : "No events available"}
        </div>
      ) : (
        <div
          style={{
            display: "grid",
            gridTemplateColumns: "repeat(auto-fill, minmax(320px, 1fr))",
            gap: "30px",
            maxWidth: "1000px",
            margin: "0 auto",
            direction: lang === "ar" ? "rtl" : "ltr",
          }}
        >
          {events.map((item) => (
            <div
              key={item.id}
              style={{
                backgroundColor: "#fff",
                borderRadius: "25px",
                overflow: "hidden",
                boxShadow: "0 10px 30px rgba(0,0,0,0.05)",
                border: "1px solid #f0f0f0",
                transition: "all 0.4s ease",
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
              <ImageWithLoader src={item.cover_image} alt={item.title} />
              <div style={{ padding: "22px" }}>
                <h3
                  style={{
                    color: "#0056b3",
                    marginBottom: "10px",
                    fontWeight: "bold",
                  }}
                >
                  {item.title}
                </h3>
                <p
                  style={{
                    color: "#666",
                    lineHeight: "1.7",
                    minHeight: "60px",
                  }}
                >
                  {item.description}
                </p>
                <div
                  style={{
                    marginTop: "10px",
                    fontSize: "0.85rem",
                    color: "#777",
                  }}
                >
                  📍 {item.location}
                </div>
                <div
                  style={{
                    marginTop: "10px",
                    fontSize: "0.8rem",
                    color: "#999",
                    borderTop: "1px solid #eee",
                    paddingTop: "10px",
                  }}
                >
                  ⏰ {item.start_time}
                </div>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default EventsSection;
