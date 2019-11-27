<?php
      session_start();                    
      include 'templates/tutor_nav.html';  
      
	  include 'config.php';
	  include_once 'models.php';
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
<p>Overall grade: 5</p> <!-- Sample data replace with database instance -->
</center>

<!-- Cards which host data from peers who have reviewed this user-->
<!-- Nest within for loop and then load db instance -->
<!-- numb of cards = numb of users who have reviewed this users -->

<?php
	$reviews = get_all_reviews($_SESSION['user_profile'], $conn);

	if (!reviews['review_image']) {
		//-- IF image is NOT found then output different type of card
	} else {
		//-- IF image is found then output default card
		foreach($reviews as $rev){
			echo "<div class='review_card'>
			<h3>Reviews: </h3>
			<div class='card' style='width: 22rem;'>
				<img class='card-img-top' src=data:image;base64,"."{$rev['review_image']} alt='Card image cap' style='height: 150px;'>

				<div class='card-body'>
					<h5 class='card-title'><u>Reviewed by: </u> {$rev['user_reviewed']} </h5>
					<h5><u>Rating: </u> <strong>{$rev['rating']} </strong></h5> <br>
					<p class='card-text'> {$rev['description']} </p>
				</div>
			</div>
		</div>";}
	}


?>

<!--
<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="..." alt="Card image cap" style="height: 150px;>
  <div class="card-body">
    <h5 class="card-title">Student ID: 00054840</h5>
    <p class="card-text">I did not like working with this user because they were always late!</p>
  </div>
</div><br><br>

<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="..." alt="Card image cap" style="height: 150px;>
  <div class="card-body">
    <h5 class="card-title">Student: 00054840</h5>
    <p class="card-text">I did not like working with this user because they were always late!</p>
  </div>
</div><br><br>
-->

<!-- If user did not upload image then:
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Card title</h4>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div>
-->

</body>
</html>