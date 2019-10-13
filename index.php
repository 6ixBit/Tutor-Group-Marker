<html>
<head>
<title> Home </title>
<?php
    include 'templates/nav.html';

    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
?>
</head>
<body>
<?php
    if ($user_email){                             // Checking whether or not user has passed in data
        echo "$user_email . $user_password";
    }
?>
<center><h1><u>Tutor Group Marking System</u></h1></center>
</body>
</html>