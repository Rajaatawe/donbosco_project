import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { X } from "lucide-react"; // استيراد أيقونة الإغلاق
import api from "../../api/axios";

const Register = () => {
  const navigate = useNavigate();
  const [userData, setUserData] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "", // الحقل المطلوب لتجاوز التحقق في Laravel
  });
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    setUserData({ ...userData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
  e.preventDefault();
  setLoading(true);

  try {
    // تسجيل + إرسال الكود (Laravel يعمل الاثنين)
    await api.post("/register", userData);

    setLoading(false);

    // الانتقال لصفحة التحقق مع الإيميل
    navigate("/verify", { state: { email: userData.email } });

  } catch (error) {
    setLoading(false);

    console.log(error);

    alert(
      error.response?.data?.message || "فشل في التسجيل"
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
      padding: "20px",
      direction: "rtl",
    },
    card: {
      backgroundColor: "#ebf0f3",
      padding: "50px 40px 40px",
      borderRadius: "40px",
      boxShadow: "10px 10px 20px #d1d9e6, -10px -10px 20px #ffffff",
      width: "100%",
      maxWidth: "450px",
      textAlign: "center",
      position: "relative", // ضروري لتموضع زر الرجوع
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
      transition: "0.2s",
    },
    input: {
      width: "100%",
      padding: "12px 20px",
      backgroundColor: "#ebf0f3",
      border: "none",
      borderRadius: "30px",
      boxShadow: "inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff",
      outline: "none",
      marginTop: "8px",
      color: "#1b2d5a",
    },
    button: {
      width: "100%",
      padding: "15px",
      backgroundColor: "#1b2d5a",
      color: "#ffffff",
      border: "none",
      borderRadius: "30px",
      fontWeight: "bold",
      marginTop: "15px",
      cursor: "pointer",
      boxShadow: "4px 4px 10px #d1d9e6",
      transition: "0.3s",
    },
    label: {
      marginRight: "15px",
      fontWeight: "bold",
      fontSize: "0.85rem",
      color: "#444",
    },
  };

  return (
    <div style={styles.container}>
      <div style={styles.card}>
        {/* زر الرجوع للرئيسية */}
        <Link
          to="/"
          style={styles.backButton}
          onMouseEnter={(e) =>
            (e.currentTarget.style.boxShadow =
              "inset 2px 2px 5px #d1d9e6, inset -2px -2px 5px #ffffff")
          }
          onMouseLeave={(e) =>
            (e.currentTarget.style.boxShadow =
              "4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff")
          }
        >
          <X size={20} />
        </Link>

        <h2
          style={{
            color: "#1b2d5a",
            marginBottom: "25px",
            fontSize: "2rem",
            fontWeight: "900",
          }}
        >
          SignUp
        </h2>

        <form onSubmit={handleSubmit}>
          <div style={{ marginBottom: "15px", textAlign: "right" }}>
            <label style={styles.label}>الاسم الكامل</label>
            <input
              type="text"
              name="name"
              placeholder="أدخل اسمك الكامل"
              style={styles.input}
              value={userData.name}
              onChange={handleChange}
              required
            />
          </div>

          <div style={{ marginBottom: "15px", textAlign: "right" }}>
            <label style={styles.label}>البريد الإلكتروني</label>
            <input
              type="email"
              name="email"
              placeholder="example@mail.com"
              style={styles.input}
              value={userData.email}
              onChange={handleChange}
              required
            />
          </div>

          <div style={{ marginBottom: "15px", textAlign: "right" }}>
            <label style={styles.label}>كلمة المرور</label>
            <input
              type="password"
              name="password"
              placeholder="••••••••"
              style={styles.input}
              value={userData.password}
              onChange={handleChange}
              required
            />
          </div>

          <div style={{ marginBottom: "15px", textAlign: "right" }}>
            <label style={styles.label}>تأكيد كلمة المرور</label>
            <input
              type="password"
              name="password_confirmation"
              placeholder="••••••••"
              style={styles.input}
              value={userData.password_confirmation}
              onChange={handleChange}
              required
            />
          </div>

          <button
            type="submit"
            style={styles.button}
            onMouseEnter={(e) => (e.target.style.opacity = "0.9")}
            onMouseLeave={(e) => (e.target.style.opacity = "1")}
          >
            {loading ? "جاري الإنشاء..." : "Register"}
          </button>

          <div
            style={{ marginTop: "20px", fontSize: "0.85rem", color: "#666" }}
          >
            لديك حساب؟{" "}
            <Link
              to="/login"
              style={{
                color: "#1b2d5a",
                fontWeight: "bold",
                textDecoration: "none",
              }}
            >
              تسجيل الدخول
            </Link>
          </div>
        </form>
      </div>
    </div>
  );
};

export default Register;
