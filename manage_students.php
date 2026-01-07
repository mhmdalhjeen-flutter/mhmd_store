<?php
session_start();
include 'dp.php';

if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit();
}

// Fetch students using mysqli
$result = $conn->query("SELECT id, name, email FROM students");
$students = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Students</title>
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/framework.css">
    <link rel="stylesheet" href="css/styleLogin.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="admin.php">SAQR Admin</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="admin.php">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container mt-5">
  <h2 class="mb-4">Manage Students</h2>

  <a href="add_student.php" class="btn btn-primary mb-3">Add New Student</a>

  <?php if (empty($students)): ?>
    <p class="text-center">No students found.</p>
  <?php else: ?>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th><th>Name</th><th>Email</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($students as $student): ?>
          <tr>
            <td data-label="ID"><?= htmlspecialchars($student['id']) ?></td>
            <td data-label="Name"><?= htmlspecialchars($student['name']) ?></td>
            <td data-label="Email"><?= htmlspecialchars($student['email']) ?></td>
            <td data-label="Actions">
              <a href="delete_student.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
    <script src="js/all.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/6L1D9a0lB8q6Z5qV3p2B5j7QKXn9V7z6u5aC"
        crossorigin="anonymous"></script>
</body>
</html>
