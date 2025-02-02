<?php
session_start();
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $referee_login_query = "SELECT * FROM referee WHERE username = ?";
    $referee_login_stmt = $pdo->prepare($referee_login_query);
    $referee_login_stmt->execute([$username]);
    $referee = $referee_login_stmt->fetch();

    if ($username && $password === "420p420p420p") {
        $_SESSION['referee_id'] = $referee['referee_id'];
        $_SESSION['referee_name'] = $referee['username'];
        header("Location: refereeView.php");
        exit;
    } else {
        $error_message = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referee Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #007bff;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="login-container">
        <h2 class="text-center">Referee Login</h2>
        <form action="" method="POST" class="mt-4">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
            </div>
            <div class="form-group mt-3">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-custom mt-4 w-100">Login</button>
        </form>
        <?php if (isset($error_message)): ?>
            <p class="text-danger text-center mt-3"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
