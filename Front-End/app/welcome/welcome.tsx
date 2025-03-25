import { useState, useEffect } from "react";
import axios from "axios";
import type { LoginResponse } from "../types"; // ✅ استيراد النوع الصحيح

export default function Welcome() {
  const [userData, setUserData] = useState<LoginResponse | null>(null);
  const [error, setError] = useState<string>("");
  const [isClient, setIsClient] = useState(false); // متغير لتحديد ما إذا كنا في المتصفح

  useEffect(() => {
    // التأكد من أن الكود يعمل فقط في المتصفح
    setIsClient(true);
  }, []);

  const handleLogin = async () => {
    try {
      const response = await axios.post<LoginResponse>("http://127.0.0.1:8000/api/login", {
        email: "rs@o68o.com",
        password: "178",
      });

      setUserData(response.data);
      setError("");
      localStorage.setItem("token", response.data.access_token);
    } catch (err) {
      setError("فشل تسجيل الدخول! تأكد من البيانات.");
      setUserData(null);
    }
  };

  // عرض الكود فقط في المتصفح بعد التحقق
  if (!isClient) {
    return null; // أو يمكنك إظهار تحميل أو شيء آخر
  }

  return (
    <div className="p-5 max-w-md mx-auto bg-white shadow-md rounded-md">
      <h2 className="text-xl font-bold mb-4">مرحباً بك</h2>
      <button
        onClick={handleLogin}
        className="bg-blue-500 text-white p-2 rounded w-full"
      >
        تسجيل الدخول
      </button>

      {userData && (
        <div className="mt-4 p-3 bg-green-100 rounded">
          <p>✅ تسجيل الدخول ناجح!</p>
          <p><strong>الاسم:</strong> {userData.user.name}</p>
          <p><strong>البريد:</strong> {userData.user.email}</p>
        </div>
      )}

      {error && <p className="mt-4 text-red-500">{error}</p>}
    </div>
  );
}
