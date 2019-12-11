<?php
include 'templates/nav.html';
include 'config.php';
include 'models.php';
include_once 'controller.php';
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
		$group_id = get_dropdown_id($_POST['groups']);
		$group_name = $_POST['groups'];

		//Check if user id already exists
		$check = check_if_user_exists($user_id, $conn);
		if ($check == 1) {
			//IF user ID already exists
			$exists_error = "<p style='color:red;'>Sorry but that user ID already exists</p> <br>";
		} else {
			//IF user ID does not exist then continue with workflow
			if ( filter_var($user_email, FILTER_VALIDATE_EMAIL )) {                     // Check if email is valid
            $json_response = file_get_contents( $url );                             // Grab JSON response from Google API
            $result = json_decode( $json_response );
    
            if ( $result->success == 'true') {                                     //If recaptcha was successful
				$group_count = get_group_count($group_name, $conn);

				if ($group_count >= 3){
					$group_error = "<p style='color:red;'>Sorry, this group already has 3 members</p>";
				} else {
					// Encrypt user password and submit to database.
					$encrypted_pass = encrypt_pass($user_password);
					register_student($user_email, $encrypted_pass, $user_id, $group_id, $conn);
					update_group_count($group_name, $conn);

					sleep(3);
					header( 'Location: login.php' );                               
				}
            } else {
				//Assign an error message to display if Captcha failed
                $captcha_error = "<p style='color:red;'>Captcha failed, Please try again! </p><br>";
            }
        } else {  
			//Assign an error message to display if email validation failed
            $email_error = "<p style='color:red;'>The email you entered is not valid</p> <br>";
        }
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
		<?php if ( $exists_error ) { echo $exists_error; } ?>

    </form>
</center>
</body>
</html>