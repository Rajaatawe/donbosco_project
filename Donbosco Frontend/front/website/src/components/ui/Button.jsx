// src/components/ui/Button.jsx
import { Loader2 } from "lucide-react"; // استيراد الأيقونات

const Button = ({
  children,
  variant = "primary",
  className = "",
  isLoading = false, // أضيفي هذه الخاصية
  ...props
}) => {
  const baseClasses =
    "px-6 py-2.5 rounded-full font-medium transition-all duration-300 flex items-center justify-center gap-2 text-sm md:text-base active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed";

  const variants = {
    primary: "bg-[#004693] text-white hover:bg-[#003672]",
    outlineWhite: "border border-white/40 text-white hover:bg-white/10",
    secondary: "bg-[#007BFF] text-white hover:bg-[#0069d9]",
  };

  return (
    <button
      className={`${baseClasses} ${variants[variant]} ${className}`}
      disabled={isLoading || props.disabled} // تعطيل الزر أثناء التحميل
      {...props}
    >
      {/* إذا كان يحمل، أظهري أيقونة التحميل، وإلا أظهري النص (children) */}
      {isLoading && <Loader2 className="animate-spin" size={18} />}
      {children}
    </button>
  );
};

export default Button;
