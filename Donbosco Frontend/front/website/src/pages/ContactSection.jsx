import { useState } from "react";
import axios from "axios";
import { Send, Loader2 } from "lucide-react";

const ContactSection = () => {
  const activeColor = "#1b2d5a";
  const bgColor = "#ebf0f3";
  const token = localStorage.getItem("access_token");
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    subject: "",
    message: "",
  });

  const [loading, setLoading] = useState(false);
  const [mainMessage, setMainMessage] = useState("");
  const [type, setType] = useState(""); // success | error
  const [errors, setErrors] = useState({});

  // ✅ التعامل مع الحقول
  const handleChange = (e) => {
    const { name, value } = e.target;

    setFormData((prev) => ({ ...prev, [name]: value }));

    // حذف الخطأ أول ما المستخدم يكتب
    setErrors((prev) => ({ ...prev, [name]: "" }));
  };

  // ✅ إرسال الفورم
  const handleSubmit = async (e) => {
    e.preventDefault();

    setLoading(true);
    setErrors({});
    setMainMessage("");

    try {
      const res = await axios.post(
        "http://localhost:8000/api/sendMessage",
        formData,
        { headers: { Authorization: `Bearer ${token}` } },
      );

      setType("success");
      setMainMessage(res.data.message || "تم إرسال الرسالة بنجاح ✅");

      setFormData({
        name: "",
        email: "",
        phone: "",
        subject: "",
        message: "",
      });
    } catch (error) {
      if (error.response?.status === 422) {
        setErrors(error.response.data.errors);

        // أول خطأ يظهر فوق
        const firstError = Object.values(error.response.data.errors)[0][0];

        setType("error");
        setMainMessage(firstError);
      } else {
        setType("error");
        setMainMessage("عليك تسجيل الدخول اولا");
      }
    } finally {
      setLoading(false);
    }
  };

  const styles = {
    container: {
      backgroundColor: bgColor,
      padding: "60px 20px",
    },
    card: {
      backgroundColor: bgColor,
      borderRadius: "40px",
      boxShadow: "10px 10px 20px #d1d9e6, -10px -10px 20px #ffffff",
      padding: "40px",
      maxWidth: "700px",
      margin: "0 auto",
    },
    input: {
      backgroundColor: bgColor,
      border: "none",
      borderRadius: "20px",
      boxShadow: "inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff",
      outline: "none",
      padding: "15px 20px",
      width: "100%",
      color: "#1b2d5a",
    },
  };

  return (
    <section style={styles.container} dir="rtl">
      <div style={styles.card}>
        {/* العنوان */}
        <h2
          style={{
            color: activeColor,
            textAlign: "center",
            marginBottom: "30px",
            fontSize: "2rem",
            fontWeight: "bold",
          }}
        >
          تواصل معنا
        </h2>

        {/* 🔥 رسالة عامة */}
        {mainMessage && (
          <div
            style={{
              marginBottom: "20px",
              padding: "12px",
              borderRadius: "15px",
              textAlign: "center",
              fontWeight: "bold",
              background: type === "success" ? "#e6f7ee" : "#ffe5e5",
              color: type === "success" ? "#1e7e34" : "#d8000c",
            }}
          >
            {mainMessage}
          </div>
        )}

        <form onSubmit={handleSubmit} style={{ display: "grid", gap: "20px" }}>
          {/* الاسم */}
          <div>
            <input
              type="text"
              name="name"
              placeholder="الاسم الكامل"
              style={styles.input}
              value={formData.name}
              onChange={handleChange}
            />
            {errors.name && (
              <small style={{ color: "red" }}>{errors.name[0]}</small>
            )}
          </div>

          {/* الإيميل */}
          <div>
            <input
              type="email"
              name="email"
              placeholder="البريد الإلكتروني"
              style={styles.input}
              value={formData.email}
              onChange={handleChange}
            />
            {errors.email && (
              <small style={{ color: "red" }}>{errors.email[0]}</small>
            )}
          </div>

          {/* الهاتف */}
          <div>
            <input
              type="text"
              name="phone"
              placeholder="رقم الهاتف"
              style={styles.input}
              value={formData.phone}
              onChange={handleChange}
            />
            {errors.phone && (
              <small style={{ color: "red" }}>{errors.phone[0]}</small>
            )}
          </div>

          {/* الموضوع */}
          <div>
            <input
              type="text"
              name="subject"
              placeholder="الموضوع"
              style={styles.input}
              value={formData.subject}
              onChange={handleChange}
            />
            {errors.subject && (
              <small style={{ color: "red" }}>{errors.subject[0]}</small>
            )}
          </div>

          {/* الرسالة */}
          <div>
            <textarea
              name="message"
              rows="5"
              placeholder="اكتب رسالتك..."
              style={{ ...styles.input, borderRadius: "30px" }}
              value={formData.message}
              onChange={handleChange}
            />
            {errors.message && (
              <small style={{ color: "red" }}>{errors.message[0]}</small>
            )}
          </div>

          {/* زر الإرسال */}
          <button
            type="submit"
            disabled={loading}
            style={{
              backgroundColor: activeColor,
              color: "#fff",
              padding: "15px",
              borderRadius: "30px",
              fontWeight: "bold",
              width: "100%",
              display: "flex",
              alignItems: "center",
              justifyContent: "center",
              gap: "10px",
              cursor: "pointer",
            }}
          >
            {loading ? (
              <Loader2 className="animate-spin" />
            ) : (
              <>
                <span>إرسال الرسالة</span>
                <Send size={18} />
              </>
            )}
          </button>
        </form>
      </div>
    </section>
  );
};

export default ContactSection;
