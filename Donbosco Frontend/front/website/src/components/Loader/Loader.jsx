import "./Loader.css";
const Loader = ({ rows = 2}) => {
    const lang = localStorage.getItem("lang") || "ar";
      return (
    <div
      style={{
        display: "grid",
        gridTemplateColumns: "repeat(auto-fill, minmax(320px, 1fr))",
        gap: "30px",
        maxWidth: "1000px",
        margin: "40px auto",
      }}
    >
      {[...Array(rows)].map((_, n) => (
        <div
          key={n}
          style={{
            height: "400px",
            backgroundColor: "#fff",
            borderRadius: "25px",
            border: "1px solid #f0f0f0",
            direction: lang==="ar"?"rtl":"ltr",
          }}
        >
          <div
            className="skeleton-box"
            style={{ height: "220px", borderRadius: "25px 25px 0 0" }}
          />
          <div style={{ padding: "22px" }}>
            <div
              className="skeleton-box"
              style={{ height: "20px", width: "70%", marginBottom: "15px" }}
            />
            <div
              className="skeleton-box"
              style={{ height: "15px", width: "100%", marginBottom: "10px" }}
            />
            <div
              className="skeleton-box"
              style={{ height: "15px", width: "40%" }}
            />
          </div>
        </div>
      ))}
    </div>
  );
};
export default Loader;
