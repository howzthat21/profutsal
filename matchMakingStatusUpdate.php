<?php
include 'db.php'; 
@session_start();



$user_id= $_SESSION['user_id'];
//echo $user_id;




function updateMatchmakingStatus($pdo) {
    
    
    
    $sql = "SELECT arena_id, match_id, booking_datetime, status 
            FROM matchmaking 
            WHERE status IN ('pending','lineups', 'inprogress', 'fulltime')";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $matchId = $row['match_id'];
        $bookingDatetime = new DateTime($row['booking_datetime']);
        $status = $row['status'];
        $arenaId=$row['arena_id'];
        $currentDatetime = new DateTime();
       // echo $matchId;

        if($status === 'pending' && $currentDatetime>= $bookingDatetime){
            $delete_match="DELETE FROM matchmaking where match_id = ?";
            $delete_stmt=$pdo->prepare($delete_match);
            $delete_stmt->execute([$matchId]);
            
            //echo "deleted";
        }

        if ($status === 'lineups' && $currentDatetime >= $bookingDatetime) {
            
            $updateStatusSql = "UPDATE matchmaking SET status = 'inprogress' WHERE match_id = ?";
            $updateStmt = $pdo->prepare($updateStatusSql);
            $updateStmt->execute([$matchId]);
            //insert the code
           /* $insertCompletedMatches = "INSERT INTO completed_matches (arena_id, match_id) VALUES (?, ?)";
            $insertCompletedMatchesStmt = $pdo->prepare($insertCompletedMatches);
            $insertCompletedMatchesStmt->execute([$arenaId, $matchId]);
            */
        }

        
        $oneHourAfterBooking = clone $bookingDatetime;
        $hour_late = $oneHourAfterBooking->modify('+1 hour');

        $hour_late->format('Y-m-d H:i:s');
       // echo "<h1>" . $hour_late->format('Y-m-d H:i:s') . "</h1>";
        //var_dump($bookingDatetime);

        $realCurrentDatetime = new DateTime('now', new DateTimeZone('Asia/Kathmandu'));

        //echo "<h2>" . $realCurrentDatetime->format('Y-m-d H:i:s') . "</h2>";


       // echo "Current Time: " . $realCurrentDatetime->format('Y-m-d H:i:s') . "<br>";
//echo "One Hour After Booking: " . $oneHourAfterBooking->format('Y-m-d H:i:s') . "<br>";




        

        if ($status === 'inprogress' && $realCurrentDatetime >= $hour_late) {
            
           $updateStatusSql = "UPDATE matchmaking SET status = 'fulltime' WHERE match_id = ?";
           $updateStmt = $pdo->prepare($updateStatusSql);
          $updateStmt->execute([$matchId]);
       }

        

       try {
        if ($status === 'fulltime') {
            //check if the match has been added to the complete_matches table
            $check_complete_matches="SELECT  match_id from completed_matches where match_id=?";
            $check_complete_matches_stmt=$pdo->prepare($check_complete_matches);
            $check_complete_matches_stmt->execute([$matchId]);
            $check_complete_matches_result=$check_complete_matches_stmt->fetch(PDO::FETCH_ASSOC);
            if(!$check_complete_matches_result){

                $insertCompletedMatches = "INSERT INTO completed_matches (arena_id, match_id) VALUES (?, ?)";
                $insertCompletedMatchesStmt = $pdo->prepare($insertCompletedMatches);
                $insertCompletedMatchesStmt->execute([$arenaId, $matchId]);
               // echo "Match successfully inserted into completed_matches.";
                //if match already exists in the table delete from matchmaking table with the same id

                //$delete_matchmaking="DELETE FROM matchmaking WHERE match_id=?";
               // $delete_matchmaking_stmt=$pdo->prepare($delete_matchmaking);

               // $delete_matchmaking_stmt->execute([$matchId]);
                //echo "Match removed from the matchmakin tbale";
                
            }

            else{
                //echo "unsuccessful";
           
            }
            //query to insert into completed_match_participants table
            $user_id= $_SESSION['user_id'];

            $fetchQuery = "SELECT user_id, match_id, team_name FROM match_participants WHERE match_id = :match_id";
    $fetchStmt = $pdo->prepare($fetchQuery);
    $fetchStmt->execute(['match_id' => $matchId]);

    $participants = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);

    if ($participants) {
        // Insert data into completed_match_participants
        $insertQuery = "INSERT INTO completed_match_participants (user_id, match_id, team_name) VALUES (:user_id, :match_id, :team_name)";
        $insertStmt = $pdo->prepare($insertQuery);

        foreach ($participants as $participant) {
            $insertStmt->execute([
                'user_id' => $participant['user_id'],
                'match_id' => $participant['match_id'],
                'team_name' => $participant['team_name']
            ]);
        }

        try{
            $delete_match_participants= "DELETE FROM match_participants WHERE match_id = ? ";
           $delete_match_participants_stmt= $pdo->prepare($delete_match_participants);
           $delete_match_participants_stmt->execute([$matchId]);
       }   catch(PDOException $e){
           //echo "Error: " . $e->getMessage();
       }

       

       // echo "Participants successfully inserted into completed_match_participants!";
    }

            
            

            
            
            
        }
       
    } catch (PDOException $e) {
       // echo "Error: " . $e->getMessage();
    }
        
    
    
    
       
        
        

    }
}
updateMatchmakingStatus($pdo);
?>
