<?php
      session_start();                    
      include_once 'templates/tutor_nav.html';  
      
	  include 'config.php';
	  include_once 'models.php';

	if(isset($_SESSION['username'])){   
		 //IF user is logged in Session proceed to page  
    } else {
		//IF user is not logged in
        header( 'Location: login.php' );
        session_destroy();
    }
?>     

<?php
	$user = get_user($_SESSION['user_profile'], $conn);
?>

<html>
<head>
    <title>Profile: <?php echo $user['e_mail']; ?></title>  
    <style>
        .card{
            left: 2%;}
    </style>
</head>

<body>

<center>
<h1><i><?php echo $user['e_mail']; ?> Student Profile</i></h1> <br>
<p>Student ID: <?php echo $user['uid']; ?> </p>     
<p> Group: <?php echo $user['groups_id']; ?> </p>
<p>Overall grade: <?php echo calc_average_grade($user['e_mail'], $conn) ?></p> 
</center>

<?php
	$reviews = get_all_reviews($_SESSION['user_profile'], $conn);

	if (!reviews['review_image']) {
		//-- IF image is NOT found then output different type of card
		foreach($reviews as $rev){

			echo "<div class='review_card'>
			<div class='card' style='width: 21rem;'>
				
				<div class='card-body'>
					<h5 class='card-title'><u>Reviewed by: </u> {$rev['review_by']} </h5>
					<h5><u>Rating: </u> <strong>{$rev['rating']} </strong></h5> <br>
					<p class='card-text'> {$rev['description']} </p>
				</div>
			</div>
		</div><br>";}
	} else {
		//-- IF image is found then output default card
		foreach($reviews as $rev){

			echo "<div class='review_card'>
			<div class='card' style='width: 22rem;'>
				<img class='card-img-top' src=data:image;base64,"."{$rev['review_image']} alt='Card image cap' style='height: 150px;'>

				<div class='card-body'>
					<h5 class='card-title'><u>Reviewed by: </u> {$rev['review_by']} </h5>
					<h5><u>Rating: </u> <strong>{$rev['rating']} </strong></h5> <br>
					<p class='card-text'> {$rev['description']} </p>
				</div>
			</div>
		</div><br>";}
	}
?>

</body>
</html>