<?php
    include 'templates/nav.html';
	include 'config.php';
	include 'models.php';
?>
<html>
<head>
    <title> Register </title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type='text/javascript' src='app.js'>
    </script>
</head>
<body>
<?php
    if (isset ($_POST['submit']) ){                                           // Check if element 'submit' has been pressed

        $user_email = $_POST['email'];
		$user_password = $_POST['password'];
		$user_id = $_POST['user_id'];
		$user_group = $_POST['groups'];

        if ( filter_var($user_email, FILTER_VALIDATE_EMAIL )) {                     // Check if email is valid
            $json_response = file_get_contents( $url );                             // Grab JSON response from Google API
            $result = json_decode( $json_response );
    
            if ( $result->success == 'true') {                                     //If recaptcha was successful
				$group_count = get_group_count($user_group, $conn);

				if ($group_count >= 3){
					$group_error = "Sorry, this group already has 3 members";
				} else {
					$encrypted_pass = encrypt_pass($user_password);
					register_student($user_email, $user_password, $user_id, $user_group, $conn);
					//header( 'Location: login.php' );                               
				}

            } else {
				//Assign an error message to display if Captcha failed
                $captcha_error = 'Captcha failed, Please try again!';
            }
        } else {  
			//Assign an error message to display if email validation failed
            $email_error = 'The email you entered is not valid';
        }
    }
?>

<center>
    <form action='register.php' method='POST'>
        Email Address: <br>
        <input type='text' name='email' placeholder='User Email'><br>
        Password: <br>
        <input type='password' name='password' placeholder='Password'><br>
        ID: <br>
        <input type='text' name='user_id' placeholder='Student/Tutor ID'><br> <br>

        Please select a group:
		<select name="groups">
		<?php 
		$groups = get_all_groups($conn);          // Call function for db results, loop through results and output
		foreach ($groups as $group){ ?>
		  <option value="<?php echo $group; ?>"> <?php echo $group; ?> </option>;
		<?php } ?>
		</select> <br> <br>
 
        <div class="g-recaptcha" data-sitekey="6LdgWL0UAAAAAIh_wr2g1DAjYQpid3nZq18lbsPz" width='25'></div><br>   <!-- API key for reCaptcha --> 
        <button type='submit' name='submit' class='register' onclick=''>Register</button> <br> <br>
        <?php if ( $captcha_error ) { echo $captcha_error; } ?>                
        <?php if ( $email_error ) { echo $email_error; } ?>
		<?php if ( $group_error ) { echo $group_error; } ?>
    </form>
</center>
</body>
</html>