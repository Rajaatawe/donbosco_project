import { useState, useEffect } from "react";
import "./ImageWithLoader.css";
import PLACEHOLDER_IMAGE from "../../assets/images/image-placeholder.png";
export default function ImageWithLoader({ src, alt}) {
  // Use status instead of a simple boolean to track fallback logic
  const [status, setStatus] = useState("loading"); // "loading" | "success" | "error"

  // Change this string if your fallback image has a different name or path

  useEffect(() => {
    // If there is no image at all (null, undefined, or empty string), jump straight to error
    if (!src) {
      setStatus("error");
    } else {
      setStatus("loading");
    }
  }, [src]);

  return (
    <div
      style={{
        position: "relative",
        width: "100%",
        height: "220px",
        backgroundColor: "#f5f5f5",
        display: "flex" /* Centers the spinner perfectly */,
        alignItems: "center",
        justifyContent: "center",
        overflow: "hidden",
      }}
    >
      {/* 1. PERFECT CIRCLE SPINNER (Only shows when explicitly loading) */}
      {status === "loading" && <div className="perfect-spinner" />}

      {/* 2. ACTUAL IMAGE (Renders unless there is an absolute error) */}
      {status !== "error" && (
        <img
          src={src}
          alt={alt}
          onLoad={() => setStatus("success")}
          onError={() => setStatus("error")} // Triggers if URL is a broken link
          style={{
            width: "100%",
            height: "100%",
            objectFit: "cover",
            opacity: status === "success" ? 1 : 0,
            transition: "opacity 0.4s ease-in-out",
            position: "absolute", // Sits perfectly over the background
            top: 0,
            left: 0,
          }}
        />
      )}

      {/* 3. PLACEHOLDER IMAGE (Shows instantly if no src exists or if image fails to load) */}
      {status === "error" && (
        <img
          src={PLACEHOLDER_IMAGE}
          alt="Placeholder"
          style={{
            width: "100%",
            height: "100%",
            objectFit: "cover",
            position: "absolute",
            top: 0,
            left: 0,
          }}
        />
      )}
    </div>
  );
}
