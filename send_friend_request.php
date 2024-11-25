<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve sender and receiver IDs from POST data
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];

    // Check if the request already exists
    $check_query = "SELECT * FROM friends WHERE user_id = ? AND friend_id = ?";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->execute([$sender_id, $receiver_id]);

    if ($check_stmt->rowCount() > 0) {
        echo "wait sometime before sending message";
        exit;
    }

    // Insert the friend request
    $query = "INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([$sender_id, $receiver_id])) {
         $query_friend_requests="INSERT INTO friend_requests(sender_id, receiver_id) values (?, ?)";
         $query_friend_requests_stmt=$pdo->prepare($query_friend_requests);
         $query_friend_requests_stmt->execute([$sender_id, $receiver_id]);
        echo "message sent";
    } else {
       echo "failed";
    }
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="send_friend_request.php"></form>
    
</body>
</html>
