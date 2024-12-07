<?php
include 'db.php';

session_start(); // Start session to handle error messages

// Initialize message
$user_message = null;

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($_POST['password'] !== $confirm_password) {
        $user_message = "Passwords do not match.";
    } else {
        // Check if user exists
        $existing_user = "SELECT * FROM users WHERE username = ? OR email = ?";
        $existing_user_stmt = $pdo->prepare($existing_user);
        $existing_user_stmt->execute([$username, $email]);
        $user_exist = $existing_user_stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_exist) {
            // User exists, set message
            $user_message = "User already exists.";
        } else {
            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            
                $stmt_execute=$stmt->execute([$username, $email, $password]);

                if($stmt){
                header("Location: login.php");
                exit();
                }
            
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Futsal Matchmaking</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="form-container bg-dark p-5 rounded">
      <a href="index.html" class="close-btn" title="Back to Home">&times;</a>
      <h2 class="text-center text-success mb-4">Register</h2>

      <!-- Registration Form -->
      <form action="register.php" method="post">
        <div class="form-group">
          <label for="username" class="text-success">Username</label>
          <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="email" class="text-success">Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="password" class="text-success">Password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="confirm-password" class="text-success">Confirm Password</label>
          <input type="password" id="confirm-password" name="confirm-password" class="form-control" required>
        </div>

        <!-- Display Error Message -->
        <?php if (!empty($user_message)): ?>
        <div class="alert alert-danger">
          <?= htmlspecialchars($user_message); ?>
        </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success btn-block">Submit</button>
      </form>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
