<?php
session_start();
include 'db.php';

/* Uncomment this if you want to restrict access to logged-in users only
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
*/

$fetch_match_details = "SELECT m.match_id, a.arena_name, m.booking_datetime FROM matchmaking m 
                        JOIN arenas a ON a.arena_id = m.arena_id 
                        WHERE m.status = 'inprogress'";
$fetch_match_details = $pdo->query($fetch_match_details);
$fetch_result = $fetch_match_details->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Document</title>
    <script>
        function startCountdown(element, startTime) {
            function updateTimer() {
                const now = new Date().getTime();
                const distance = now - startTime;
                console.log(distance)
                console.log(now)

                if (distance < 0) {
                    clearInterval(interval);
                    element.innerHTML = "Match not started";
                } else {
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        console.log(seconds)
                    element.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
                }
            }

            const interval = setInterval(updateTimer, 1000);
            updateTimer(); // initial call to update the timer right away
        }
    </script>
</head>
<style>

.blinking { 
    animation: blink 1s linear infinite; 
    color: red !important; 
            } 
@keyframes 
blink { 
    50%
     { opacity: 0;
      }
       }
</style>
<body>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Match ID</th>
            <th scope="col">Arena Name</th>
            <th scope="col">Time</th>
            <th scope="col">Score</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($fetch_result)): ?>
            <?php foreach ($fetch_result as $details): ?>
              <tr>
                <th scope="row"><?php echo htmlspecialchars($details['match_id']); ?></th>
                <td><?php echo htmlspecialchars($details['arena_name']); ?></td>
                <td id="timer-<?php echo htmlspecialchars($details['match_id']); ?>"></td>
                <td>0-0</td> <!-- Placeholder for score -->
                <td class="blinking" style="background-color:green">live</td>
              </tr>
              <script>
                  document.addEventListener("DOMContentLoaded", function() {
                      const bookingTime = new Date("<?php echo htmlspecialchars($details['booking_datetime']); ?>").getTime();
                      const timerElement = document.getElementById("timer-<?php echo htmlspecialchars($details['match_id']); ?>");
                      startCountdown(timerElement, bookingTime);
                  });
              </script>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No in-progress matches found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
