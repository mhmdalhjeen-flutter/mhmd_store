<?php
session_start();
include 'dp.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    header("Location: shop.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];
$total_price = 0;

// 1. حساب الإجمالي الكلي للتحقق
$ids = implode(',', array_keys($cart));
$products = []; // لتخزين بيانات المنتجات لاستخدامها لاحقاً
$result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");

while ($row = $result->fetch_assoc()) {
    $qty = $cart[$row['id']];
    $total_price += $row['price'] * $qty;
    $products[$row['id']] = $row;
}

// 2. إنشاء الطلب (Order)
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
$stmt->bind_param("id", $user_id, $total_price);

if ($stmt->execute()) {
    $order_id = $conn->insert_id;

    // 3. إدراج تفاصيل الطلب (Order Items)
    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    
    foreach ($cart as $pid => $qty) {
        if (isset($products[$pid])) {
            $price = $products[$pid]['price'];
            $stmt_item->bind_param("iiid", $order_id, $pid, $qty, $price);
            $stmt_item->execute();
        }
    }

    // 4. تفريغ السلة وتوجيه المستخدم
    unset($_SESSION['cart']);
    
    // صفحة نجاح بسيطة
    $success_msg = "تم استلام طلبك بنجاح! رقم الطلب: #$order_id";
} else {
    $error_msg = "حدث خطأ أثناء معالجة الطلب.";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إتمام الطلب</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>body { font-family: 'Tajawal', sans-serif; padding-top: 50px; text-align: center; }</style>
</head>
<body>
    <div class="container">
        <?php if (isset($success_msg)): ?>
            <div class="card shadow p-5 border-success">
                <h1 class="text-success display-4">✅ شكراً لك!</h1>
                <p class="lead mt-3"><?= $success_msg ?></p>
                <p>سنتواصل معك قريباً لتوصيل الطلب.</p>
                <a href="shop.php" class="btn btn-primary mt-4">العودة للمتجر</a>
                <a href="orders.php" class="btn btn-outline-secondary mt-4">متابعة طلباتي</a>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.</div>
            <a href="cart.php" class="btn btn-dark">عودة للسلة</a>
        <?php endif; ?>
    </div>
</body>
</html>
