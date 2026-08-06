import { useState, useEffect } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import { ChevronRight, X } from "lucide-react";

const GalleryImagesSection = () => {
  const { albumId } = useParams();
  const navigate = useNavigate();
  const [images, setImages] = useState([]);
  const [loading, setLoading] = useState(true);
  const [activePhoto, setActivePhoto] = useState(null);

  useEffect(() => {
    const fetchImages = async () => {
      try {
        setLoading(true);
        const res = await axios.get(
          `http://127.0.0.1:8000/api/gallery-albums/${albumId}/images`,
        );

        // Handles responses like { data: [...] } or direct arrays [...]
        const data = res.data.data || res.data;

        if (Array.isArray(data)) {
          setImages(data);
        } else {
          setImages([]);
        }
      } catch (err) {
        console.log("Error fetching images:", err);
        setImages([]);
      } finally {
        setLoading(false);
      }
    };

    if (albumId) {
      fetchImages();
    }
  }, [albumId]);

  if (loading)
    return (
      <div
        style={{
          textAlign: "center",
          padding: "50px",
          fontSize: "1.2rem",
          color: "#666",
        }}
      >
        جاري تحميل الصور...
      </div>
    );

  return (
    <div
      style={{
        padding: "40px",
        maxWidth: "1200px",
        margin: "0 auto",
        direction: "rtl",
      }}
    >
      <button
        onClick={() => navigate(-1)}
        style={{
          marginBottom: "30px",
          padding: "10px 20px",
          borderRadius: "20px",
          border: "none",
          backgroundColor: "#f0f0f0",
          cursor: "pointer",
          display: "flex",
          alignItems: "center",
          gap: "5px",
          fontSize: "1rem",
        }}
      >
        <ChevronRight /> رجوع للألبومات
      </button>

      {images.length === 0 ? (
        <div style={{ textAlign: "center", color: "#999" }}>
          لا توجد صور في هذا الألبوم
        </div>
      ) : (
        <div
          style={{
            display: "grid",
            gridTemplateColumns: "repeat(auto-fill, minmax(220px, 1fr))",
            gap: "20px",
          }}
        >
          {images.map((photo) => (
            <div
              key={photo.id}
              onClick={() => setActivePhoto(photo)}
              style={{
                borderRadius: "15px",
                overflow: "hidden",
                cursor: "pointer",
                boxShadow: "0 4px 6px rgba(0,0,0,0.1)",
              }}
            >
              <img
                src={photo.image_url}
                alt={photo.caption}
                style={{
                  width: "100%",
                  height: "220px",
                  objectFit: "cover",
                  transition: "0.3s",
                }}
              />
            </div>
          ))}
        </div>
      )}

      {/* Lightbox with Caption */}
      {activePhoto && (
        <div
          onClick={() => setActivePhoto(null)}
          style={{
            position: "fixed",
            inset: 0,
            background: "rgba(0,0,0,0.95)",
            display: "flex",
            flexDirection: "column",
            justifyContent: "center",
            alignItems: "center",
            zIndex: 1000,
            padding: "20px",
          }}
        >
          <X
            size={40}
            style={{
              position: "absolute",
              top: 20,
              right: 20,
              color: "#fff",
              cursor: "pointer",
            }}
          />

          <img
            src={activePhoto.image_url}
            style={{
              maxWidth: "90%",
              maxHeight: "80vh",
              borderRadius: "10px",
              boxShadow: "0 0 20px rgba(0,0,0,0.5)",
            }}
          />

          {activePhoto.caption && (
            <p
              style={{
                color: "#fff",
                marginTop: "20px",
                fontSize: "1.2rem",
                textAlign: "center",
                maxWidth: "800px",
                lineHeight: "1.6",
              }}
            >
              {activePhoto.caption}
            </p>
          )}
        </div>
      )}
    </div>
  );
};

export default GalleryImagesSection;
