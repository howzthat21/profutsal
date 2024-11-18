<?php
include 'db.php';

function handleSQLError($errorMessage) {
    
    error_log("SQL Error: " . $errorMessage, 0); 

    
    echo "An error occurred while processing your request. Please try again later.";
}
?>
