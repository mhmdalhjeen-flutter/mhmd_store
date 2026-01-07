<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard | Alhjeen Store</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/all.min.css">
  <style>
      body { background-color: #f4f6f9; font-family: 'Tajawal', sans-serif; }
      .card-dashboard { transition: 0.3s; border: none; border-radius: 10px; }
      .card-dashboard:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
      .icon-large { font-size: 3rem; margin-bottom: 15px; color: #3498db; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="admin.php">Alhjeen Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
  <h2 class="text-center mb-5">Alhjeen Dashboard</h2>

  <div class="row g-4 justify-content-center">
    <div class="col-md-4">
      <div class="card card-dashboard h-100 p-4 text-center">
        <i class="fas fa-users icon-large"></i>
        <h4>Manage Customers</h4>
        <p class="text-muted">View and manage registered store customers.</p>
        <a href="manage_users.php" class="btn btn-outline-primary mt-auto">Go to Customers</a> 
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-dashboard h-100 p-4 text-center">
        <i class="fas fa-mobile-alt icon-large text-success"></i>
        <h4>Manage Products</h4>
        <p class="text-muted">Add, edit, or remove store products.</p>
        <a href="manage_products.php" class="btn btn-outline-success mt-auto">Go to Products</a>
      </div>
    </div>
  </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
