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
            $username = $_POST[ 'email' ];
            $user_pass = $_POST[ 'password' ];   

			if ($_POST['user_type'] == 'Student'){
				if (login_student($username, $user_pass, $conn)){
					//-- IF login decryption was successful --//
					$_SESSION[ 'username' ] = $username;
					header( 'Location: index.php' );
				} else {
					$password_error = "Wrong username or password entered!";
				}
			} else { 
			//-- IF Tutor is selectd -- //
			if (login_tutor($username, $user_pass, $conn) == FALSE){
				$login_error = 'Wrong username/password entered for Tutor';

			} else {
				$_SESSION[ 'username' ] = $username;
				sleep(1);
				header( 'Location: tutor.php' );
			}
			}
        }
    }
?>
</head>

<body>
<center>
    <div>
        <form action='login.php' method='POST'>
            E-mail/Tutor ID: <br>
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
			<?php if ( $login_error ) { echo $login_error; }  ?>
			
        </form>
    </div>
</center>
</body>
</html>