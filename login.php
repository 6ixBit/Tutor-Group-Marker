<?php
    session_start();  
	include 'templates/nav.html';
	include_once 'models.php';
	include 'config.php';
?>

<html>
<head>
<title> Login </title>
<?php
    if ( isset($_POST['submit']) ) {                               
        if (empty($_POST[ 'email' ]) || empty($_POST[ 'password' ])) {      /// Check whether or not login fiels are empty
            $error = 'One of your fields are empty';
            header('Location: login.php');
        } else {
            $user_email = $_POST[ 'email' ];
            $user_pass = $_POST[ 'password' ];
            $_SESSION[ 'username' ] = $user_email;    /// Create session using users_email address

			if ($_POST['user_type'] == 'Student'){
				if (login_student($user_email, $user_pass, $conn)){
					echo "Login Successful!";
					//header( 'Location: index.php' );
				} else {
					$password_error = "Wrong username or password entered!";
				}
			} else { 
			//IF Tutor is selectd
			echo 'Not coded yet';
			}
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
			    <option value='Student'>Student</option>
                <option value='Tutor'>Tutor</option>
            </select> <br> <br>

            <button type='submit' name='submit'>Login</button> <br>
            <?php if ( $error ) { echo $error; }  ?>  
			<?php if ( $password_error ) { echo $password_error; }  ?>
			
        </form>
    </div>
</center>
</body>
</html>