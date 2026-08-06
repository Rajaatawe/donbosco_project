import React from "react";
import "./SkeletonAbout.css"; // Imported the animation stylesheet here

const SkeletonAbout = ({ styles, count = 2,lang }) => {
  return (
    <div style={styles.sectionWrapper}>
      <div style={styles.container}>
        <div style={styles.headerArea}>
          <h1 style={styles.mainTitle}>
            {lang === "ar" ? "من نحن" : "About Us"}
          </h1>

          <div style={styles.divider}></div>
        </div>
        <div>
          {[...Array(count)].map((_, index) => (
            <div key={index} style={styles.contentBlock}>
              {/* Simulated Section Title Line */}
              <div
                className="skeleton-about"
                style={{
                  height: "26px",
                  width: "30%",
                  marginBottom: "20px",
                  borderRadius: "6px",
                }}
              />
              {/* Simulated Content Body Lines */}
              <div
                className="skeleton-about"
                style={{
                  height: "16px",
                  width: "100%",
                  marginBottom: "12px",
                  borderRadius: "4px",
                }}
              />
              <div
                className="skeleton-about"
                style={{
                  height: "16px",
                  width: "95%",
                  marginBottom: "12px",
                  borderRadius: "4px",
                }}
              />
              <div
                className="skeleton-about"
                style={{
                  height: "16px",
                  width: "92%",
                  marginBottom: "12px",
                  borderRadius: "4px",
                }}
              />
              <div
                className="skeleton-about"
                style={{ height: "16px", width: "50%", borderRadius: "4px" }}
              />
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default SkeletonAbout;
