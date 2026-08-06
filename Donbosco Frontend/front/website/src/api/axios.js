import axios from "axios";

const api = axios.create({
  baseURL: "http://127.0.0.1:8000/api",
  withCredentials: true,
});

// ✅ request interceptor
api.interceptors.request.use((config) => {
  const token = localStorage.getItem("access_token");
  const lang = localStorage.getItem("lang") || "ar";

  // 🔐 token
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  // 🌍 اللغة (إجباري بكل request)
  config.headers["Accept-Language"] = lang;

  return config;
});

// ✅ response interceptor
api.interceptors.response.use(
  (response) => response,
  async (err) => {
    const originalRequest = err.config;

    // ❗ تأكد في response أصلاً
    if (!err.response) {
      return Promise.reject(err);
    }

    // 🔄 refresh token
    if (err.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;

      try {
        const refreshToken = localStorage.getItem("refresh_token");

        if (!refreshToken) {
          localStorage.clear();
          window.location.href = "/login";
          return;
        }

        const res = await axios.post(
          "http://127.0.0.1:8000/api/refresh-token",
          { refresh_token: refreshToken }
        );

        const newToken = res.data.access_token;

        localStorage.setItem("access_token", newToken);

        // 🔁 حدث الهيدر وارجع نفس الريكوست
        originalRequest.headers.Authorization = `Bearer ${newToken}`;

        return api(originalRequest);
      } catch (refreshError) {
        console.log("REFRESH ERROR:", refreshError);
        localStorage.clear();
        window.location.href = "/login";
      }
    }

    return Promise.reject(err);
  }
);

export default api;