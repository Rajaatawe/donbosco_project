import { useState } from "react";
import { useNavigate, useLocation, Link } from "react-router-dom";
import { X } from "lucide-react";
import api from "../../api/axios";


const ResetPassword = () => {
  const navigate = useNavigate();
  const location = useLocation();

  const email =
    location.state?.email || localStorage.getItem("reset_email") || "";

  const resetToken =
    location.state?.resetToken || localStorage.getItem("reset_token") || "";

  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState("");
  const [successMsg, setSuccessMsg] = useState("");

  const handleReset = async (e) => {
    e.preventDefault();

    setErrorMsg("");
    setSuccessMsg("");

    if (!email || !resetToken) {
      setErrorMsg("انتهت الجلسة، أعد المحاولة");
      setTimeout(() => navigate("/forgot-password"), 1200);
      return;
    }

    if (password !== confirmPassword) {
      setErrorMsg("كلمتا المرور غير متطابقتين");
      return;
    }

    setLoading(true);

    try {
     await api.post("/resetPassword", {
  email,
  new_password: password,
  new_password_confirmation: confirmPassword, 
  reset_token: resetToken,
});
      

      // تنظيف
      localStorage.removeItem("reset_email");
      localStorage.removeItem("reset_token");

      setLoading(false);
      setSuccessMsg("تم تغيير كلمة المرور بنجاح ✅");

      setTimeout(() => {
        navigate("/login", {
  state: {
    email,
    password, 
  },
});
      }, 1200);

    } catch (error) {
      setLoading(false);
      setErrorMsg(
        error.response?.data?.message || "فشل تغيير كلمة المرور"
      );
    }
  };
  console.log("EMAIL:", email);
console.log("TOKEN:", resetToken);
console.log("PASSWORD:", password);

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
      marginTop: "10px",
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
        <Link to="/" style={styles.backButton}>
          <X size={20} />
        </Link>

        <h2 style={{ color: "#1b2d5a" }}>تغيير كلمة المرور</h2>

        <p style={{ color: "#666" }}>
          للحساب:
          <br />
          <b>{email || "—"}</b>
        </p>

        <form onSubmit={handleReset}>
          <input
            type="password"
            placeholder="كلمة المرور الجديدة"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            style={styles.input}
            required
          />

          <input
            type="password"
            placeholder="تأكيد كلمة المرور"
            value={confirmPassword}
            onChange={(e) => setConfirmPassword(e.target.value)}
            style={styles.input}
            required
          />

          <button type="submit" style={styles.button}>
            {loading ? "جاري الحفظ..." : "تأكيد"}
          </button>
        </form>

        {errorMsg && <div style={styles.error}>{errorMsg}</div>}
        {successMsg && <div style={styles.success}>{successMsg}</div>}
      </div>
    </div>
  );
};

export default ResetPassword;