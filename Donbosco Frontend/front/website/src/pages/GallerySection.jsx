import { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { Folder, Calendar } from "lucide-react";

const GallerySection = () => {
  const [albums, setAlbums] = useState([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchAlbums = async () => {
      try {
        const res = await axios.get("http://127.0.0.1:8000/api/gallery-albums");
        setAlbums(res.data);
      } catch (err) {
        console.log("Error fetching albums:", err);
      } finally {
        setLoading(false);
      }
    };
    fetchAlbums();
  }, []);

  if (loading)
    return (
      <div style={{ textAlign: "center", padding: "50px" }}>
        جاري تحميل الألبومات...
      </div>
    );

  return (
    <div
      style={{
        padding: "60px 20px",
        maxWidth: "1200px",
        margin: "0 auto",
        direction: "rtl",
      }}
    >
      <h1
        style={{
          textAlign: "center",
          fontSize: "2.5rem",
          color: "#0056b3",
          marginBottom: "40px",
        }}
      >
        معرض الصور
      </h1>

      <div
        style={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fill, minmax(320px, 1fr))",
          gap: "30px",
        }}
      >
        {albums.map((album) => (
          <div
            key={album.id}
            onClick={() => navigate(`/gallery/${album.id}`)}
            style={{
              background: "#fff",
              borderRadius: "20px",
              overflow: "hidden",
              boxShadow: "0 10px 20px rgba(0,0,0,0.05)",
              cursor: "pointer",
              transition: "0.3s",
            }}
          >
            <img
              src={album.cover_image_url}
              alt={album.title}
              style={{ width: "100%", height: "220px", objectFit: "cover" }}
            />
            <div style={{ padding: "20px" }}>
              <div
                style={{
                  color: "#0056b3",
                  fontSize: "0.8rem",
                  marginBottom: "10px",
                }}
              >
                <Calendar
                  size={14}
                  style={{ display: "inline", marginLeft: "5px" }}
                />
                {new Date(album.created_at).toLocaleDateString()}
              </div>
              <h3 style={{ margin: "0 0 10px 0" }}>{album.title}</h3>
              <p style={{ color: "#666", fontSize: "0.9rem" }}>
                {album.description}
              </p>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default GallerySection ;
