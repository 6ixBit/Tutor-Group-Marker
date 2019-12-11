<?php
    include 'templates/loggedIn_nav.html';

	include 'config.php';
    include_once 'models.php'; 
	include_once 'controller.php';
	
    session_start();  

	  if(isset($_SESSION['username'])){   
		 //IF user is logged in Session  
    } else {
		//IF user is not logged in
        header( 'Location: login.php' );
        session_destroy();
    }

	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
?>

<?php
    //- Grab user from session to make db queries with.
	$user = get_user($_SESSION['username'], $conn);  

	if (isset($_POST['save_review'])) {
		$selected_user = $_POST['users_in_group'];

		//-- Load review first to see if it already exists, if it does then prevent the user from inserting another one
		$loaded_review = load_review($user['db_id'], $selected_user, $conn);

		if (!$loaded_review) {
			//-- IF review doesn't exist for user then insert it --//
			insert_temp_review($conn);
			update_group_evaluations($user['groups_id'], $conn);
		} else {
			//-- IF review does exist then throw an error
			$rating_id = $loaded_review['rating_id'];

			update_review($rating_id, $conn);
			$update_success = "Your review has been saved!";
		}
	}

	if (isset($_POST['submit_review'])) {
		//-- IF submit button pressed then update review with final details
		$selected_user = $_POST['users_in_group'];
		$loaded_review = load_review($user['db_id'], $selected_user, $conn);
		$rating_id = $loaded_review['rating_id'];

		finalise_review($rating_id, $conn);
		$finalise_success = "Your review has been finalised and submitted!";

		// Once finalised then update overall grade in member table for user.
		$avg = calc_average_grade($user['e_mail'], $conn);
		set_ovr_grade($user['e_mail'], $avg, $conn);
	}

	if (isset($_POST['load_review'])) {
		$selected_user = $_POST['users_in_group'];    // Grab selected user from drop down list
		
		$loaded_review = load_review($user['db_id'], $selected_user, $conn);

		if (!$loaded_review){
			//-- IF review is NOT found --//
			echo "<div class='alert alert-danger alert-dismissible'>
				 <button type='button' class='close' data-dismiss='alert'>&times;</button>
				 Sorry, but a review from you for the user <strong> {$selected_user} </strong> does not exist! 
				 </div>";
		} else {
			//--IF review for selected user is found --//
			echo "<div class='review_card'>
			<h3>Your Review </h3>
			<div class='card' style='width: 20rem;'>
				<img class='card-img-top' src=data:image;base64,"."{$loaded_review['image']} alt='Card image cap' style='height: 150px;'>

				<div class='card-body'>
					<h5 class='card-title'><u>Email:</u> {$loaded_review['user_reviewed']} </h5>
					<h5><u>Rating:</u> <strong>{$loaded_review['rating']} </strong></h5> <br>
					<p class='card-text'> {$loaded_review['description']} </p>
				</div>
	
				<div class='btn btn-danger'>
					<form action='peer_review.php' method='POST'>
						<button name='delete_review' type='submit' class='btn btn-danger'>Delete review</button>
				    </form>
				</div>
			</div>
		</div>";
		}
	}
?>

<html>
    <head>
        <title>Student peer reviews</title>
    </head>

    <body>
       <div class='user_peer'>
        
		<?php echo "<h1 class='group_title'>Your Group: ".$user['groups_id']."</h1>"; ?>

            <form action='peer_review.php' method='POST' enctype="multipart/form-data">

			<div class='select_user'>
				Select a peer to review:
				<select name="users_in_group">
				<?php 
				$group_members = get_group_members($user['e_mail'], $user['groups_id'], $conn);

				foreach($group_members as $member){ ?>
					<option name='member' value='<?php echo $member; ?>'> <?php echo $member;?> </option>
				<?php } ?>
				</select>
            </div>

       <fieldset> 
            <label for="review_Text" class='review_label'> Enter your review:</label>
                   
            <textarea id="review_Text" class='reviewText' name='peer_text' placeholder='Enter a review for your peer' rows="7" cols='48'></textarea>
            <br>

			<div class="image_upload_form">
                <label for="Upload_image">Upload an image:</label>
                <input type="file" id="Upload_image" name='img_form'>	
            </div> <br> <br>

        </fieldset>

        <div class='rating'>
            Rating: <select name='user_rating'>
                <option  value='0'>0</option>
                <option  value='1'>1</option>
                <option  value='2'>2</option>
                <option  value='3'>3</option>
				<option  value='4'>4</option>
				<option  value='5'>5</option>
				<option  value='6'>6</option>
				<option  value='7'>7</option>
				<option  value='8'>8</option>
				<option  value='9'>9</option>
				<option  value='10'>10</option>

            </select>
        </div>

			<button name='load_review' class='load_review'>Load selected user</button>
			<button type='submit' name='save_review' class='save_button' disabled>Save temporarily</button> 
			<button type='submit' name='submit_review' class='finalise_button'>Submit for marking</button> 
			<?php if ( $update_success ) { echo "<p class='insert_error' style='color:green;'><strong>".$update_success."</strong></p>"; }  ?>
			<?php if ( $finalise_success ) { echo "<p class='insert_error' style='color:green;'><strong>".$finalise_success."</strong></p>"; }  ?>
         </form>
       </div>

    </body>


<?php 

if (isset($_POST['delete_review'])) { // FIX NEEDED
		//$select_user = $_POST['users_in_group']; //line throwing error
		// IF user deletes review
		//delete_review($user['db_id'], $selected_user, $conn);

		//Delete review
		$user = get_user($_SESSION['username'], $conn);
		echo $user['db_id'];
		$selected = $_POST['users_in_group'];
		echo $selected;
		//delete_review($user['db_id'], $conn);
	
	}
?>

	 <style>  
					.reviewText {
                    position: absolute;
                    left: 43%;
                    top: 10%;
                    width: 20%;}        

                    .review_label {
                    position: absolute;
                    left: 43%;
                    top: 7%;
                    width: 15%;}
                    
                    .upload_img{
                    position: absolute;
                    left: 43%;
                    top: 36%;
                    width: 15%;}
                  
                    .image_upload_form {
                    position: absolute;
                    left: 43%;
                    top: 33%;
                    width: 15%;}
                 
                    .select_user {
                    position: absolute;
                    left: 1%;
                    top: 13%;
                    width: 15%;
                    }
                    
                    .load_review {
                    position: absolute;
                    left: 1%;
                    top: 22%;
                    width: 12%;
                    }

                    .rating {
                    position: absolute;
                    left: 43%;
                    top: 42%;
                    width: 15%;}
                  

                    .save_button {
                    position: absolute;
                    left: 43%;
                    top: 48%;}
                    

                    .finalise_button {
                    position: absolute;
                    left: 53%;
                    top: 48%;}

					.insert_error {
					position: absolute;
                    left: 44%;
                    top: 55%;
					}

					.review_card {
					position: absolute;
                    left: 2%;
					top: 42%;}

					.group_title {
					position: absolute;
                    left: 1%;
                    top: 6%;
					}
     </style>
</html>