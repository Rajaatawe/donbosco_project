import { useState, useEffect } from "react";
import { useNavigate, Link, useLocation } from "react-router-dom";
import { X } from "lucide-react";
import api from "../../api/axios";

const Login = () => {
  const navigate = useNavigate();
  const location = useLocation();

  const [email, setEmail] = useState(location.state?.email || "");
  const [password, setPassword] = useState(location.state?.password || "");

  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState("");
  const [type, setType] = useState("");

  const handleLogin = async (e) => {
    e.preventDefault();
    setLoading(true);
    setMessage("");

   try {
  const response = await api.post("/login", { email, password });

  if (!response?.data?.access_token) {
    throw new Error("فشل تسجيل الدخول");
  }

  localStorage.setItem("access_token", response.data.access_token);
  localStorage.setItem("refresh_token", response.data.refresh_token);

  setType("success");
  setMessage("تم تسجيل الدخول بنجاح ✅");

  setTimeout(() => navigate("/"), 1000);

} catch (error) {
  const msg = error.response?.data?.message;

  setType("error");
  setMessage(msg || "بيانات الدخول غير صحيحة");
}
  };

  // 🔥 إخفاء الرسالة
  useEffect(() => {
    if (message) {
      const timer = setTimeout(() => {
        setMessage("");
      }, 5000);

      return () => clearTimeout(timer);
    }
  }, [message]);

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
    inputField: {
      width: "100%",
      padding: "15px 20px",
      backgroundColor: "#ebf0f3",
      border: "none",
      borderRadius: "30px",
      boxShadow: "inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff",
      outline: "none",
      marginTop: "8px",
      color: "#1b2d5a",
    },
    submitButton: {
      width: "100%",
      padding: "15px",
      backgroundColor: "#1b2d5a",
      color: "#fff",
      border: "none",
      borderRadius: "30px",
      fontWeight: "bold",
      marginTop: "20px",
      cursor: "pointer",
    },
  };

  return (
    <div style={styles.container}>
      <div style={styles.card}>

        <Link to="/">
          <X size={20} />
        </Link>

        <h2 style={{ color: "#1b2d5a", marginBottom: "25px" }}>
          Login
        </h2>

        {/* ✅ الرسالة */}
        {message && (
          <div
            style={{
              padding: "12px",
              borderRadius: "15px",
              marginBottom: "15px",
              fontSize: "0.9rem",
              fontWeight: "bold",
              textAlign: "center",
              background:
                type === "success"
                  ? "#e6f7ee"
                  : type === "warning"
                  ? "#fff4e5"
                  : "#ffe5e5",
              color:
                type === "success"
                  ? "#1e7e34"
                  : type === "warning"
                  ? "#b26a00"
                  : "#d8000c",
            }}
          >
            {message}
          </div>
        )}

        {/* 🔥 الفورم بدون autofill */}
        <form onSubmit={handleLogin} autoComplete="off">

          {/* input وهمي لمنع autofill */}
        
          <input type="password" autoComplete="new-password" style={{ display: "none" }} />
<input
  type="email"
  name="email"
  autoComplete="off"
  placeholder="البريد الإلكتروني"
  style={styles.inputField}
  value={email}
  onChange={(e) => setEmail(e.target.value)}
  required
/>

<input
  type="password"
  name="password"
  autoComplete="new-password"
  placeholder="كلمة المرور"
  style={styles.inputField}
  value={password}
  onChange={(e) => setPassword(e.target.value)}
  required
/>  
          <button type="submit" style={styles.submitButton}>
            {loading ? "جاري التحقق..." : "دخول"}
          </button>
        </form>

        <div style={{ marginTop: "20px" }}>
          <span
            style={{ color: "#1b2d5a", cursor: "pointer", fontWeight: "bold" }}
            onClick={() => navigate("/forgot-password", { state: { email } })}
          >
            نسيت كلمة المرور؟
          </span>
        </div>

        <div style={{ marginTop: "20px" }}>
          <span
            style={{ color: "#1b2d5a", cursor: "pointer", fontWeight: "bold" }}
            onClick={() => navigate("/register")}
          >
            إنشاء حساب؟
          </span>
        </div>

      </div>
    </div>
  );
};

export default Login;