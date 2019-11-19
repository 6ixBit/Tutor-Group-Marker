<?php
include 'config.php';

$conn = mysqli_connect($host, $user, $password, $db_name);
$query = 'SELECT * FROM Groups';
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)){
		echo $row["group_name"]. "<br>";
	}
} else {
	echo "No results";
}

mysqli_close($conn);

?>

<?php
    function calc_average_grade(){
        return NULL;
    }
    function get_user(){
        return NULL;
    }
    function get_all_groups(){
        return NULL;
    }
?>