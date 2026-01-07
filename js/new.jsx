// بالطبع! هنا مثال بسيط يستخدم React لتطبيق تقنية Single-Page Application (SPA) والتنقل بين الصفحات باستخدام React Router.

// أفترض أن لديك مشروع React جاهز. يمكنك تنفيذ الخطوات التالية لتطبيق التنقل بطريقة SPA:

// 1. تثبيت مكتبة React Router باستخدام npm أو yarn في مجلد مشروعك:

// bash
// npm install react-router-dom

// أو
// bash
// yarn add react-router-dom

// 2. قم بإنشاء ملف "App.js" واستيراد المكونات اللازمة:

// jsx
import React from "react";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";

// استيراد المكونات لكل صفحة
import Home from "./Home";
import About from "./About";
import Contact from "./Contact";

function App() {
  return (
    <Router>
      <div>
        {/* تصميم شريط التنقل */}
        <nav>
          <ul>
            <li>
              <Link to="/">الصفحة الرئيسية</Link>
            </li>
            <li>
              <Link to="/about">معلومات عنا</Link>
            </li>
            <li>
              <Link to="/contact">اتصل بنا</Link>
            </li>
          </ul>
        </nav>

        {/* تعيين مسارات الصفحات */}
        <Switch>
          <Route path="/about">
            <About />
          </Route>
          <Route path="/contact">
            <Contact />
          </Route>
          <Route path="/">
            <Home />
          </Route>
        </Switch>
      </div>
    </Router>
  );
}

export default App;

// 3. قم بإنشاء مكونات الصفحات المختلفة (Home.js و About.js و Contact.js) واملأها بالمحتوى الخاص بك.

// 4. قم بتشغيل تطبيق React الخاص بك:

// bash
// npm start
