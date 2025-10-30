<?php
// Start the session
session_start();

// Destroy all session data
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to the login page (or any other page)
header("Location: login.php");
exit(); // Ensure no further code is executed
?>