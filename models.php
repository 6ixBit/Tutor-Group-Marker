<?php
include 'config.php';

function get_group_names(){
    $host = 'mysql.cms.gre.ac.uk';
    $user = 'mn7754c';
    $password = 'mn7754c';
    $db_name = 'mdb_mn7754c';

    $conn = mysqli_connect($host, $user, $passwd, $db_name) or die('Failed to connect to db: %s'.$conn -> error);
    $query = 'SELECT * FROM Groups';
    //$result = mysqli_query($conn, $query);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
}
?>