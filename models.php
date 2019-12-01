<?php
include 'config.php';
include_once 'controller.php';
?>

<?php

    function calc_average_grade($user_email, $conn){
		//-- Calculates average grade for a particular user based on peer rating --//
		$query = "SELECT AVG(verdict) FROM Rating WHERE user_reviewed='$user_email'";
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);

		return intval($row['AVG(verdict)']);
    }

    function get_user($username, $conn){
		///-- Returns an instance of a given user  --///
		$query = "SELECT * FROM Member WHERE e_mail='$username'";
        $result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);

		// Parse results into associative array so it can be returned on function call.
		$user['groups_id'] = $row['Groups_id'];
		$user['db_id'] = $row['Member_id'];
		$user['e_mail'] = $row['e_mail'];
		$user['uid'] = $row['uid'];
		$user['role'] = $row['role'];
		$user['overall_grade'] = $row['overall_grade'];

		return $user;
    }

	function get_user_passw($username, $conn){
		///-- Returns the password of a given user. Called upon user login. --/// 
		$query = "SELECT passw FROM Member WHERE e_mail='$username'";
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);
		return $row['passw'];
	}

	function register_student($username, $user_passw, $user_id, $group_id, $conn){
		///-- Inserts $username, $user_id, $user_passw into database using PDO to avoid SQL Injection --/// 
		$query = "INSERT INTO Member (e_mail, passw, uid, groups_id, role, overall_grade) VALUES (?, ?, ?, ?, ?, ?);";
		$stmt = mysqli_stmt_init($conn);

		$role = "Student";
		$initial_grade = 0;

		if (!mysqli_stmt_prepare($stmt, $query)) {
			// Check for errors first
			echo "SQL Insert failed";
		} else {
			// Bind placeholders to parameters passed
			mysqli_stmt_bind_param($stmt, "sssisi", $username, $user_passw, $user_id, $group_id, $role, $initial_grade);
			mysqli_stmt_execute($stmt);
			echo "Query executed successfully";
		}
	}

	function get_group_count($group_name, $conn){   
		///-- Return number of members within a group --///
		$query = "SELECT no_of_users FROM Groups WHERE group_name='$group_name'"; 
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);
		
		return $row['no_of_users'];
	}

	function get_group_members($user_email, $group_id, $conn){
		///-- Returns e-mails of users who are in the same group --//
		///-- $user = username of user requesting group members
		///-- $group_id = group to be checked

		$query = "SELECT e_mail FROM Member WHERE groups_id = '$group_id' AND NOT e_mail = '$user_email'";
		$result = mysqli_query($conn, $query);

		$group_members = array();

		if (!mysqli_num_rows($result) > 0) {
			echo "No results found!";
		} else {
			while($row = mysqli_fetch_assoc($result)){
				array_push($group_members, $row['e_mail']);
			}
		}
		return $group_members;
	}

	function get_all_group_members(int $group_id){
		//-- Returns the members of a group passed as a param --//
		$host = "mysql.cms.gre.ac.uk";
		$user = "mn7754c";
		$password = "root123";
		$db_name = "mdb_mn7754c";

		$conn = mysqli_connect($host, $user, $password, $db_name);

		$query = "SELECT e_mail from Member WHERE groups_id= '$group_id'";
		$result = mysqli_query($conn, $query);

		$group_members = array();

		if (!mysqli_num_rows($result) > 0) {
			echo mysqli_error($conn);
		} else {
			while($row = mysqli_fetch_assoc($result)){
				array_push($group_members, $row['e_mail']);
			}
		}
		return $group_members;
	}

	function get_evaluations_count($group_name, $conn){ 
		///-- Returns number of evaluations in a group --///
		$query = "SELECT no_of_evaluations FROM Groups WHERE group_name='$group_name'";
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);
		return $row['no_of_evaluations'];
	}

	function update_group_count($group_name, $conn){
		///-- Increments count of memebers in a group --///
		$current_group_count = get_group_count($group_name, $conn);
		$updated_group_count = $current_group_count + 1;

		$query = "UPDATE Groups SET no_of_users=$updated_group_count WHERE group_name='$group_name'";

		if (mysqli_query($conn, $query) ){
			//echo "Record updated";
		} else {
			echo "Failed: ". mysqli_error($conn);
		}
	}

	function update_group_evaluations($group_name, $conn){
		///-- Increments count of memebers in a group --///
		$current_eval_count = get_evaluations_count($group_name, $conn);
		$updated_eval_count = $current_eval_count + 1;

		$query = "UPDATE Groups SET no_of_evaluations=$updated_eval_count WHERE group_name='$group_name'";

		if (mysqli_query($conn, $query) ){
			//echo "Record updated";
		} else {
			echo "Failed: ". mysqli_error($conn);
		}
	}

    function get_all_groups($conn){
		///-- Returns names of all groups --///
		$query = 'SELECT * FROM Groups';
		$result = mysqli_query($conn, $query);

		$value = array();

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				array_push($value, $row["group_name"]);        //Add results to array to be used when function is called
			}
		} else {
			echo "No results";
		}
		mysqli_close($conn);

		return $value;
	}

	function get_groups_info($conn){
		///-- Returns names, no of users and evaluations of all groups --///
		$query = 'SELECT * FROM Groups';
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){

				$res[] = array(
				"group_name" => $row["group_name"],
				"no_of_users" => $row["no_of_users"],
				"no_of_evaluations" => $row['no_of_evaluations'],
                 );
			}
		} else {
			echo "No results";
		}
		mysqli_close($conn);

		return $res;
	}

	function get_all_reviews($username, $conn){
		//-- Returns the reviews for $username passed --//
		$query = "SELECT description, verdict, review_image, user_reviewed FROM Rating WHERE user_reviewed='$username'";

		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){

				$res[] = array(
				"description" => $row["description"],
				"rating" => $row["verdict"],
				"user_reviewed" => $row['user_reviewed'],
				"review_image" => $row['review_image'],
				"review_by" => $row['Member_id']
                 );
			}
		} else {
			echo "No reviews for this user found!";
		}
		mysqli_close($conn);

		return $res;
	}

	function set_ovr_grade($user_email, $avg_grade, $conn) {
		//-- Write overall grade for student once grade has been finalised --//
		$query = "UPDATE Member SET overall_grade='$avg_grade' WHERE e_mail='$user_email'";

		if (mysqli_query($conn, $query) ){
			echo "Overall grade updated";
		} else {
			echo "Failed: ". mysqli_error($conn);
		}
	}

	function login_student($username, $form_password, $conn){
		//-- Returns true if hashed password matches form data --//
		$student_passw = get_user_passw($username, $conn);

		if (decrypt_pass($form_password, $student_passw)) {
	        return TRUE;	
		} else {
			return FALSE;
		}
	}

	function login_tutor($username, $password, $conn){
		///-- Return True if user id & login matches --///
		$query = "SELECT * FROM Tutor WHERE uid_='$username' AND password_='$password'";
		$result = mysqli_query($conn, $query);
		
		if (mysqli_num_rows($result) == 0) {
			//echo "Login failed";
			return FALSE;
		} else {
			//echo "Login successful";
			return TRUE;
		}
	}

	function insert_temp_review($conn) {
		//-- Insert peer review into database --//
		$current_user = get_user($_SESSION['username'], $conn);

		//-- Parsing data to be inserted --//
		$current_user_id = intval($current_user['db_id']);
		$group_id = intval($current_user['groups_id']);
		$user_rating = intval($_POST['user_rating']);
		$review_text = $_POST['peer_text'];
		$user_reviewed = $_POST['users_in_group'];
		$img = convert_image();
		$finalised = 0;

		$query = "INSERT INTO Rating (Groups_id, Member_id, verdict, description, review_image, user_reviewed, finalised) VALUES
		('$group_id', '$current_user_id', '$user_rating', '$review_text', '$img', '$user_reviewed', '$finalised')";

		$result = mysqli_query($conn, $query);

		if (!mysqli_query($result)) {
			echo mysqli_error($conn);
		} else {
			echo "Insert completed succesfully";
		}
	}

	function load_review($user_id, $peer_email, $conn){
		//-- Loads review for user based on value in drop down list (Consits of group memebrers) --//
		// $user_id : Currently signed in user who made review
		// $peer_email : Email address of user being reviewed 

		$query = "SELECT description, verdict, review_image, user_reviewed, Rating_id FROM Rating WHERE Member_id=$user_id AND user_reviewed='$peer_email'";

		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);

		$review_info['description'] = $row['description'];
		$review_info['rating'] = $row['verdict'];
		$review_info['image'] = $row['review_image'];
		$review_info['user_reviewed'] = $row['user_reviewed'];
		$review_info['rating_id'] = $row['Rating_id'];

		if (!$result){
			return False;
		} else {
			return $review_info;
		}
	}

	function update_review($rating_id, $conn){
		//-- Update peer review from database --//
		$current_user = get_user($_SESSION['username'], $conn);

		//-- Parsing data to be inserted --//
		$current_user_id = intval($current_user['db_id']);
		$group_id = intval($current_user['groups_id']);
		$user_rating = intval($_POST['user_rating']);
		$review_text = $_POST['peer_text'];
		$user_reviewed = $_POST['users_in_group'];
		$img = convert_image();
		$finalised = 0;

		$query = "REPLACE INTO Rating (Rating_id, Groups_id, Member_id, verdict, description, review_image, user_reviewed, finalised) VALUES
		('$rating_id','$group_id', '$current_user_id', '$user_rating', '$review_text', '$img', '$user_reviewed', '$finalised')";

		$result = mysqli_query($conn, $query);

		if (!mysqli_query($result)) {
			echo mysqli_error($conn);
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function finalise_review($rating_id, $conn){
		//-- Will UPDATE review if it already exists or INSERT if it doesn't and set finalised to 1 
		$current_user = get_user($_SESSION['username'], $conn);

		//-- Parsing data to be inserted --//
		$current_user_id = intval($current_user['db_id']);
		$group_id = intval($current_user['groups_id']);
		$user_rating = intval($_POST['user_rating']);
		$review_text = $_POST['peer_text'];
		$user_reviewed = $_POST['users_in_group'];
		$img = convert_image();
		$finalised = 1;

		$query = "REPLACE INTO Rating (Rating_id, Groups_id, Member_id, verdict, description, review_image, user_reviewed, finalised) VALUES
		('$rating_id','$group_id', '$current_user_id', '$user_rating', '$review_text', '$img', '$user_reviewed', '$finalised')";

		$result = mysqli_query($conn, $query);

		if (!mysqli_query($result)) {
			echo mysqli_error($conn);
		} else {
			echo "Review finalised succesfully";
		}
	}

	 //-- FIX NEEDED --//
	function delete_review($user_id, $conn){
		//-- Will delete review for selected user in drop down if it exists, if it doesn't then will return null --//
		$user_reviewed = $_POST['users_in_group'];

		$query = "DELETE FROM Rating WHERE Member_id={$user_id} AND user_reviewed='$user_reviewed'";

		$result = mysqli_query($conn, $query);

		if (!mysqli_query($conn, $query)) {
			echo mysqli_error($conn);
		} else {
			echo "Record was deleted successfully";
			echo $user_reviewed;
		}
	}
	 //-- FIX NEEDED --//
	function del_review($conn) {
		//-- Insert peer review into database --//
		$current_user = get_user($_SESSION['username'], $conn);

		//-- Parsing data to be inserted --//
		$current_user_id = intval($current_user['db_id']);
		$user_reviewed = $_POST['users_in_group'];

		$query = "DELETE FROM Rating WHERE Member_id={$current_user_id} AND user_reviewed='$user_reviewed'";

		$result = mysqli_query($conn, $query);

		if (!mysqli_query($conn, $query)) {
			echo mysqli_error($conn);
		} else {
			echo $user_reviewed;
			echo "delete completed succesfully";
		}
	}

	function search_by_grade_less($res_per_page, $grade, $conn){
		//-- Returns students who scored less than $grade in ASC order (low to high) --//

		if(isset($_GET['page'])) {
		// Check if page number is set from URL query
		$page = $_GET['page'];
		} else {
			// IF page number is not set then default to 1
			$page = 1;
		}

		//Starting point for results 
		// Formula for this was sourced from https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html
		$start_point = ($page-1) * $res_per_page;

		// Query total number of records in original query
		$query_total_records = "SELECT * FROM Member WHERE overall_grade < '$grade' ORDER BY overall_grade ASC";
		$result_2 = mysqli_query($conn, $query_total_records);
	
		//Get number of rows from result
		$numRows = mysqli_num_rows($result_2);

		// Calculate total number of pages - Dividie amnt per page by numb of records
		$totalpages = $numRows / $res_per_page;

		// Get total number of records
		$query = "SELECT * FROM Member WHERE overall_grade < '$grade' ORDER BY overall_grade ASC LIMIT $start_point, $res_per_page";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				// Loop results and append values to assoc array
				$res[] = array(
				"e_mail" => $row["e_mail"],
				"uid" => $row["uid"],
				"overall_grade" => $row['overall_grade'],
				"groups_id" => $row['Groups_id'],
                 );
			}
		} else {
			echo "No results";
		}
		mysqli_close($conn);

		return $res;
	}

	function search_by_grade_less_high_to_low($res_per_page, $grade, $conn){
		//-- Returns students who scored less than $grade in DESC order (high to low) --//
		if(isset($_GET['page'])) {
		// Check if page number is set from URL query
		$page = $_GET['page'];
		} else {
			// IF page number is not set then default to 1
			$page = 1;
		}

		//Starting point for results
		// Formula for this was sourced from https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html
		$start_point = ($page-1) * $res_per_page;

		// Query total number of records in original query
		$query_total_records = "SELECT * FROM Member WHERE overall_grade < '$grade' ORDER BY overall_grade DESC";
		$result_2 = mysqli_query($conn, $query_total_records);
	
		//Get number of rows from result
		$numRows = mysqli_num_rows($result_2);

		// Calculate total number of pages - Dividie amnt per page by numb of records
		$totalpages = $numRows / $res_per_page;

		// Get total number of records
		$query = "SELECT * FROM Member WHERE overall_grade < '$grade' ORDER BY overall_grade DESC LIMIT $start_point, $res_per_page";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				// Loop results and append values to assoc array
				$res[] = array(
				"e_mail" => $row["e_mail"],
				"uid" => $row["uid"],
				"overall_grade" => $row['overall_grade'],
				"groups_id" => $row['Groups_id'],
                 );
			}
		} else {
			echo "No results";
		}
		mysqli_close($conn);

		return $res;
	}

	function search_by_grade_greater($res_per_page, $grade, $conn){
		//-- Returns students who scored higher than $grade in ASC order (low to high) --//

		if(isset($_GET['page'])) {
		// Check if page number is set from URL query
		$page = $_GET['page'];
		} else {
			// IF page number is not set then default to 1
			$page = 1;
		}

		//Starting point for results
		// Formula for this was sourced from https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html
		$start_point = ($page-1) * $res_per_page;

		// Query total number of records in original query
		$query_total_records = "SELECT * FROM Member WHERE overall_grade > '$grade' ORDER BY overall_grade ASC";
		$result_2 = mysqli_query($conn, $query_total_records);
	
		//Get number of rows from result
		$numRows = mysqli_num_rows($result_2);

		// Calculate total number of pages - Dividie amnt per page by numb of records
		$totalpages = $numRows / $res_per_page;

		// Get total number of records
		$query = "SELECT * FROM Member WHERE overall_grade > '$grade' ORDER BY overall_grade ASC LIMIT $start_point, $res_per_page";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				// Loop results and append values to assoc array
				$res[] = array(
				"e_mail" => $row["e_mail"],
				"uid" => $row["uid"],
				"overall_grade" => $row['overall_grade'],
				"groups_id" => $row['Groups_id'],
                 );
			}
		} else {
			echo "No results";
		}
		mysqli_close($conn);

		return $res;
	}

	function search_by_grade_greater_high_to_low($res_per_page, $grade, $conn){
		//-- Returns students who scored higher than $grade in DESC order (high to low) --//
		if(isset($_GET['page'])) {
		// Check if page number is set from URL query
		$page = $_GET['page'];
		} else {
			// IF page number is not set then default to 1
			$page = 1;
		}

		//Starting point for results
		// Formula for this was sourced from https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html
		$start_point = ($page-1) * $res_per_page;

		// Query total number of records in original query
		$query_total_records = "SELECT * FROM Member WHERE overall_grade > '$grade' ORDER BY overall_grade DESC";
		$result_2 = mysqli_query($conn, $query_total_records);
	
		//Get number of rows from result
		$numRows = mysqli_num_rows($result_2);

		// Calculate total number of pages - Dividie amnt per page by numb of records
		$totalpages = $numRows / $res_per_page;

		// Get total number of records
		$query = "SELECT * FROM Member WHERE overall_grade > '$grade' ORDER BY overall_grade DESC LIMIT $start_point, $res_per_page";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				// Loop results and append values to assoc array
				$res[] = array(
				"e_mail" => $row["e_mail"],
				"uid" => $row["uid"],
				"overall_grade" => $row['overall_grade'],
				"groups_id" => $row['Groups_id'],
                 );
			}
		} else {
			echo "No results";
		}
		mysqli_close($conn);

		return $res;
	}

	function search_all_students($res_per_page, $conn){
		//-- Returns all students reigstered in paginated format, based on $res_per_page --//

		if(isset($_GET['page'])) {
		// Check if page number is set from URL query
		$page = $_GET['page'];
		} else {
			// IF page number is not set then default to 1
			$page = 1;
		}

		//Starting point for results
		// Formula for this was sourced from https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html
		$start_point = ($page-1) * $res_per_page;

		// Query total number of records in original query
		$query_total_records = "SELECT * FROM Member";
		$result_2 = mysqli_query($conn, $query_total_records);
	
		//Get number of rows from result
		$numRows = mysqli_num_rows($result_2);

		// Calculate total number of pages - Dividie amnt per page by numb of records
		$totalpages = $numRows / $res_per_page;

		// Get total number of records
		$query = "SELECT * FROM Member LIMIT $start_point, $res_per_page";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				// Loop results and append values to assoc array
				$res[] = array(
				"e_mail" => $row["e_mail"],
				"uid" => $row["uid"],
				"overall_grade" => $row['overall_grade'],
				"groups_id" => $row['Groups_id'],
                 );
			}
		} else {
			echo "No results";
		}
		mysqli_close($conn);

		return $res;
	}

	function search_id_by_sub_string($subString, $res_per_page, $conn) {
		//-- Returns results that match searched ID by sub string --//
		if(isset($_GET['page'])) {
		// Check if page number is set from URL query
		$page = $_GET['page'];
		} else {
			// IF page number is not set then default to 1
			$page = 1;
		}

		//Starting point for results
		// Formula for this was sourced from https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html
		$start_point = ($page-1) * $res_per_page;

		// Query total number of records in original query
		$query_total_records = "SELECT * FROM Member WHERE uid LIKE '%$subString%'";
		$result_2 = mysqli_query($conn, $query_total_records);
	
		//Get number of rows from result
		$numRows = mysqli_num_rows($result_2);

		// Calculate total number of pages - Dividie amnt per page by numb of records
		$totalpages = $numRows / $res_per_page;

		// Get total number of records
		$query = "SELECT * FROM Member WHERE uid LIKE '%$subString%' LIMIT $start_point, $res_per_page";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				// Loop results and append values to assoc array
				$res[] = array(
				"e_mail" => $row["e_mail"],
				"uid" => $row["uid"],
				"overall_grade" => $row['overall_grade'],
				"groups_id" => $row['Groups_id'],
                 );
			}
		} else {
			echo "No results";
		}
		mysqli_close($conn);

		return $res;
	}
	
	//register_student("admin@gre.ac.uk", encrypt_pass("hsalsldld"), "05045465", 2, $conn);
	//$res = search_id_by_sub_string('094', 2, $conn);
	//foreach($res as $s) {
		//echo "<tr><td>".$s['e_mail']."</td></tr><br>";
	//	print_r($s);
	//}
	
?>