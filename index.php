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

<div class="jumbotron">
  <h1 class="display-3">Tutor Group Marking System</h1>
  <p class="lead">As a student it is integral that you complete your work on time. </p>
  <hr class="my-4">
  <p>It uses spacing to space content out within the larger container.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="#" role="button">Test</a>
  </p>
</div>


</body>
</html>