<?php
include 'config.php';
?>

<?php
    function calc_average_grade(){
        return NULL;
    }
    function get_user($username, $conn){
		///-- Returns an instance of a given user  --///
		$query = "SELECT * FROM Member WHERE e_mail='$username'";
        $result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);

		// Parse results into associative array so it can be returned on function call.
		$user['groups_id'] = $row['groups_id'];
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
		echo $row['passw'];
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
			echo "Record updated";
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
			echo "Record updated";
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

	//register_student("admin@gre.ac.uk", encrypt_pass("hsalsldld"), "05045465", 2, $conn);
	//get_user("test@gre.ac.uk", $conn);
?>