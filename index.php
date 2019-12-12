<?php
	include_once 'models.php';

    session_start();                        //Start Session if key,value pair for session has been set 
    if(isset($_SESSION['username'])){           
		//IF user is logged in/Session 
		setcookie('Member_email', $_SESSION[ 'username' ]);

		// Grab user id from database then store in cookie
		$user_l = get_user($_SESSION[ 'username' ], $conn);
		setcookie('Member_ID', $user_l['uid']);
	
		//Show nav template
		include 'templates/loggedIn_nav.html';
    } else {
        include 'templates/nav.html'; 
        session_destroy();
    }
?>
<html>
<head>
<title> Tutor Group Marker </title>
</head>
<body>

<div class="jumbotron">
  <h1 class="display-3">Tutor Marking System </h1> <p>Your Member ID: <?php echo $_COOKIE['Member_ID']; ?> </p>
  <p class="lead">Using this website, you can submit reviews for peers within your group, you can add text and an image to further justify 
  your review, however using an image is optional so it is all up to you. To leave a review for a peer within your group simply click on the Peer Review button in the navigation bar above.</p>
  <hr class="my-4">

  <br>
  <h3>Loading reviews</h3>
  <p>In order to load a review that you may have previously submitted temporarily, use the drop down on the peer review page to load one for that specific user. If found the review
  will load in the left hand corner, if a review for that user by you doesn't currently exist, you will be alerted and prompted to create one for that user.</p> 
  <br>
  <h3 style='color:red;'>Warning</h3>
  <p>Once a review for a user is loaded and you wanted to modify it for final submission, only the text, rating and image that is currently loaded in the review form (Always empty) will be submitted, 
  your old review that may be in view on the left will be discarded. Please double check that you have entered data in the form to get submitted when finalising work or your previous review will be lost.</p>

</div>
</body>
</html>