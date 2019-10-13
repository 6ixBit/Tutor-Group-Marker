<?php
    session_start();                        //Start Session if key,value pair for session has been set 
    if(isset($_SESSION['username'])){           //IF user is logged in/Session 
        include 'templates/loggedIn_nav.html';
    } else {
        include 'templates/nav.html';
        session_destroy();
    }
?>
<html>
<head>
<title> Home </title>
</head>
<body>
<center><h1><u>Tutor Group Marking System</u></h1></center>
<?php
   echo $_SESSION['username'];
?>
</body>
</html>