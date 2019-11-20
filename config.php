<?php 
	//Database configuration
	$host = "mysql.cms.gre.ac.uk";
	$user = "mn7754c";
	$password = "root123";
	$db_name = "mdb_mn7754c";
	$conn = mysqli_connect($host, $user, $password, $db_name);

	//ReCaptcha 
	$secret_key = "6LdgWL0UAAAAAMt2ygu12pDp037xDa5SqcDdooBJ";
	$response_key = $_POST["g-recaptcha-response"];                     //Link to Captcha elment by class name
	$user_ip = $_SERVER['REMOTE_ADDR'];                                // Provide google with call back IP for user
    
	 $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$response_key&remoteip=$user_ip";   // URL for API endpoint - {secret:, response:}
?>