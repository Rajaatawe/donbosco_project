import { useState, useEffect } from "react";
import api from "../api/axios";
import { ArrowLeft, ArrowRight, Star, Calendar } from "lucide-react";
import ImageWithLoader from "../components/Loader/ImageWithLoader";

const ActivitiesSection = () => {
  const [activities, setActivities] = useState([]);
  const [categories, setCategories] = useState([]);
  const [selectedActivity, setSelectedActivity] = useState(null);

  // Separate loading states so the filters don't vanish
  const [isActivitiesLoading, setIsActivitiesLoading] = useState(true);
  const [isCategoriesLoading, setIsCategoriesLoading] = useState(true);

  // Backend params state
  const [filter, setFilter] = useState("all");
  const [page, setPage] = useState(1);
  const [totalPages, setTotalPages] = useState(1);

  const lang = localStorage.getItem("lang") || "ar";
  const isRTL = lang === "ar";

  // 1. Fetch Categories ONLY ONCE
  useEffect(() => {
    const fetchCategories = async () => {
      try {
        setIsCategoriesLoading(true);
        const catRes = await api.get("/activity-categories");
        setCategories(catRes.data || []);
      } catch (err) {
        console.error("ERROR fetching categories:", err);
      } finally {
        setIsCategoriesLoading(false);
      }
    };
    fetchCategories();
  }, []);

  useEffect(() => {
    const fetchActivities = async () => {
      try {
        setIsActivitiesLoading(true);
        const queryParams = { page: page };
        if (filter !== "all") {
          queryParams.category_id = filter;
        }

        const actRes = await api.get("/activities", { params: queryParams });
        setActivities(actRes.data?.data || actRes.data || []);
        const lastPage =
          actRes.data?.meta?.last_page || actRes.data?.last_page || 1;
        setTotalPages(lastPage);
      } catch (err) {
        console.error("ERROR fetching activities:", err);
      } finally {
        setIsActivitiesLoading(false);
      }
    };

    fetchActivities();
  }, [filter, page]);

  // --- HANDLERS ---
  const handleFilterChange = (categoryId) => {
    if (filter === categoryId) return; 
    setActivities([])
    setIsActivitiesLoading(true);
    setFilter(categoryId);
    setPage(1);
    setSelectedActivity(null);
  };

  const handlePageChange = (newPage) => {
    setPage(newPage);
    window.scrollTo({ top: 0, behavior: "smooth" });
  };

  const getCategoryName = (id) => {
    const cat = categories.find((c) => Number(c.id) === Number(id));
    return cat ? cat.name : "";
  };

  // --- STYLES CONFIGURATION ---
  const styles = {
    sectionWrapper: {
      padding: "60px 20px",
      direction: isRTL ? "rtl" : "ltr",
      backgroundColor: "#fcfcfc",
      minHeight: "100vh",
      fontFamily: "Segoe UI, Tahoma, Geneva, Verdana, sans-serif",
    },
    container: {
      maxWidth: "1200px",
      margin: "0 auto",
    },
    headerArea: {
      textAlign: "center",
      marginBottom: "50px",
    },
    mainTitle: {
      fontSize: "2.8rem",
      color: "#0056b3",
      fontWeight: "800",
      marginBottom: "10px",
    },
    divider: {
      width: "80px",
      height: "5px",
      backgroundColor: "#0056b3",
      margin: "0 auto",
      borderRadius: "10px",
    },
    filterContainer: {
      display: "flex",
      justifyContent: "center",
      gap: "15px",
      marginBottom: "50px",
      flexWrap: "wrap",
    },
    grid: {
      display: "grid",
      gridTemplateColumns: "repeat(auto-fill, minmax(320px, 1fr))",
      gap: "30px",
    },
    paginationContainer: {
      display: "flex",
      justifyContent: "center",
      alignItems: "center",
      gap: "10px",
      marginTop: "50px",
    },
    paginationBtn: {
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      width: "40px",
      height: "40px",
      borderRadius: "50%",
      border: "none",
      fontWeight: "bold",
      cursor: "pointer",
      transition: "all 0.3s ease",
    },
  };

  // --- 1. DETAIL VIEW RENDER ---
  if (selectedActivity) {
    return (
      <div style={styles.sectionWrapper}>
        <div style={{ maxWidth: "900px", margin: "0 auto" }}>
          {/* Back Button */}
          <button
            onClick={() => setSelectedActivity(null)}
            style={{
              display: "flex",
              alignItems: "center",
              gap: "8px",
              background: "none",
              border: "none",
              color: "#0056b3",
              fontSize: "1.1rem",
              fontWeight: "bold",
              cursor: "pointer",
              marginBottom: "30px",
              padding: "10px 0",
              transition: "transform 0.2s ease",
            }}
            onMouseEnter={(e) =>
              (e.currentTarget.style.transform = isRTL
                ? "translateX(5px)"
                : "translateX(-5px)")
            }
            onMouseLeave={(e) =>
              (e.currentTarget.style.transform = "translateX(0)")
            }
          >
            {isRTL ? <ArrowRight size={20} /> : <ArrowLeft size={20} />}
            {isRTL ? "الرجوع للأنشطة" : "Back to Activities"}
          </button>

          {/* Premium Article Layout */}
          <div
            style={{
              backgroundColor: "#fff",
              borderRadius: "24px",
              overflow: "hidden",
              boxShadow: "0 10px 40px rgba(0,0,0,0.06)",
              border: "1px solid #eee",
            }}
          >
            <div style={{ position: "relative" }}>
              {selectedActivity.is_featured === 1 && (
                <div
                  style={{
                    position: "absolute",
                    top: "20px",
                    [isRTL ? "right" : "left"]: "20px",
                    background: "linear-gradient(135deg, #ff9800, #f57c00)",
                    color: "#fff",
                    padding: "8px 16px",
                    borderRadius: "30px",
                    fontWeight: "bold",
                    display: "flex",
                    alignItems: "center",
                    gap: "6px",
                    boxShadow: "0 4px 15px rgba(255, 152, 0, 0.4)",
                    zIndex: 2,
                  }}
                >
                  <Star size={16} fill="#fff" />{" "}
                  {isRTL ? "نشاط مميز" : "Featured"}
                </div>
              )}
              <ImageWithLoader
                src={selectedActivity.image_url}
                alt={selectedActivity.title}
              />
            </div>

            <div style={{ padding: "40px" }}>
              <div
                style={{
                  display: "inline-block",
                  padding: "6px 14px",
                  backgroundColor: "#e8f2ff",
                  color: "#0056b3",
                  borderRadius: "8px",
                  fontWeight: "bold",
                  fontSize: "0.9rem",
                  marginBottom: "15px",
                }}
              >
                {getCategoryName(selectedActivity.activity_category_id)}
              </div>
              <h1
                style={{
                  fontSize: "2.2rem",
                  color: "#222",
                  marginBottom: "20px",
                }}
              >
                {selectedActivity.title}
              </h1>
              <div
                style={{
                  color: "#555",
                  fontSize: "1.1rem",
                  lineHeight: "1.9",
                  whiteSpace: "pre-line",
                }}
              >
                {selectedActivity.content}
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }

  // --- 2. MAIN GRID VIEW RENDER ---
  return (
    <div style={styles.sectionWrapper}>
      <div style={styles.container}>
        {/* HEADER */}
        <div style={styles.headerArea}>
          <h1 style={styles.mainTitle}>{isRTL ? "الأنشطة" : "Activities"}</h1>
          <div style={styles.divider}></div>
        </div>

        {/* FILTER CHIPS (Always visible unless categories are initially loading) */}
        {isCategoriesLoading ? (
          <div style={styles.filterContainer}>
            {[1, 2, 3, 4].map((n) => (
              <div
                key={n}
                className="shimmer-card-line"
                style={{ width: "100px", height: "45px", borderRadius: "25px" }}
              />
            ))}
          </div>
        ) : (
          <div style={styles.filterContainer}>
            <button
              onClick={() => handleFilterChange("all")}
              style={{
                padding: "10px 30px",
                borderRadius: "30px",
                border: "none",
                backgroundColor: filter === "all" ? "#0056b3" : "#fff",
                color: filter === "all" ? "#fff" : "#555",
                fontWeight: "bold",
                cursor: "pointer",
                boxShadow:
                  filter === "all"
                    ? "0 4px 15px rgba(0, 86, 179, 0.3)"
                    : "0 2px 10px rgba(0,0,0,0.05)",
                transition: "all 0.3s ease",
              }}
            >
              {isRTL ? "الكل" : "All"}
            </button>

            {categories.map((cat) => {
              const isActive = Number(filter) === Number(cat.id);
              return (
                <button
                  key={cat.id}
                  onClick={() => handleFilterChange(cat.id)}
                  style={{
                    padding: "10px 30px",
                    borderRadius: "30px",
                    border: "none",
                    backgroundColor: isActive ? "#0056b3" : "#fff",
                    color: isActive ? "#fff" : "#555",
                    fontWeight: "bold",
                    cursor: "pointer",
                    boxShadow: isActive
                      ? "0 4px 15px rgba(0, 86, 179, 0.3)"
                      : "0 2px 10px rgba(0,0,0,0.05)",
                    transition: "all 0.3s ease",
                  }}
                >
                  {cat.name}
                </button>
              );
            })}
          </div>
        )}

        {/* GRID AREA */}
        {isActivitiesLoading ? (
          /* SKELETON LOADERS FOR GRID ONLY */
          <div style={styles.grid}>
            {[1, 2, 3, 4, 5, 6,7,8,9,10].map((n) => (
              <div
                key={n}
                style={{
                  backgroundColor: "#fff",
                  borderRadius: "20px",
                  height: "380px",
                  border: "1px solid #eee",
                  overflow: "hidden",
                }}
              >
                <div
                  className="shimmer-card-line"
                  style={{ height: "220px", width: "100%" }}
                />
                <div style={{ padding: "20px" }}>
                  <div
                    className="shimmer-card-line"
                    style={{
                      height: "20px",
                      width: "70%",
                      marginBottom: "15px",
                      borderRadius: "4px",
                    }}
                  />
                  <div
                    className="shimmer-card-line"
                    style={{
                      height: "14px",
                      width: "100%",
                      marginBottom: "10px",
                      borderRadius: "4px",
                    }}
                  />
                  <div
                    className="shimmer-card-line"
                    style={{
                      height: "14px",
                      width: "80%",
                      borderRadius: "4px",
                    }}
                  />
                </div>
              </div>
            ))}
          </div>
        ) : activities.length === 0 ? (
          /* EMPTY STATE */
          <div
            style={{ textAlign: "center", padding: "80px 20px", color: "#888" }}
          >
            <h3 style={{ fontSize: "1.4rem" }}>
              {isRTL
                ? "لا توجد أنشطة حالياً في هذا القسم"
                : "No activities available in this category"}
            </h3>
          </div>
        ) : (
          /* ACTUAL ACTIVITIES GRID */
          <>
            <div style={styles.grid}>
              {activities.map((act) => (
                <div
                  key={act.id}
                  onClick={() => setSelectedActivity(act)}
                  style={{
                    backgroundColor: "#fff",
                    border: "1px solid #f0f0f0",
                    borderRadius: "20px",
                    overflow: "hidden",
                    cursor: "pointer",
                    boxShadow: "0 4px 20px rgba(0,0,0,0.04)",
                    transition:
                      "all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)",
                    display: "flex",
                    flexDirection: "column",
                  }}
                  onMouseEnter={(e) => {
                    e.currentTarget.style.transform = "translateY(-8px)";
                    e.currentTarget.style.boxShadow =
                      "0 15px 35px rgba(0,0,0,0.1)";
                  }}
                  onMouseLeave={(e) => {
                    e.currentTarget.style.transform = "translateY(0)";
                    e.currentTarget.style.boxShadow =
                      "0 4px 20px rgba(0,0,0,0.04)";
                  }}
                >
                  <div style={{ position: "relative" }}>
                    {act.is_featured === 1 && (
                      <div
                        style={{
                          position: "absolute",
                          top: "15px",
                          [isRTL ? "right" : "left"]: "15px",
                          background:
                            "linear-gradient(135deg, #ff9800, #f57c00)",
                          color: "#fff",
                          padding: "6px 12px",
                          borderRadius: "20px",
                          fontSize: "0.85rem",
                          fontWeight: "bold",
                          display: "flex",
                          alignItems: "center",
                          gap: "4px",
                          boxShadow: "0 4px 10px rgba(255, 152, 0, 0.3)",
                          zIndex: 2,
                        }}
                      >
                        <Star size={12} fill="#fff" />{" "}
                        {isRTL ? "مميز" : "Featured"}
                      </div>
                    )}
                    <ImageWithLoader src={act.image_url} alt={act.title} />
                  </div>

                  <div
                    style={{
                      padding: "20px",
                      flex: 1,
                      display: "flex",
                      flexDirection: "column",
                    }}
                  >
                    <div
                      style={{
                        color: "#0056b3",
                        fontSize: "0.85rem",
                        fontWeight: "bold",
                        marginBottom: "8px",
                        textTransform: "uppercase",
                        letterSpacing: "0.5px",
                      }}
                    >
                      {getCategoryName(act.activity_category_id)}
                    </div>
                    <h3
                      style={{
                        fontSize: "1.25rem",
                        color: "#222",
                        marginBottom: "10px",
                        lineHeight: "1.4",
                        fontWeight: "bold",
                      }}
                    >
                      {act.title}
                    </h3>
                    <p
                      style={{
                        color: "#666",
                        fontSize: "0.95rem",
                        lineHeight: "1.6",
                        marginBottom: "0",
                        flex: 1,
                      }}
                    >
                      {act.summary}
                    </p>
                  </div>
                </div>
              ))}
            </div>

            {/* PAGINATION CONTROLS */}
            {totalPages > 1 && (
              <div style={styles.paginationContainer}>
                {/* Previous Button */}
                <button
                  onClick={() => handlePageChange(page - 1)}
                  disabled={page === 1}
                  style={{
                    ...styles.paginationBtn,
                    backgroundColor: page === 1 ? "#f0f0f0" : "#fff",
                    color: page === 1 ? "#aaa" : "#0056b3",
                    boxShadow:
                      page === 1 ? "none" : "0 2px 10px rgba(0,0,0,0.05)",
                    cursor: page === 1 ? "not-allowed" : "pointer",
                  }}
                >
                  {isRTL ? <ArrowRight size={20} /> : <ArrowLeft size={20} />}
                </button>

                {/* Page Numbers */}
                {Array.from({ length: totalPages }, (_, i) => i + 1).map(
                  (num) => (
                    <button
                      key={num}
                      onClick={() => handlePageChange(num)}
                      style={{
                        ...styles.paginationBtn,
                        backgroundColor: page === num ? "#0056b3" : "#fff",
                        color: page === num ? "#fff" : "#555",
                        boxShadow:
                          page === num
                            ? "0 4px 15px rgba(0, 86, 179, 0.3)"
                            : "0 2px 10px rgba(0,0,0,0.05)",
                      }}
                    >
                      {num}
                    </button>
                  ),
                )}

                {/* Next Button */}
                <button
                  onClick={() => handlePageChange(page + 1)}
                  disabled={page === totalPages}
                  style={{
                    ...styles.paginationBtn,
                    backgroundColor: page === totalPages ? "#f0f0f0" : "#fff",
                    color: page === totalPages ? "#aaa" : "#0056b3",
                    boxShadow:
                      page === totalPages
                        ? "none"
                        : "0 2px 10px rgba(0,0,0,0.05)",
                    cursor: page === totalPages ? "not-allowed" : "pointer",
                  }}
                >
                  {isRTL ? <ArrowLeft size={20} /> : <ArrowRight size={20} />}
                </button>
              </div>
            )}
          </>
        )}
      </div>
    </div>
  );
};

export default ActivitiesSection;
