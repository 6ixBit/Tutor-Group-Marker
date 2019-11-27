<?php
    session_start();                     //Home page for tutor will consists of rows of groups with a button to view

    include 'templates/tutor_nav.html';  //Group memebers
	include 'config.php';
	include_once 'models.php';
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
      <th scope="col"><strong style='color:red;'><u>Group name</u></strong></th>
      <th scope="col"><strong style='color:red;'><u>No. of Users<</u></strong></th>
      <th scope="col"><strong style='color:red;'><u>No. of Evaluations</u></strong></th>
      <th scope="col"><strong style='color:red;'><u>Completed?</u></strong></th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>

  <tbody>
	  <?php 
	  $group_data = get_groups_info($conn);

	  foreach ($group_data as $group) {
		echo "<tr class='table-active'>";
			echo "<th scope='row'>".$group['group_name']."</th>";
			echo "<td>".$group['no_of_users']."</td>";
			echo "<td>".$group['no_of_evaluations']."</td>";

			if ($group['no_of_evaluations'] == 6) {
				echo "<td style='color:green;'>Yes</td>";
			} else {
				echo "<td style='color:red;'>No</td>";
			}

			echo "<td><button name='send_results' type='submit' class='btn btn-primary'>Send Results</button></td>";
			echo "<td><button name='send_reminder' type='submit' class='btn btn-primary'>Send Reminder</button></td>";
		echo "</tr>";
	  }
	  ?>
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