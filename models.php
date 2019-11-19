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

	function get_group_count($group_name, $host, $user, $password, $db_name){                              /// Return number of members within a group
		$conn = mysqli_connect($host, $user, $password, $db_name);
		$query = "SELECT no_of_users FROM Groups WHERE group_name='$group_name'"; //group_name must be in single quotes for query to work
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);
		echo $row['no_of_users'];
	}

	function get_evalutions_count($group_name){    /// Returns number of evaluations in a group
		
	}

	function update_group_count($group_name, $host, $user, $password, $db_name){
	
	}

	function update_group_evaluations($group_name, $host, $user, $password, $db_name){
		
	}


    function get_all_groups($host, $user, $password, $db_name){

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

	get_group_count('Group 3', $host, $user, $password, $db_name);
?>