import { useState } from "react";
import { useNavigate, useLocation, Link } from "react-router-dom";
import { X } from "lucide-react";
import api from "../../api/axios";

const VerifyResetCode = () => {
  const navigate = useNavigate();
  const location = useLocation();

  const email =
    location.state?.email || localStorage.getItem("reset_email") || "";

  const [code, setCode] = useState("");
  const [loading, setLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState("");

  const handleVerify = async (e) => {
    e.preventDefault();

    setErrorMsg("");

    if (!email) {
      setErrorMsg("الإيميل مفقود، أعد المحاولة");
      setTimeout(() => navigate("/forgot-password"), 1500);
      return;
    }

    setLoading(true);

    try {
      const response = await api.post("/verifyForNewPassword", {
        email,
        code,
      });

      const resetToken = response.data.reset_token;

      localStorage.setItem("reset_email", email);
      localStorage.setItem("reset_token", resetToken);

      navigate("/reset-password");

    } catch (error) {
      setErrorMsg(
        error.response?.data?.message || "الكود غير صحيح"
      );
    } finally {
      setLoading(false);
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
    error: {
      background: "#ffe5e5",
      color: "#d8000c",
      padding: "10px",
      borderRadius: "10px",
      marginTop: "15px",
    },
  };

  return (
    <div style={styles.container}>
      <div style={styles.card}>
        <Link to="/login" style={styles.backButton}>
          <X size={20} />
        </Link>

        <h2 style={{ color: "#1b2d5a", marginBottom: "20px" }}>
          تأكيد الكود
        </h2>

        <p style={{ fontSize: "0.9rem", color: "#666" }}>
          أدخل الكود المرسل إلى:
          <br />
          <b>{email || "—"}</b>
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

        {errorMsg && <div style={styles.error}>{errorMsg}</div>}
      </div>
    </div>
  );
};

export default VerifyResetCode;