// src/routes/AppRoutes.jsx
import { Routes, Route } from "react-router-dom";
import Login from "../pages/auth/Login";
import Register from "../pages/auth/Register";
// استيراد الصفحات الخاصة بمشروع المركز
import Home from "../pages/Home";
import About from "../pages/About";
import Activities from "../pages/Activities";
import News from "../pages/News";
import Contact from "../pages/Contact";
// أضفنا صفحة الفعاليات لتكتمل هيكلية الموقع المترابطة
import Events from "../pages/Events";
import NotFound from "../pages/NotFound";
import Programs from "../pages/Programs";
import Gallery from "../pages/Gallery";
import Verify from "../pages/auth/Verify";
import ForgotPassword from "../pages/auth/ForgotPassword";
import VerifyResetCode from "../pages/auth/VerifyResetCode";
import ResetPassword from "../pages/auth/ResetPassword"; 
import Layout from "../components/layout/Layout";
import GalleryImagesSection from "../pages/GalleryImagesSection";

const AppRoutes = () => {
  return (
    <Routes>
      <Route element={<Layout />}>
        <Route path="/" element={<Home />} />
        <Route path="/about" element={<About />} />
        <Route path="/activities" element={<Activities />} />
        <Route path="/activities/:categoryId" element={<Activities />} />
        <Route path="/news" element={<News />} />
        <Route path="/programs" element={<Programs />} />
        <Route path="/gallery" element={<Gallery />} />
        
        <Route path="/gallery/:albumId" element={<GalleryImagesSection />} />
        <Route path="/events" element={<Events />} />{" "}
        {/* مسار الفعاليات الجديد */}
        <Route path="/contact" element={<Contact />} />
        
      
      </Route>

      {/* صفحة الخطأ تظهر منفصلة بدون النافبار والفوتر إذا أردتِ ذلك */}
      <Route path="*" element={<NotFound />} />
       <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
       <Route path="/forgot-password" element={<ForgotPassword />} />
        <Route path="/verify-reset" element={<VerifyResetCode />} />
        <Route path="/reset-password" element={<ResetPassword />} />
        <Route path="/verify" element={<Verify />} />
    </Routes>
  );
};

export default AppRoutes;
