<?php
include 'local_config.php';

function get_group_names($host, $user, $passwd, $db_name){

    $conn = new mysqli($host, $user, $passwd, $db_name) or die('Failed to connect to db: %s'.$conn -> error);
    $query = 'SELECT * FROM Groups';

    if (mysqli_connect_error()) {
        die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
      }
    
      echo '<h1>Connected successfully.</h1>';
    
      $mysqli->close();
}

get_group_names($host, $user, $passwd, $db_name);
?>