<?php
    session_start();                     //Home page for tutor will consists of rows of groups with a button to view
    include 'templates/tutor_nav.html';  //Group memebers
?>

<html>
<head>
    <title>Tutor Evaluations</title>
    <script type='text/javascript' src='app.js'></script>
</head>

<body>
<center><h1>Student Groups</h1></center> <br> <br>
<!-- For loop to loop over results gather from groups in database -->
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Group name</th>
      <th scope="col">No. of Group members</th>
      <th scope="col">No. of Evaluations</th>
      <th scope="col">Completed</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr class="table-active">
      <th scope="row"><a href='' onclick=''>Group 1</a></th>
      <td>6</td>
      <td>6</td>
      <td>Yes</td>
      
      <td><button name="send_results" type="submit" class="btn btn-primary">Send Results</button></td>
      <td><button name="send_reminder" type="submit" class="btn btn-primary">Send Reminder</button></td>

    </tr>
  </tbody>
</table> <br> <br>

<form method="POST"> <!-- Dependent on input, redirect user to profile page and fill with user info based on selected item from form-->
<div class="form-group">
    Select a group:
    <select class="select-group" onchange="">
      <option value="1">Group 1</option>
      <option value="2">Group 2</option>
      <option value="3">Group 3</option>
    </select>
  </div>

    Select a student profile from that group:
  <select class="select-student" onchange="">
      <option value="1">Student 1</option>
      <option value="2">Student 2</option>
      <option value="3">Student 3</option>
    </select> <br> <br>
    <button type="submit" name="submit">View profile</button>
  </div>

</form>
</body>
</html>

   <!-- If numb of evals < 6 then show it as red
    <tr class="table-danger">
      <th scope="row">Danger</th>
      <td>Column content</td>
      <td>Column content</td>
    </tr> -->