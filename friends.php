<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
$user_id=$_SESSION['user_id'];
$user_name= $_SESSION['username'];

//$user_id=$_GET['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Friends</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>welcome <?php echo $username;
    echo $user_id;?></h2>

    <!-- Add Friend Form -->
    <div>
        <h4>Send Friend Request</h4>
        <form id="addFriendForm" method="post">
            <div class="mb-3">
                <label for="receiverId" class="form-label">Friend's User ID:</label>
                <input type="number" id="receiverId" name="receiver_id" class="form-control" required>
            </div>
            <input type="hidden" id="senderId" name="sender_id" value="<?php echo htmlspecialchars($user_id);?>"> <!-- Example: Logged-in user ID -->
            <button type="submit" class="btn btn-primary">Send Request</button>
        </form>
    </div>

    <!-- Friends List -->
    <div class="mt-5">
        <h4>Your Friends</h4>
        <ul id="friendsList" class="list-group"></ul>
    </div>
</div>

<script>document.addEventListener('DOMContentLoaded', () => {
    const addFriendForm = document.getElementById('addFriendForm');
    const friendsList = document.getElementById('friendsList');
    const userId = <?php echo htmlspecialchars($user_id);?>

    // Handle Add Friend Form Submission
    addFriendForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Create FormData from form elements
        const formData = new FormData(addFriendForm);

        axios.post('send_friend_request.php', formData)
            .then((response) => {
                alert(response.data.message);
                addFriendForm.reset(); // Clear the form after submission
            })
            .catch((error) => {
                console.error(error);
                alert('Error sending friend request.');
            });
    });

    // Fetch and Display Friends List
    const fetchFriends = () => {
        axios.get(`fetch_friends.php?user_id=${userId}`)
            .then((response) => {
                friendsList.innerHTML = '';
                response.data.forEach(friend => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = `${friend.username} (ID: ${friend.user_id})`;
                    friendsList.appendChild(li);
                });
            })
            .catch((error) => {
                console.error(error);
                friendsList.innerHTML = '<li class="list-group-item">Error loading friends list.</li>';
            });
    };

    fetchFriends(); // Load friends on page load
});
</script>
</body>
</html>
