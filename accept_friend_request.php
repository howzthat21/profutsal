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

    $query_accept= "UPDATE friend_requests SET status='accepted' WHERE request_id=?";
    $stmt_accept = $pdo->prepare($query_accept);
    $stmt_accept->execute([$request_id]);


    
}

$get_friend_req="SELECT u.username, fr.request_id from users u 
JOIN friend_requests fr on u.id=fr.sender_id where fr.receiver_id = ? AND fr.status='pending'";

$get_friend_req_stmt = $pdo->prepare($get_friend_req);
$get_friend_req_stmt->execute([$user_id]);
$friends_requests = $get_friend_req_stmt->fetchAll(PDO::FETCH_ASSOC);






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <?php if($friends_requests): ?>
    <h1>Friend Requests</h1>
    <form action="accept_friend_request.php" method="post">
        <?php foreach ($friends_requests as $friend_request): ?>
            <p><?php echo $friend_request['username']?></p>
            <input type="hidden" name="request_id" value="<?php echo $friend_request['request_id']?>">
            <button type="submit">Accept</button>
            <?php endforeach; ?>
            <?php else: ?>
                <p>No friend requests.</p>
                <?php endif; ?>
    </form>
    
</body>
</html>


