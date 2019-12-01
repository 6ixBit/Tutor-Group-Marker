<?php
    session_start();                     //Home page for tutor will consists of rows of groups with a button to view

	include_once 'models.php';
	include_once 'controller.php';
                      
    if(isset($_SESSION['username'])){   
		 //IF user is logged in Session 
        include 'templates/tutor_nav.html';  
    } else {
		//IF user is not logged in
        header( 'Location: login.php' );
        session_destroy();
    }

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

	if (isset($_POST['send_reminder'])) {
		//--IF tutor chooses to send reminder--//
		$grp_eval = get_evaluations_count($_POST['groups'], $conn);
		
		$students = get_all_group_members(get_dropdown_id($_POST['groups']));

		if ($grp_eval < 6) {
			/// IF group still yet to complet reviews
			foreach($students as $student){
				send_reminder_email($student);
			}
		} elseif ($grp_eval == 6) {
			$reminder_err = "Group has already completed evaluations, send results instead!";
		}
	}

	if (isset($_POST['send_results'])) {
		//--IF tutor chooses to send final results--//
		$grp_eval = get_evaluations_count($_POST['groups'], $conn);

		$students = get_all_group_members(get_dropdown_id($_POST['groups']));

		if ($grp_eval == 6) {
			/// IF group still yet to complet reviews
			foreach($students as $student){
				// Lookup user from group to be passed when emailing students
				$user = get_user($student, $conn);
				$student_id = $user['uid'];
				$final_grade = $user['overall_grade'];

				send_final_results($student, $student_id, $final_grade);
			}
		} else {
			$send_results_error = "This group has not completed its evaluations yet, send a reminder!";
		}
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
<form action='tutor.php' method='POST'>
<table class="table table-hover" name='grp_table' style="width:1000px">
  <thead>
    <tr>
      <th scope="col"><strong style='color:red;'><u>Group name</u></strong></th>
      <th scope="col"><strong style='color:red;'><u>No. of Users</u></strong></th>
      <th scope="col"><strong style='color:red;'><u>No. of Evaluations</u></strong></th>
      <th scope="col"><strong style='color:red;'><u>Completed?</u></strong></th>
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
		echo "</tr>";
	  }
	  ?>
  </tbody>
</table> <br> <br>
</form>

<form method="POST" action='tutor.php'> <!-- Dependent on input, redirect user to profile page and fill with user info based on selected item from form-->

	<label for="final" class='email_lbl'>Email will be sent to selected group: </label>
	<div class='email_buttons' id='email'>
	<button type='submit' class='btn btn-danger' id='final' name='send_results'>Send final results</button>
	<button type='submit' class='btn btn-info' name='send_reminder'>Send reminder</button>
	<?php if ( $reminder_err ) { echo "<p class='insert_error' style='color:red;'><strong>".$reminder_err."</strong></p>"; }  ?>
	<?php if ( $send_results_error ) { echo "<p class='insert_error' style='color:red;'><strong>".$send_results_error."</strong></p>"; }  ?>
	</div>

	<div class="select-group-user">
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
		left: 25%;
	}
	.select_user {
		position: absolute;
		left: 50%;
		bottom: 10%;
	}
	.email_buttons{
		left: 3%;
		position: absolute;
	}
	.email_lbl{
		bottom: 15.5%;
		left: 3%;
		position: absolute;
	}
</style>

