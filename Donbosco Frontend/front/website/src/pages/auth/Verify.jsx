import { useState } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import { X } from "lucide-react";
import api from "../../api/axios";

const Verify = () => {
  const navigate = useNavigate();
  const location = useLocation();

  const email = location.state?.email || "";

  const [code, setCode] = useState("");
  const [loading, setLoading] = useState(false);

  const handleVerify = async (e) => {
    e.preventDefault();
    setLoading(true);

    try {
      const response = await api.post("/verifyCode", {
        email,
        code,
      });

      const token = response.data.access_token;

      // حفظ التوكن
      localStorage.setItem("access_token", token);

      setLoading(false);

      // تحويل للرئيسية
      navigate("/");

    } catch (error) {
      setLoading(false);
      console.log(error);

      alert(
        error.response?.data?.message || "الكود غير صحيح"
      );
    }
  };

  const styles = {
    container: {
      backgroundColor: "#ebf0f3",
      minHeight: "100vh",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      direction: "rtl",
      padding: "20px",
    },
    card: {
      backgroundColor: "#ebf0f3",
      padding: "50px 40px 40px",
      borderRadius: "40px",
      boxShadow: "10px 10px 20px #d1d9e6, -10px -10px 20px #ffffff",
      width: "100%",
      maxWidth: "400px",
      textAlign: "center",
      position: "relative",
    },
    backButton: {
      position: "absolute",
      top: "20px",
      right: "20px",
      width: "40px",
      height: "40px",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      borderRadius: "50%",
      backgroundColor: "#ebf0f3",
      boxShadow: "4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff",
      color: "#1b2d5a",
      textDecoration: "none",
    },
    input: {
      width: "100%",
      padding: "15px",
      borderRadius: "30px",
      border: "none",
      marginTop: "10px",
      boxShadow: "inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff",
      outline: "none",
      textAlign: "center",
      fontSize: "1.2rem",
      letterSpacing: "5px",
    },
    button: {
      width: "100%",
      padding: "15px",
      backgroundColor: "#1b2d5a",
      color: "#fff",
      border: "none",
      borderRadius: "30px",
      marginTop: "20px",
      cursor: "pointer",
      fontWeight: "bold",
    },
  };

  return (
    <div style={styles.container}>
      <div style={styles.card}>
        <button
          onClick={() => navigate("/")}
          style={styles.backButton}
        >
          <X size={20} />
        </button>

        <h2 style={{ color: "#1b2d5a", marginBottom: "20px" }}>
          تأكيد الحساب
        </h2>

        <p style={{ fontSize: "0.9rem", color: "#666" }}>
          أدخل الكود المرسل إلى:
          <br />
          <b>{email}</b>
        </p>

        <form onSubmit={handleVerify}>
          <input
            type="text"
            placeholder="******"
            value={code}
            onChange={(e) => setCode(e.target.value)}
            style={styles.input}
            required
          />

          <button type="submit" style={styles.button}>
            {loading ? "جاري التحقق..." : "تأكيد"}
          </button>
        </form>
      </div>
    </div>
  );
};

export default Verify;