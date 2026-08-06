// src/components/ui/Input.jsx
import { forwardRef } from "react";

const Input = forwardRef(
  ({ label, error, icon: Icon, className = "", ...props }, ref) => {
    return (
      <div className="w-full space-y-1 text-right">
        {/* الليبل (العنوان) */}
        {label && (
          <label className="text-sm font-bold text-gray-700 mr-1">
            {label}
          </label>
        )}

        <div className="relative">
          {/* الأيقونة إذا وجدت */}
          {Icon && (
            <div className="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
              <Icon size={18} />
            </div>
          )}

          <input
            ref={ref}
            className={`
            block w-full px-4 py-3 bg-gray-50 border rounded-xl outline-none transition-all
            ${Icon ? "pr-10" : "pr-4"}
            ${
              error
                ? "border-red-500 focus:ring-1 focus:ring-red-500"
                : "border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            }
            ${className}
          `}
            {...props}
          />
        </div>

        {/* رسالة الخطأ (تظهر فقط عند وجود خطأ) */}
        {error && (
          <p className="text-xs font-bold text-red-500 mr-1 animate-pulse">
            {error}
          </p>
        )}
      </div>
    );
  },
);

Input.displayName = "Input";
export default Input;
