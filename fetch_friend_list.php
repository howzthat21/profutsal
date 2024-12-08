<?php
include 'db.php';

$user_id = $_GET['user_id'];

$query = "SELECT u.user_id, u.username, u.profile_picture
          FROM friends f
          JOIN users u ON u.user_id = f.friend_id
          WHERE f.user_id = ? AND f.status = 'accepted'";

$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);

$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($friends);
?>
