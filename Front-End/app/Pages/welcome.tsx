import { Link } from 'react-router-dom';

import { FaShoppingCart, FaUserAlt } from 'react-icons/fa';

export function Welcome() {
  return (
    <div className="flex min-h-screen items-center justify-center bg-gray-100 dark:bg-gray-900">
      <div className="w-full max-w-sm rounded-lg bg-white p-8 shadow-md dark:bg-gray-800">
        <h2 className="mb-6 text-center text-3xl font-semibold text-gray-900 dark:text-white">
          مرحبًا بك في متجرنا الإلكتروني 🛍️
        </h2>
        <p className="mb-8 text-center text-lg text-gray-700 dark:text-gray-300">
          تسوق الآن واستمتع بأفضل العروض!
          قم بانشاء حساب وتسجيل الدخول لعرض المنتجات
        </p>
        <div className="space-y-4">
          <Link
            to="/login" // استخدم `to` بدلاً من `href` مع `Link`
            className="flex items-center justify-center w-full rounded-lg bg-blue-600 px-4 py-2 text-center text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600"
          >
            <FaUserAlt className="mr-2" /> تسجيل الدخول
          </Link>
          <Link
            to="/register" // استخدم `to` بدلاً من `href` مع `Link`
            className="flex items-center justify-center w-full rounded-lg bg-green-600 px-4 py-2 text-center text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-green-500 dark:hover:bg-green-600"
          >
            <FaUserAlt className="mr-2" /> إنشاء حساب
          </Link>
        </div>
      </div>
    </div>
  );
}
