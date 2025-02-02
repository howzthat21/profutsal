<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: adminIndex.php");
    exit();
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: adminIndex.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e88e5, #4caf50);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            color: #fff;
            margin: 0;
        }
        .container {
            margin-top: 5%;
            text-align: center;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #fff;
        }
        .btn {
            width: 250px;
            padding: 15px;
            font-size: 1.2rem;
            margin: 15px 0;
            border-radius: 10px;
            border: none;
            font-weight: bold;
        }
        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        .btn-primary:hover {
            background-color: #0069d9;
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: #000;
        }
        .btn-warning:hover {
            background-color: #d39e00;
        }
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        .btn-danger:hover {
            background-color: #bd2130;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <a href="view_arenas.php" class="btn btn-primary">Manage Arenas</a>
        <a href="view_users.php" class="btn btn-success">Manage Users</a>
        <a href="viewPayment.php" class="btn btn-success">View Payments</a>
        <a href="viewReferees.php" class="btn btn-warning">Manage Referee</a>
        <a href="?logout=true" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
