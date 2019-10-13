<html>
<head>
<title> Home </title>
<?php
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
?>
</head>
<body>
<?php
    echo "$user_email, $user_password";
?>
</body>
</html>