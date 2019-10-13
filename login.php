<html>
<head>
<title> Login </title>
<?php
    include 'templates/nav.html';
    
    // Grab data from registration fields -> register.php
    $email = $_POST['email'];

    $user_password = $_POST['password'];
    $user_id = $_POST['user_id'];
?>
</head>

<body>
<?php
    echo "$user_email \n";
    echo "$user_password \n";
    echo "$user_id";
?>

<center>
    <div>
        <form action='index.php' method='POST'>
            Email Address: <br>
            <input type='text' name='email'><br>
            Password: <br>
            <input type='text' name='password'><br>
            <button type='submit' name='submit'>Login</button>
        </form>
    </div>
</center>

</body>
</html>