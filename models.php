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

?>