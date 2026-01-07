<?php
session_start();
include 'dp.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// جلب جميع طلبات المستخدم مرتبة من الأحدث للأقدم
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلباتي | متجر صقر</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <style>
        body { font-family: 'Tajawal', sans-serif; background-color: #f8f9fa; }
        .order-header { cursor: pointer; transition: background 0.2s; }
        .order-header:hover { background-color: #f1f1f1; }
        .status-pending { color: #f39c12; font-weight: bold; }
        .status-completed { color: #27ae60; font-weight: bold; }
        .status-cancelled { color: #c0392b; font-weight: bold; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-5">
    <div class="container">
        <a class="navbar-brand" href="shop.php">متجر صقر</a>
        <div class="ms-auto">
            <a href="shop.php" class="btn btn-outline-light btn-sm me-2">العودة للمتجر</a>
            <a href="logout.php" class="btn btn-danger btn-sm">خروج</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="text-center mb-4"><i class="fas fa-history"></i> سجل طلباتي</h2>

    <?php if ($orders_result->num_rows > 0): ?>
        <div class="accordion" id="ordersAccordion">
            <?php while ($order = $orders_result->fetch_assoc()): ?>
                <?php 
                    $order_id = $order['id'];
                    // تحديد لون الحالة
                    $status_class = 'status-' . strtolower($order['status']);
                    
                    // جلب تفاصيل المنتجات لهذا الطلب
                    $items_sql = "SELECT oi.*, p.name, p.image 
                                  FROM order_items oi 
                                  JOIN products p ON oi.product_id = p.id 
                                  WHERE oi.order_id = $order_id";
                    $items_result = $conn->query($items_sql);
                ?>
                
                <div class="accordion-item mb-3 shadow-sm border-0">
                    <h2 class="accordion-header" id="heading<?= $order_id ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $order_id ?>">
                            <div class="d-flex justify-content-between w-100 me-3 align-items-center">
                                <div>
                                    <strong>طلب رقم #<?= $order_id ?></strong> <br>
                                    <small class="text-muted"><?= date('Y-m-d h:i A', strtotime($order['order_date'])) ?></small>
                                </div>
                                <div class="text-end">
                                    <span class="<?= $status_class ?>"><?= ucfirst($order['status']) ?></span> <br>
                                    <span class="text-primary fw-bold">$<?= number_format($order['total_price'], 2) ?></span>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse<?= $order_id ?>" class="accordion-collapse collapse" data-bs-parent="#ordersAccordion">
                        <div class="accordion-body bg-light">
                            <table class="table table-sm table-bordered bg-white">
                                <thead>
                                    <tr>
                                        <th>المنتج</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                        <th>الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($item = $items_result->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <?php if($item['image']): ?>
                                                    <img src="<?= htmlspecialchars($item['image']) ?>" width="30" height="30" style="object-fit:cover" class="rounded me-2">
                                                <?php endif; ?>
                                                <?= htmlspecialchars($item['name']) ?>
                                            </td>
                                            <td class="text-center"><?= $item['quantity'] ?></td>
                                            <td>$<?= number_format($item['price'], 2) ?></td>
                                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-basket fa-3x text-muted mb-3"></i>
            <p class="lead">لم تقم بأي طلبات حتى الآن.</p>
            <a href="shop.php" class="btn btn-primary">ابدأ التسوق الآن</a>
        </div>
    <?php endif; ?>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
