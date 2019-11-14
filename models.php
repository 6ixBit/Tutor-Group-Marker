<?php
$host = "mysql.cms.gre.ac.uk";
$user = "mn7754c";
$password = "root123";
$db_name = "mdb_mn7754c";

$conn = mysqli_connect($host, $user, $passwd) or die('Failed: '.mysqli_connect_error);

$query = 'SELECT * FROM Groups';
$result = mysqli_query($conn, $query)
?>

<?php
    function calc_average_grade(){
        return NULL;
    }

    function get_user(){
        return NULL;
    }

?>