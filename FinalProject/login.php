
<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "Login successful! Welcome, " . $user['username'];
        header("Location: index.php");
    } else {
         echo "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Futsal Matchmaking</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="login-container">
    <!-- Exit Button -->
    <a href="index.html" class="exit-btn" title="Back to Home">&times;</a>

    <!-- Logo and welcome message -->
    <h1 class="logo">Futsal Matchmaking</h1>
    <p class="welcome-message">Welcome back! Please log in to continue.</p>
    
    <!-- Login Form -->
    <form action="login.php" method="POST" class="login-form">
      <!-- Username Input -->
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required placeholder="Enter your username">
      
      <!-- Password Input -->
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Enter your password">
      
      <!-- Submit Button -->
      <button type="submit" class="login-button">Login</button>
      
      <!-- Additional Links -->
      <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
    </form>
  </div>
</body>
</html>
