<?php 
session_start();
unset($_SESSION[ 'username' ]);
session_destroy();                    // Terminate current user session
header('Location: login.php')         // Redirect user to login page
?>

