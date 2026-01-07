<?php
session_start();
include 'dp.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // التحقق من أن السلة موجودة، إن لم تكن ننشئها
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // إذا كان المنتج موجوداً بالفعل في السلة، نزيد الكمية
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        // وإلا نضيفه بكمية 1
        $_SESSION['cart'][$product_id] = 1;
    }
}

// العودة للصفحة السابقة أو للمتجر
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
