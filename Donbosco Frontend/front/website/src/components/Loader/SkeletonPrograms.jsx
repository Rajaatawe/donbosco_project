import React from "react";
import "./SkeletonPrograms.css"; // Import the CSS for shimmer effect
const SkeletonPrograms = ({ count = 3,lang }) => {
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
      <div
        style={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fill, minmax(320px, 1fr))",
          gap: "30px",
        }}
      >
        {[...Array(count)].map((_, index) => (
          <div
            key={index}
            style={{
              backgroundColor: "#fff",
              borderRadius: "20px",
              overflow: "hidden",
              boxShadow: "0 5px 15px rgba(0,0,0,0.08)",
              border: "1px solid #f0f0f0",
              height: "450px",
            }}
          >
            {/* Simulated Cover Image Box */}
            <div
              className="shimmer-card-line"
              style={{
                width: "100%",
                height: "200px",
              }}
            />

            <div style={{ padding: "20px" }}>
              {/* Simulated Card Title */}
              <div
                className="shimmer-card-line"
                style={{
                  height: "22px",
                  width: "60%",
                  marginBottom: "20px",
                  borderRadius: "6px",
                }}
              />

              {/* Simulated Description Block Lines */}
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
                  width: "85%",
                  marginBottom: "30px",
                  borderRadius: "4px",
                }}
              />

              {/* Simulated Date Badge Row */}
              <div
                className="shimmer-card-line"
                style={{
                  height: "14px",
                  width: "45%",
                  marginBottom: "25px",
                  borderRadius: "4px",
                }}
              />

              {/* Simulated Register Action Button */}
              <div
                className="shimmer-card-line"
                style={{
                  width: "100%",
                  height: "45px",
                  borderRadius: "12px",
                }}
              />
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default SkeletonPrograms;
