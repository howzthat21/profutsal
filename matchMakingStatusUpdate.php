<?php
include 'db.php'; 

function updateMatchmakingStatus($pdo) {
    
    
    
    $sql = "SELECT arena_id, match_id, booking_datetime, status 
            FROM matchmaking 
            WHERE status IN ('lineups', 'inprogress', 'fulltime')";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $matchId = $row['match_id'];
        $bookingDatetime = new DateTime($row['booking_datetime']);
        $status = $row['status'];
        $arenaId=$row['arena_id'];
        $currentDatetime = new DateTime();
        
        if ($status === 'lineups' && $currentDatetime >= $bookingDatetime) {
            
            $updateStatusSql = "UPDATE matchmaking SET status = 'inprogress' WHERE match_id = ?";
            $updateStmt = $pdo->prepare($updateStatusSql);
            $updateStmt->execute([$matchId]);
        }

        
        $oneHourAfterBooking = clone $bookingDatetime;
        $hour_late = $oneHourAfterBooking->modify('+1 hour');

        $hour_late->format('Y-m-d H:i:s');
        echo "<h1>" . $hour_late->format('Y-m-d H:i:s') . "</h1>";
        var_dump($bookingDatetime);

        $realCurrentDatetime = new DateTime('now', new DateTimeZone('Asia/Kathmandu'));

        echo "<h2>" . $realCurrentDatetime->format('Y-m-d H:i:s') . "</h2>";


        echo "Current Time: " . $realCurrentDatetime->format('Y-m-d H:i:s') . "<br>";
echo "One Hour After Booking: " . $oneHourAfterBooking->format('Y-m-d H:i:s') . "<br>";




        

        if ($status === 'inprogress' && $realCurrentDatetime >= $hour_late) {
            
           $updateStatusSql = "UPDATE matchmaking SET status = 'fulltime' WHERE match_id = ?";
           $updateStmt = $pdo->prepare($updateStatusSql);
          $updateStmt->execute([$matchId]);
       }

        

       try {
        if ($status === 'fulltime') {
            $insertCompletedMatches = "INSERT INTO completed_matches (arena_id, match_id) VALUES (?, ?)";
            $insertCompletedMatchesStmt = $pdo->prepare($insertCompletedMatches);
            $insertCompletedMatchesStmt->execute([$arenaId, $matchId]);
            echo "Match successfully inserted into completed_matches.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
       
        
        

    }
}
updateMatchmakingStatus($pdo);
?>
