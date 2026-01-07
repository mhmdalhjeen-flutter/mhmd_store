<?php
session_start();
include 'dp.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// معالجة تحديث الكمية أو الحذف
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $pid => $qty) {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$pid]);
        } else {
            $_SESSION['cart'][$pid] = intval($qty);
        }
    }
}

if (isset($_GET['remove'])) {
    $pid = intval($_GET['remove']);
    unset($_SESSION['cart'][$pid]);
    header("Location: cart.php");
    exit();
}

$cart_items = [];
$total_price = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $row['qty'] = $_SESSION['cart'][$row['id']];
        $row['subtotal'] = $row['price'] * $row['qty'];
        $total_price += $row['subtotal'];
        $cart_items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سلة التسوق</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <style>body { font-family: 'Tajawal', sans-serif; background: #f8f9fa; }</style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="shop.php">متجر صقر</a>
        <a href="shop.php" class="btn btn-outline-light btn-sm">تابع التسوق</a>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4 text-center">سلة المشتريات</h2>

    <?php if (empty($cart_items)): ?>
        <div class="alert alert-info text-center">السلة فارغة حالياً. <a href="shop.php">تصفح المنتجات</a></div>
    <?php else: ?>
        <form method="POST" action="cart.php">
            <table class="table table-bordered bg-white">
                <thead class="table-light">
                    <tr>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th width="150">الكمية</th>
                        <th>المجموع</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <input type="number" name="quantity[<?= $item['id'] ?>]" 
                                       value="<?= $item['qty'] ?>" min="1" class="form-control text-center">
                            </td>
                            <td>$<?= number_format($item['subtotal'], 2) ?></td>
                            <td>
                                <a href="cart.php?remove=<?= $item['id'] ?>" class="text-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">الإجمالي الكلي:</td>
                        <td colspan="2" class="fw-bold text-success">$<?= number_format($total_price, 2) ?></td>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between">
                <button type="submit" name="update_cart" class="btn btn-secondary">تحديث السلة</button>
                <a href="checkout.php" class="btn btn-success btn-lg">إتمام الشراء <i class="fas fa-check"></i></a>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
