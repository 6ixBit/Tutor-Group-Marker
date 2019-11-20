<?php
include 'config.php';
?>

<?php
    function calc_average_grade(){
        return NULL;
    }
    function get_user(){
        return NULL;
    }

	function get_group_count($group_name, $host, $user, $password, $db_name){   
		///-- Return number of members within a group --///
		$conn = mysqli_connect($host, $user, $password, $db_name);
		$query = "SELECT no_of_users FROM Groups WHERE group_name='$group_name'"; 
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);
		return $row['no_of_users'];
	}

	function get_evaluations_count($group_name, $host, $user, $password, $db_name){ 
		///-- Returns number of evaluations in a group --///
		$conn = mysqli_connect($host, $user, $password, $db_name);
		$query = "SELECT no_of_evaluations FROM Groups WHERE group_name='$group_name'";
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);
		return $row['no_of_evaluations'];
	}

	function update_group_count($group_name, $host, $user, $password, $db_name){
		///-- Increments count of memebers in a group --///
		$conn = mysqli_connect($host, $user, $password, $db_name);

		$current_group_count = get_group_count($group_name, $host, $user, $password, $db_name);
		$updated_group_count = $current_group_count + 1;

		$query = "UPDATE Groups SET no_of_users=$updated_group_count WHERE group_name='$group_name'";

		if (mysqli_query($conn, $query) ){
			echo "Record updated";
		} else {
			echo "Failed: ". mysqli_error($conn);
		}
	}

	function update_group_evaluations($group_name, $host, $user, $password, $db_name){
		///-- Increments count of memebers in a group --///
		$conn = mysqli_connect($host, $user, $password, $db_name);

		$current_eval_count = get_evaluations_count($group_name, $host, $user, $password, $db_name);
		$updated_eval_count = $current_eval_count + 1;

		$query = "UPDATE Groups SET no_of_evaluations=$updated_eval_count WHERE group_name='$group_name'";

		if (mysqli_query($conn, $query) ){
			echo "Record updated";
		} else {
			echo "Failed: ". mysqli_error($conn);
		}
	}


    function get_all_groups($host, $user, $password, $db_name){
		///-- Returns names of all groups --///

		$conn = mysqli_connect($host, $user, $password, $db_name);
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

	//update_group_evaluations("Group 1", $host, $user, $password, $db_name);
?>