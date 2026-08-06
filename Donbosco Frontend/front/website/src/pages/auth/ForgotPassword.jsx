import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { X } from "lucide-react";
import api from "../../api/axios";
import { useLocation } from "react-router-dom";



const ForgotPassword = () => {
  const navigate = useNavigate();
const location = useLocation();
const [email, setEmail] = useState(location.state?.email || "");
  const [loading, setLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState("");
  const [successMsg, setSuccessMsg] = useState("");

 const handleForgotPassword = async (e) => {
  e.preventDefault();

  if (!email) {
    setErrorMsg("الرجاء إدخال البريد الإلكتروني");
    return;
  }

  setLoading(true);
  setErrorMsg("");
  setSuccessMsg("");

  try {
    await api.post("/sendEmail", { email });

    // ✅ مهم جداً
    localStorage.setItem("reset_email", email);

    setLoading(false);
    setSuccessMsg("تم إرسال الكود إلى بريدك");

    setTimeout(() => {
      navigate("/verify-reset", { state: { email } });
    }, 1200);

  } catch (error) {
    setLoading(false);
    setErrorMsg(
      error.response?.data?.message || "فشل إرسال الكود"
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
      padding: "50px 40px",
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
      marginTop: "15px",
      boxShadow: "inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff",
      outline: "none",
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
      marginTop: "10px",
    },
    success: {
      background: "#e6ffed",
      color: "green",
      padding: "10px",
      borderRadius: "10px",
      marginTop: "10px",
    },
  };

  return (
    <div style={styles.container}>
      <div style={styles.card}>
        <Link to="/login" style={styles.backButton}>
          <X size={20} />
        </Link>

        <h2 style={{ color: "#1b2d5a" }}>نسيت كلمة المرور</h2>

        <form onSubmit={handleForgotPassword}>
          <input
            type="email"
            placeholder="البريد الإلكتروني"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            style={styles.input}
            required
          />

          <button type="submit" style={styles.button}>
            {loading ? "جاري الإرسال..." : "إرسال الكود"}
          </button>
        </form>

        {errorMsg && <div style={styles.error}>{errorMsg}</div>}
        {successMsg && <div style={styles.success}>{successMsg}</div>}
      </div>
    </div>
  );
};

export default ForgotPassword;