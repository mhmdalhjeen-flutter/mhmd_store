<?php
    session_start();
    include 'dp.php';

    if (isset($_SESSION['user_id'])) {
        header("Location: shop.php");
        exit();
    }

    $message = "";
    $msg_type = "warning"; // لتلوين الرسالة (warning/success)

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name     = htmlspecialchars(trim($_POST["name"]));
        $email    = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $password = $_POST["password"];

        // 1. معيارية البريد الإلكتروني
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "صيغة البريد الإلكتروني غير صحيحة.";
        } 
        // 2. معيارية كلمة المرور (8 خانات، كبير، صغير، رقم)
        elseif (strlen($password) < 8) {
            $message = "كلمة المرور يجب أن تكون 8 خانات على الأقل.";
        }
        elseif (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
            $message = "كلمة المرور يجب أن تحتوي على حرف كبير، حرف صغير، ورقم.";
        }
        else {
            try {
                // التحقق من تكرار البريد
                $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $message = "هذا البريد الإلكتروني مسجل مسبقاً!";
                } else {
                    // التشفير والإضافة
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $name, $email, $hashed_password);

                    if ($stmt->execute()) {
                        $_SESSION["user_id"]   = $conn->insert_id;
                        $_SESSION["user_name"] = $name;
                        header("Location: shop.php");
                        exit();
                    }
                }
            } catch (Exception $e) {
                $message = "حدث خطأ تقني: " . $e->getMessage();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب | متجر الهجين</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Tajawal', sans-serif; }
        .auth-container { max-width: 500px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .btn-primary { background-color: #3498db; border: none; }
        .btn-primary:hover { background-color: #2980b9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <h3 class="text-center mb-4">متجر الهجين - تسجيل جديد</h3>
            
            <?php if ($message): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label>الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                    <small class="text-muted">يجب أن تحتوي على 8 خانات، حرف كبير، صغير، ورقم.</small>
                </div>
                <button type="submit" class="btn btn-primary w-100">تسجيل</button>
                <div class="text-center mt-3">
                    لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
