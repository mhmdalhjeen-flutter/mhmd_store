<?php
session_start();
include 'dp.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

$where_clauses = ["1=1"]; 
$order_by_clause = "ORDER BY created_at DESC";

$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where_clauses[] = "(name LIKE '%$search%' OR description LIKE '%$search%')";
    $search_query = htmlspecialchars($_GET['search']);
}

$min_price = "";
$max_price = "";
if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
    $min = floatval($_GET['min_price']);
    $where_clauses[] = "price >= $min";
    $min_price = $min;
}
if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $max = floatval($_GET['max_price']);
    $where_clauses[] = "price <= $max";
    $max_price = $max;
}

$sort_option = "newest";
if (isset($_GET['sort'])) {
    $sort_option = $_GET['sort'];
    switch ($sort_option) {
        case 'price_asc': $order_by_clause = "ORDER BY price ASC"; break;
        case 'price_desc': $order_by_clause = "ORDER BY price DESC"; break;
        case 'oldest': $order_by_clause = "ORDER BY created_at ASC"; break;
    }
}

$where_sql = implode(' AND ', $where_clauses);
$sql = "SELECT * FROM products WHERE $where_sql $order_by_clause";
$result = $conn->query($sql);

$products_data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products_data[] = $row;
    }
}

include 'templates/shop_view.php';
?>
