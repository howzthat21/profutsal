<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id=$_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];

    $query = "UPDATE friends SET status = 'accepted' WHERE friend_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);

    
}

$get_friend_req="SELECT u.username, fr.request_id from users u 
JOIN friend_requests fr on u.id=fr.sender_id where fr.receiver_id = ? AND fr.status='pending'";

$get_friend_req_stmt = $pdo->prepare($get_friend_req);
$get_friend_req_stmt->execute([$user_id]);
$friends_requests = $get_friend_req_stmt->fetchAll(PDO::FETCH_ASSOC);

if ($friends_requests) {
    foreach ($friends_requests as $request) {
        $request_id = $request['request_id'];
        $user_name = $request['username'];
        echo "Request ID: $request_id, Username: $user_name<br>";
    }
} else {
    echo "No friend requests found.";
}


echo $request_id;
echo $user_id;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="accept_friend_request.php" method= "post">
        <input type="hidden" name="request_id" value="<?php echo $request_id;?>">
        <button type="submit">Accept</button>
    </form>
    
</body>
</html>


