<?php
    include 'templates/nav.html';
?>
<html>
<head>
    <title> Register </title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<?php
    function encrypt_pass( $user_pass ){
        $encrypted_pass = password_hash( $user_pass, PASSWORD_DEFAULT );       /// Encrypt password using Bcrypt/Default
    }

    if ( isset ( $_POST[ 'submit' ] ) ) {                                           // Check if element 'submit' has been pressed
    
        $secret_key = "6LdgWL0UAAAAAMt2ygu12pDp037xDa5SqcDdooBJ";
        $response_key = $_POST[ "g-recaptcha-response" ];                     //Link to Cpatcha elment by class name
        $user_ip = $_SERVER[ 'REMOTE_ADDR' ];                                // Provide google with call back ip for user

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$response_key&remoteip=$user_ip";   // URL for API endpoint - {secret:, response:}

        $json_response = file_get_contents( $url );                             // Grab JSON response from Google API
        $result = json_decode( $json_response );

        if ( $result->success == 'true') {                                              //Verify if recaptcha was successful
            echo 'Captcha verified';
            header( 'Location: login.php' );                                  // Redirect user to Login page upon captcha confirmation
    
            $user_email = $_POST[ 'email' ];
            $user_pass = $_POST[ 'password' ];
            encrypt_pass( $user_pass );                                        //Encrypt user password
        } else {
            $captcha_error = 'Captcha failed, Please try again!';
        }
    }
?>

<center>
    <form action='register.php' method='POST'>
        Email Address: <br>
        <input type='text' name='email' placeholder='User Email'><br>
        Password: <br>
        <input type='text' name='password' placeholder='Password'><br>
        ID: <br>
        <input type='text' name='user_id' placeholder='Student/Tutor ID'><br>
        <div class="g-recaptcha" data-sitekey="6LdgWL0UAAAAAIh_wr2g1DAjYQpid3nZq18lbsPz"></div>
        <button type='submit' name='submit'>Login</button> <br> <br>
        <?php if ( $captcha_error ) { echo $captcha_error; } ?>
    </form>
</center>

</body>
</html>