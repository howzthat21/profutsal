<?php
session_start(); //arena booking/futsal_timing


if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php");
    exit();
}

include 'db.php';


if (isset($_GET['arena_id']) && isset($_GET['arena_name'])) {
    $arena_id = htmlspecialchars($_GET['arena_id']);
    $arena_name = htmlspecialchars($_GET['arena_name']); 
    $player_id = $_SESSION['user_id']; 
} else {
    echo "<p>No arena selected.</p>";
    exit(); 
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingTime = $_POST['bookingTime'];

    
    $check_booking_sql = "SELECT * FROM arena_bookings WHERE arena_id = ? AND booking_time = ? AND status='booked'";
    $check_booking_stmt = $pdo->prepare($check_booking_sql);
    $check_booking_stmt->execute([$arena_id, $bookingTime]);

    if ($check_booking_stmt->rowCount() > 0) {
        
        echo "<p>Sorry, the arena is already booked for this time slot. Please select a different time.</p>";
    } else {
        
        $sql = "INSERT INTO arena_bookings (arena_id, player_id, booking_time, status) VALUES (?, ?, ?, 'booked')";
        $stmt = $pdo->prepare($sql);
        $isBooked = $stmt->execute([$arena_id, $player_id, $bookingTime]);

        
        if ($isBooked) {
           
            $timezone = new DateTimeZone('Asia/Kathmandu');
            $bookingDate = new DateTime('now', $timezone);

            $bookingTimeMap = [
                'em' => '07:00:00', // Early Morning (7-8am)
                'mm' => '08:00:00', // Mid Morning (8-9am)
                'lm' => '09:00:00', // Late Morning (9-10am)
                'bn' => '10:00:00', // Before Noon (10-11am)
                'ea' => '11:00:00', // Early Afternoon (11-12pm)
                'ma' => '12:00:00', // Mid Afternoon (12-1pm)
                'mma' => '13:00:00', // Mid Afternoon (1-2pm)
                'la' => '14:00:00', // Late Afternoon (2-3pm)
                'ee' => '15:00:00', // Early Evening (3-4pm)
                'eee' => '16:00:00', // Early Evening (4-5pm)
                'me' => '17:00:00', // Mid Evening (5-6pm)
                'mme' => '18:00:00', // Mid Evening (6-7pm)
                'le' => '19:00:00', // Late Evening (7-8pm)
               
            ];

            
            if (isset($bookingTimeMap[$bookingTime])) {
                
                $bookingDate->setTime(...explode(':', $bookingTimeMap[$bookingTime]));

                
                $bookingDatetime = $bookingDate->format('Y-m-d H:i:s');
            }

            
            $matchmaking_sql = "INSERT INTO matchmaking (match_creator_id, arena_id, booking_datetime, status) VALUES (?, ?, ?, 'pending')";
            $matchmaking_stmt = $pdo->prepare($matchmaking_sql);
            $matchmaking_stmt->execute([$player_id, $arena_id, $bookingDatetime]);

            echo "<p>Booking successfully created in Nepal timezone!</p>";
     
    


if ($bookingDatetime !== null) {
    var_dump($bookingDatetime);
} else {
    echo "Booking datetime was not set!";
}
        // Insert into the matchmaking table to make the lobby public
        //$matchmaking_sql = "INSERT INTO matchmaking (match_creator_id, arena_id) VALUES (?, ?)";
        //$matchmaking_stmt = $pdo->prepare($matchmaking_sql);
        //$matchmaking_stmt->execute([$player_id, $arena_id]); // Pass parameters in correct order

        //$abt_sql="SELECT booking_time FROM arena_bookings";
       // $abt_stmt=$pdo->prepare($sql);
       // $abt_stmt->execute([''])
    
        // Update arena status to "booked" in arena_bookings table
        //$update_arena_status_sql = "UPDATE arena_bookings SET arena_status = 'booked' WHERE arena_id = ?";
        //$update_arena_status_stmt = $pdo->prepare($update_arena_status_sql);
        //$update_arena_status_stmt->execute([$arena_id]); // Set arena status for the specific arena_id
        
        
    } else {
        echo "<p>Booking failed. Please try again.</p>";
    }
    


    
$stray_fetch_sql = "SELECT match_id FROM matchmaking WHERE match_creator_id = :player_id";
$stray_fetch_stmt = $pdo->prepare($stray_fetch_sql);
$stray_fetch_stmt->execute(['player_id' => $player_id]);


$match = $stray_fetch_stmt->fetch(PDO::FETCH_ASSOC);
if ($match) {
    $match_id = $match['match_id']; 

    
    $insert_sql = "INSERT INTO match_participants (match_id, user_id) VALUES (?, ?)";
    $insert_stmt = $pdo->prepare($insert_sql);
    $insert_stmt->execute([$match_id, $player_id]);

    echo "Data inserted successfully!";
} else {
    echo "No match found for the given player_id.";
}


    header("Location: waitinglobby.php");
        exit();
}
}
$arena_id = isset($_GET['arena_id']) ? htmlspecialchars($_GET['arena_id']) : null;
$player_id = $_SESSION['user_id'];


$allBookingTimes = [
    'em' => 'Early Morning (7-8am)',
    'mm' => 'Mid Morning (8-9am)',
    'lm' => 'Late Morning (9-10am)',
    'bn' => 'Before Noon (10-11am)',
    'ea' => 'Early Afternoon (11-12pm)',
    'ma' => 'Mid Afternoon (12-1pm)',
    'mma' => 'Mid Afternoon (1-2pm)',
    'la' => 'Late Afternoon (2-3pm)',
    'ee' => 'Early Evening (3-4pm)',
    'eee' => 'Early Evening (4-5pm)',
    'me' => 'Mid Evening (5-6pm)',
    'mme' => 'Mid Evening (6-7pm)',
    'le' => 'Late Evening (7-8pm)'
];


$bookedTimes = [];
if ($arena_id) {
    $fetch_sql = "SELECT booking_time FROM arena_bookings WHERE arena_id = :arena_id";
    $stmt = $pdo->prepare($fetch_sql);
    $stmt->execute(['arena_id' => $arena_id]);

    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $bookedTimes[] = $row['booking_time'];
    }

}


$availableTimes = array_diff_key($allBookingTimes, array_flip($bookedTimes));
//$test_match_id = 42;




//$check_timefetch = "SELECT booking_datetime FROM matchmaking WHERE match_id = :match_id";
// $check_timefetch_stmt = $pdo->prepare($check_timefetch);


// $check_timefetch_stmt->execute(['match_id' => $test_match_id]);


// $bookingDatetimeString = $check_timefetch_stmt->fetchColumn();

// if ($bookingDatetimeString) {
    
    // $bookingDatetime = new DateTime($bookingDatetimeString);
    
    
    // var_dump($bookingDatetime);
// } else {
    // echo "No booking found for match ID " . $test_match_id;
// }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arena Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2><?php echo htmlspecialchars($arena_name); ?> Arena</h2>

        <!-- Success Message -->
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green;">Booking successful! The arena lobby is now public.</p>
            
            
        <?php endif; ?>

        <form action="futsal_timing.php?arena_name=<?php echo urlencode($arena_name); ?>&arena_id=<?php echo urlencode($arena_id); ?>" method="POST">
            
            <!-- Booking Time Selection -->
            <label for="bookingTime">Booking Time:</label>
            <select name="bookingTime" id="bookingTime" required>
            <?php if (empty($availableTimes)): ?>
                        <option value="" disabled>No times available</option>
                    <?php else: ?>
                        <?php foreach ($availableTimes as $timeCode => $timeLabel): ?>
                            <option value="<?php echo htmlspecialchars($timeCode); ?>">
                                <?php echo htmlspecialchars($timeLabel); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
            </select>

            <!-- Submit Button -->
            <button type="submit">Submit Booking</button>
        </form>
    </div>
</body>
</html>
