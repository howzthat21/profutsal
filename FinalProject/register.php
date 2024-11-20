<?php
include 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //password hashing yo kura pani algorithm used maa halda huncha

    
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    
    
    if ($stmt->execute([$username, $email, $password])) {
        
        header("Location: login.php");
        exit(); 
    } else {
        
        
        handleSQLError($stmt->errorInfo()[2]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Futsal Matchmaking</title>
  <!-- Custom Style CSS -->
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <!-- Registration Form Container -->
   
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="form-container bg-dark p-5 rounded">
      <!-- Close Button -->
<a href="index.html" class="close-btn" title="Back to Home">&times;</a>

      <h2 class="text-center text-success mb-4">Register</h2>
      <form action="register.php" method="post">
        <!-- Username Field -->
        <div class="form-group">
          <label for="username" class="text-success">Username</label>
          <input type="text" id="username" name="username" class="form-control" required>
        </div>
        
        <!-- Email Field -->
        <div class="form-group">
          <label for="email" class="text-success">Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <!-- Password Field -->
        <div class="form-group">
          <label for="password" class="text-success">Password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <!-- Confirm Password Field -->
        <div class="form-group">
          <label for="confirm-password" class="text-success">Confirm Password</label>
          <input type="password" id="confirm-password" name="confirm-password" class="form-control" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success btn-block">Submit</button>
        
      </form>
    </div>
  </div>
  <!-- Bootstrap JavaScript and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
