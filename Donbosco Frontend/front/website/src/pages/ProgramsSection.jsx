import { useState, useEffect } from "react";
import api from "../api/axios";
import { useNavigate } from "react-router-dom";
import SkeletonPrograms from "../components/Loader/SkeletonPrograms";
import ImageWithLoader from "../components/Loader/ImageWithLoader";

const ProgramsSection = () => {
  const navigate = useNavigate();

  const [programs, setPrograms] = useState([]);
  const [loading, setLoading] = useState(true);

  const [message, setMessage] = useState("");
  const [type, setType] = useState("");

  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const lang = localStorage.getItem("lang") || "ar";
  const formatDate = (dateField) => {
    if (typeof dateField === "object" && dateField !== null && dateField.date) {
      return dateField.date.split(" ")[0];
    }
    return dateField;
  };

  const fetchPrograms = async (page = 1) => {
    try {
      setLoading(true);
      const res = await api.get(`/programs?page=${page}`);

      if (Array.isArray(res.data?.data)) {
        setPrograms(res.data.data);
        setCurrentPage(res.data.current_page);
        setLastPage(res.data.last_page);
      } else {
        setPrograms([]);
      }
    } catch (err) {
      console.log("ERROR:", err);
      setPrograms([]);
    } finally {
      setLoading(false);
    }
  };

  const handleApply = async (programId, e) => {
    e.stopPropagation();
    const token = localStorage.getItem("access_token");

    if (!token) {
      navigate("/login");
      return;
    }

    try {
      await api.get(`/programs/${programId}/apply`);
      setType("success");
      setMessage(lang === "ar" ? "تم التسجيل بنجاح ✅" : "Successfully registered ✅");
    } catch (error) {
      if (error.response?.status === 409) {
        setType("warning");
        setMessage(lang === "ar" ? "أنت مسجل بالفعل في هذا البرنامج ⚠️" : "You are already registered for this program ⚠️");
      } else if (error.response?.status === 401) {
        setType("error");
        setMessage(lang === "ar" ? "انتهت الجلسة، حاول مجدداً" : "Session expired, please try again");
      } else {
        setType("error");
        setMessage(lang === "ar" ? "فشل التسجيل، حاول مجدداً" : "Failed to register, please try again");
      }
    }
  };

  useEffect(() => {
    fetchPrograms(1);
  }, []);

  useEffect(() => {
    if (message) {
      const timer = setTimeout(() => {
        setMessage("");
      }, 4000);
      return () => clearTimeout(timer);
    }
  }, [message]);

  if (loading)
    return (
      <SkeletonPrograms count={10} lang={lang}/>
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
       {lang === "ar" ? "البرامج والدورات" : "Programs and Courses"}
      </h1>

      {message && (
        <div
          style={{
            marginBottom: "20px",
            padding: "15px",
            borderRadius: "15px",
            textAlign: "center",
            fontWeight: "bold",
            background:
              type === "success"
                ? "#e6f7ee"
                : type === "warning"
                  ? "#fff4e5"
                  : "#ffe5e5",
            color:
              type === "success"
                ? "#1e7e34"
                : type === "warning"
                  ? "#b26a00"
                  : "#d8000c",
            border:
              type === "success"
                ? "1px solid #b7ebc6"
                : type === "warning"
                  ? "1px solid #ffe0b2"
                  : "1px solid #f5c6cb",
          }}
        >
          {message}
        </div>
      )}
      
      {programs.length === 0 ? (
        <div style={{ textAlign: "center", color: "#999" }}>
          {lang === "ar" ? "لا يوجد برامج" : "No programs available"}
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
            {programs.map((item) => (
              <div
                key={item.id}
                style={{ direction: lang === "ar" ? "rtl" : "ltr" }}
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
                  <ImageWithLoader src={item.cover_image} alt={item.title} />
                </div>

                <div style={{ padding: "20px" }}>
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
                      fontSize: "0.9rem",
                      lineHeight: "1.7",
                      minHeight: "60px",
                    }}
                  >
                    {item.description}
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
                    📅 {formatDate(item.start_date)}
                  </div>

                  <button
                    onClick={(e) => handleApply(item.id, e)}
                    style={{
                      marginTop: "20px",
                      width: "100%",
                      padding: "12px",
                      border: "none",
                      borderRadius: "12px",
                      backgroundColor: "#0056b3",
                      color: "#fff",
                      fontSize: "1rem",
                      fontWeight: "bold",
                      cursor: "pointer",
                      transition: "0.3s",
                    }}
                  >
                    {lang === "ar" ? "سجل الآن" : "Register Now"}
                  </button>
                </div>
              </div>
            ))}
          </div>

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
              onClick={() => fetchPrograms(currentPage - 1)}
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
              onClick={() => fetchPrograms(currentPage + 1)}
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

export default ProgramsSection;
