<?php
session_start();
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $referee_login_query= "SELECT * from referee where username = ? ";
    $referee_login_stmt = $pdo->prepare($referee_login_query);
    $referee_login_stmt->execute([$username]);
    $referee = $referee_login_stmt->fetch();

    if($username && $password==="420p420p420p"){
        $_SESSION['referee_id']= $referee['referee_id'];
        $_SESSION['referee_name']= $referee['username'];
        header("Location: refereeView.php");
        
    }
    else{
        echo "Invalid username or password";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referee Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <a href="ref_logout.php">logout</a>
<div class="container mt-5">
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
        <button type="submit" class="btn btn-primary mt-4 w-100">Login</button>
    </form>
    <?php if (isset($error_message)): ?>
        <p class="text-danger text-center mt-3"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
</div>
</body>
</html>
