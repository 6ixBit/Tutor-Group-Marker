<?php
    include 'templates/loggedIn_nav.html';

	include 'config.php';
    include_once 'models.php'; 
	include_once 'controller.php';
	
    session_start();  
?>

<?php
	$user = get_user($_SESSION['username'], $conn);  //-- Grab user from session to make db queries with.

	if (isset($_POST['save_review'])){
		insert_peer_review($conn);
	}

?>

<html>
    <head>
        <title>Student peer reviews</title>
    </head>

    <body>
       <div class='user_peer'>
        
		<?php echo "<h1>Your Group: ".$user['groups_id']."</h1>"; ?>

            <form action='peer_review.php' method='POST'>

			<div class='select_user'>
				Select a peer to review:
				<select name='users_in_group'>
				<?php 
				$group_members = get_group_members($user['e_mail'], $user['groups_id'], $conn);

				foreach($group_members as $member){ ?>
					<option> <?php echo $member;?> </option>
				<?php } ?>

				</select>
            </div>

            <fieldset> 

            <div class="form-group">
                <label for="exampleTextarea" class='review_label'> Enter your review:</label>
                   
                <textarea id="review_Text" name ='peer_text' placeholder='Enter a review for your peer' rows="5" cols='50'></textarea>
            </div><br>

            <div class="image_upload_form">
                <label for="Upload_image">Upload an image:</label>
                <input type="file" id="Upload_image" name='img_form'>
            </div> <br> <br>

            <input type="submit" value="Upload Image" class='upload_img' name="submit">
        </fieldset>

        <div class='rating'>
            Rating: <select name='user_rating'>
                <option  value='0'>0</option>
                <option  value='1'>1</option>
                <option  value='2'>2</option>
                <option  value='3'>3</option>
				<option  value='4'>4</option>
				<option  value='5'>5</option>
				<option  value='5'>6</option>
				<option  value='5'>7</option>
				<option  value='5'>8</option>
				<option  value='5'>9</option>
				<option  value='5'>10</option>

            </select>
        </div>

        <button name='load_review' class='load_review'>Load selected user</button>
        <button type='submit' name='save_review' class='save_button'>Save temporarily</button> 
        <button type='submit' name='submit_review' class='finalise_button'>Submit for marking</button> 
            </form>

       </div>

    </body>

	 <style> #reviewText {
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
                    top: 27%;
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
     </style>
</html>