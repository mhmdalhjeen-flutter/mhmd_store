<?php
    session_start();
    include 'dp.php';

    if (isset($_SESSION['user_id'])) {
        header("Location: shop.php");
        exit();
    }
    if (isset($_SESSION['admin_id'])) {
        header("Location: admin.php");
        exit();
    }

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: shop.php");
                exit();
            } else {
                $message = "كلمة المرور غير صحيحة";
            }
        } else {
            $stmt = $conn->prepare("SELECT id, name, password FROM admins WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                if (password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['name'];
                    header("Location: admin.php");
                    exit();
                } else {
                    $message = "كلمة المرور غير صحيحة";
                }
            } else {
                $message = "البريد الإلكتروني غير مسجل";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول | متجر الهجين</title>
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
            <h3 class="text-center mb-4">متجر الهجين - تسجيل الدخول</h3>
            <?php if ($message): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">دخول</button>
                <div class="text-center mt-3">
                    ليس لديك حساب؟ <a href="register.php">أنشئ حساباً الآن</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
