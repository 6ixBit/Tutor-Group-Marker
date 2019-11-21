<?php
      session_start();                    //Individual profile page which will be accessed by the tutor upon click on a group
      include 'templates/tutor_nav.html';  // and then upon click of user listed in that group
      //Profile page will consist of user id, overall grade for student
      // && Individual grades given by peers in group with image, text & rating 
?>                        

<html>
<head>
    <title>Profile: mn7754c@gre.ac.uk</title>  
    <style>
        .card{
            left: 2%;
        }
    </style>
</head>

<body>
<center>
<h1><i>mn7754c@gre.ac.uk Student Profile</i></h1>
<p>Student ID: 000967991</p>     <!-- Sample data replace with database instance -->
<p>Overall grade: 7</p>
</center>
<!-- Cards which host data from peers who have reviewed this user-->
<!-- Nest within for loop and then load db instance -->
<!-- numb of cards = numb of users who have reviewed this users -->

<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="..." alt="Card image cap" style="height: 150px;>
  <div class="card-body">
    <h5 class="card-title">Student ID: 00054840</h5>
    <p class="card-text">I did not like working with this user because they were always late!</p>
   <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
  </div>
</div><br><br>

<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="..." alt="Card image cap" style="height: 150px;>
  <div class="card-body">
    <h5 class="card-title">Student ID: 00054840</h5>
    <p class="card-text">I did not like working with this user because they were always late!</p>
   <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
  </div>
</div><br><br>

<!-- If user did not upload image then:
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Card title</h4>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div>
-->

</body>
</html>