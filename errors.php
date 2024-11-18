<?php
include 'db.php';

function handleSQLError($errorMessage) {
    // Log the detailed error message for debugging (optional)
    error_log("SQL Error: " . $errorMessage, 0); // Log to PHP error log

    // Display a generic error message to the user
    echo "An error occurred while processing your request. Please try again later.";
}
?>
