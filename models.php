<?php
include 'config.php';

$conn = mysqli_connect($host, $user, $password, $db_name);

$query = 'SELECT * FROM Tutor';
$result = mysqli_query($conn, $query);
echo mysqli_num_rows($result);

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
