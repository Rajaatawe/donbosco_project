import "./NewsSkeleton.css";

export const NewsSkeleton = ({ count = 10, lang }) => {
  // This internal component represents a single card
  const SkeletonCard = () => (
    <div
      style={{
        backgroundColor: "#fff",
        borderRadius: "20px",
        overflow: "hidden",
        boxShadow: "0 5px 15px rgba(0,0,0,0.05)",
        border: "1px solid #f0f0f0",
      }}
    >
      <div
        className="shimmer-skeleton"
        style={{ width: "100%", height: "200px" }}
      />
      <div style={{ padding: "22px" }}>
        <div
          className="shimmer-skeleton"
          style={{
            height: "25px",
            width: "70%",
            marginBottom: "15px",
            borderRadius: "4px",
          }}
        />
        <div
          className="shimmer-skeleton"
          style={{
            height: "15px",
            width: "100%",
            marginBottom: "8px",
            borderRadius: "4px",
          }}
        />
        <div
          className="shimmer-skeleton"
          style={{
            height: "15px",
            width: "90%",
            marginBottom: "25px",
            borderRadius: "4px",
          }}
        />
        <div
          className="shimmer-skeleton"
          style={{ height: "15px", width: "40%", borderRadius: "4px" }}
        />
      </div>
    </div>
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
      <div
        style={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fill,minmax(320px,1fr))",
          gap: "30px",
        }}
      >
        {/* Create an array of length 'count' and fill it */}
        {Array.from({ length: count }).map((_, index) => (
          <SkeletonCard key={index} />
        ))}
      </div>
    </div>
  );
};
