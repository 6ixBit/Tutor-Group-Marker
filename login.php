<?php
    session_start();  
?>

<style type="text/css">
<?php
 include 'templates/nav.html';
?>
</style>

<html>
<head>
<title> Login </title>
<?php
    if ( isset( $_POST[ 'submit' ] ) ) {                               /// If Submit/Login button is pressed
        if ( empty( $_POST[ 'email' ]) || empty($_POST[ 'password' ] ) ) {      /// Check whether or not login fiels are empty
            $error = 'One of your fields are empty';
            header('Location: login.php');
        } else {
            $user_email = $_POST[ 'email' ];
            $user_pass = $_POST[ 'password' ];
    
            $_SESSION[ 'username' ] = $user_email;    /// Create session using users_email address
            
            header( 'Location: index.php' );        /// On Successful login, redirect user to Index/Home Page
        }
    }
?>
</head>

<body>
<center>
    <div>
        <form action='login.php' method='POST'>
            Email Address: <br>
            <input type='text' name='email'><br>
            Password: <br>
            <input type='password' name='password'><br><br>

            What type of user are you?
            <select name='user_type'>
                <option value='tutor'>Tutor</option>
                <option value='Student'>Student</option>
            </select> <br> <br>
            <button type='submit' name='submit'>Login</button> <br>
            <p><?php if ( $error ) { echo $error; }  ?>  
            </p>   
        </form>
    </div>
</center>
</body>
</html>