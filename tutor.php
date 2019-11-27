<?php
    session_start();                     //Home page for tutor will consists of rows of groups with a button to view

    include 'templates/tutor_nav.html';  //Group memebers
	include_once 'models.php';
	include_once 'controller.php';

	if(isset($_POST['view_students'])) {
	//-- IF a group is selected then
		$grp_id = abs(get_dropdown_id($_POST['groups']));
		
		$students = get_all_group_members($grp_id);

		echo "<form method='POST' action='tutor.php'><div class='select_user'>

				View a profile:
				<select name='students'>
				";
		foreach($students as $student) {
			echo "<option name='{$student}'>".$student."</option>";
		}
		echo "</select>";
		echo "<input name='view_profile' type='submit'> </div></form>";
	}

	if(isset($_POST['view_profile'])) {
	//-- IF tutor select a profile to view
		$_SESSION['user_profile'] = $_POST['students'];
		echo $_SESSION['user_profile'];
		header( 'Location: profile.php' );
	}

?>



<html>
<head>
    <title>Tutor Evaluations</title>
    <script type='text/javascript' src='app.js'></script>
</head>

<body>
<center><h1>Student Groups</h1></center> <br> 
<!-- For loop to loop over results gather from groups in database -->
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col"><strong style='color:red;'><u>Group name</u></strong></th>
      <th scope="col"><strong style='color:red;'><u>No. of Users</u></strong></th>
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

<div class="select-group-user">
<form method="POST" action='tutor.php'> <!-- Dependent on input, redirect user to profile page and fill with user info based on selected item from form-->

	Select a group:
		<select name="groups" onchange="" class="select-group">  <!-- Make JS database call on change of value -->
			<?php 
			$conn = mysqli_connect($host, $user, $password, $db_name);
			$groups = get_all_groups($conn);
			
			foreach ($groups as $group){ ?>
				<option value="<?php echo $group; ?>"> <?php echo $group; ?> </option>
			<?php } ?>
		</select>
		<button type="submit" name="view_students">Show students </button><br>

</form>
</div>

</body>
</html>

<style>
	.select-group-user {
		position: absolute;
		left: 20%;
	}
	.select_user {
		position: absolute;
		left: 43%;
		bottom: 1%;
	}
</style>

