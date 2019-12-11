<?php
	session_start();                    
    include 'templates/tutor_nav.html'; 
	include 'config.php';
	include 'models.php';

	 // $_SESSION['user_profile']; Pass clicked result to profile page //

	   if(isset($_SESSION['username'])){   
		 //IF user is logged in Session then direct to intended page
    } else {
		//IF user is not logged in
        header( 'Location: login.php' );
        session_destroy();
    }
	
//Store top of table layout to avoid clutter when outputting search results
$tableTop = "<center><table class='table table-hover' name='grp_table' style='width:750px'>
  <thead>
    <tr>
      <th scope='col'><strong style='color:green;'><u>Email</u></strong></th>
      <th scope='col'><strong style='color:green;'><u>User ID</u></strong></th>
      <th scope='col'><strong style='color:green;'><u>Grade</u></strong></th>
      <th scope='col'><strong style='color:green;'><u>Group ID</u></strong></th>
    </tr>
  </thead>

  <tbody>";

//Store bottom of table layout to avoid clutter when outputting search results
 $tableBottom = "</tr>
  </tbody>
</table>
</center>
<form action='search.php'>
</form>";
?>

<?php
	// SEARCH BY ID
	if (isset($_GET['search_btn'])) {
		// IF search button is pressed
		if ($_GET['optionsRadios'] == 'byID') {
			//--IF by ID is selected
			if (empty($_GET['search'])) {
				//IF searched term is empty, return all results //
				$students = search_all_students(3, $conn);

				if ($students) {
					// IF users in database exist, output them
					echo $tableTop;
					foreach($students as $student) {
						echo "<tr class='table-active'>";
						echo "<a href='?prof={$student['e_mail']}'><th scope='row'><a href='' name='user_prof'>".$student['e_mail']."</th></a>";
						echo "<td style='color:blue;'>".$student['uid']."</td>";
						echo "<td>".$student['overall_grade']."</td>";
						echo "<td>".$student['groups_id']."</td>";
						$total = $student['total_pages'];
					}
					echo $tableBottom;
					echo "<center><a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']-1)."' class='btn btn-danger'>PREV</a>";
					echo "<a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']+1)."' class='btn btn-info'>NEXT</a>";
					echo "<p>Total pages: ".$total."</p></center>";
				}
		
			} else {
				// IF search by ID field is not empty then search sub string
				$students = search_id_by_sub_string($_GET['search'], 3, $conn);
				if ($students) {
					//IF results matching query are found
					echo $tableTop;
					foreach($students as $student) {
						echo "<tr class='table-active'>";
						echo "<a href='?prof={$student['e_mail']}'><th scope='row'><a href='' name='user_prof'>".$student['e_mail']."</th></a>";
						echo "<td style='color:blue;'>".$student['uid']."</td>";
						echo "<td>".$student['overall_grade']."</td>";
						echo "<td>".$student['groups_id']."</td>";
						$total = $student['total_pages'];
					}
					echo $tableBottom;
					echo "<center><a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']-1)."' class='btn btn-danger'>PREV</a>";
					echo "<a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']+1)."' class='btn btn-info'>NEXT</a>";
					echo "<p>Total pages: ".$total."</p></center>";
				}
				
			}

		}
	}
?>

<?php
	// SEARCH BY GRADE - Greater than option
	if (isset($_GET['search_btn'])) {
		//IF Search button is pressed
		if ($_GET['optionsRadios'] == 'byGrade') {
			// IF grade option is selected
			//echo $_GET['select_grades']; //Drop down with values
			if ($_GET['filter_grades'] == 'gt' && !$_GET['sort']) {
				// IF Greater than chosen and sort is from low to high (ASC)
				$students = search_by_grade_greater(3, $_GET['select_grades'], $conn);
				if ($students) {
					// IF results found, output them
					echo $tableTop;
					foreach($students as $student) {
						echo "<tr class='table-active'>";
						echo "<a href='?prof={$student['e_mail']}'><th scope='row'><a href='' name='user_prof'>".$student['e_mail']."</th></a>";
						echo "<td>".$student['uid']."</td>";
						echo "<td style='color:blue;'>".$student['overall_grade']."</td>";
						echo "<td>".$student['groups_id']."</td>";
						$total = $student['total_pages'];
					}
					echo $tableBottom;
					echo "<center><a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']-1)."' class='btn btn-danger'>PREV</a>";
					echo "<a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']+1)."' class='btn btn-info'>NEXT</a>";
					echo "<p>Total pages: ".$total."</p></center>";
				}
			} elseif ($_GET['filter_grades'] == 'gt' && $_GET['sort']) {
				// IF Greater than chosen and sort is from high to low (DESC)
				$students = search_by_grade_greater_high_to_low(3, $_GET['select_grades'], $conn);
				if ($students) {
					// IF results found, output them
					echo $tableTop;
					foreach($students as $student) {
						echo "<tr class='table-active'>";
						echo "<a href='?prof={$student['e_mail']}'><th scope='row'><a href='' name='user_prof'>".$student['e_mail']."</th></a>";
						echo "<td>".$student['uid']."</td>";
						echo "<td style='color:blue;'>".$student['overall_grade']."</td>";
						echo "<td>".$student['groups_id']."</td>";
						$total = $student['total_pages'];
					}
					echo $tableBottom;
					echo "<center><a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']-1)."' class='btn btn-danger'>PREV</a>";
					echo "<a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']+1)."' class='btn btn-info'>NEXT</a>";
					echo "<p>Total pages: ".$total."</p></center>";
				}
			}
		}
	}
?>

<?php
	// SEARCH BY GRADE - Less than option
	if (isset($_GET['search_btn'])) {
		//IF Search button is pressed
		if ($_GET['optionsRadios'] == 'byGrade') {
			// IF grade option is selected
			//echo $_GET['select_grades']; //Drop down with values
			if ($_GET['filter_grades'] == 'lt' && !$_GET['sort']) {
				// IF Greater than chosen and sort is from low to high (ASC)
				$students = search_by_grade_less(3, $_GET['select_grades'], $conn);
				if ($students) {
					// IF results found, output them
					echo $tableTop;
					foreach($students as $student) {
						echo "<tr class='table-active'>";
						echo "<a href='?prof={$student['e_mail']}'><th scope='row'><a href='' name='user_prof'>".$student['e_mail']."</th></a>";
						echo "<td>".$student['uid']."</td>";
						echo "<td style='color:blue;'>".$student['overall_grade']."</td>";
						echo "<td>".$student['groups_id']."</td>";
						$total = $student['total_pages'];
					}
					echo $tableBottom;
					echo "<center><a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']-1)."' class='btn btn-danger'>PREV</a>";
					echo "<a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']+1)."' class='btn btn-info'>NEXT</a>";
					echo "<p>Total pages: ".$total."</p></center>";
				}
			} elseif ($_GET['filter_grades'] == 'lt' && $_GET['sort']) {
				// IF Greater than chosen and sort is from high to low (DESC)
				$students = search_by_grade_less_high_to_low(3, $_GET['select_grades'], $conn);
				if ($students) {
					// IF results found, output them
					echo $tableTop;
					foreach($students as $student) {
						echo "<tr class='table-active'>";
						echo "<a href='?prof={$student['e_mail']}'><th scope='row'><a href='' name='user_prof'>".$student['e_mail']."</th></a>";
						echo "<td>".$student['uid']."</td>";
						echo "<td style='color:blue;'>".$student['overall_grade']."</td>";
						echo "<td>".$student['groups_id']."</td>";
						$total = $student['total_pages'];
					}
					echo $tableBottom;
					echo "<center><a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']-1)."' class='btn btn-danger'>PREV</a>";
					echo "<a href='{$_SERVER['REQUEST_URI']}&page=".($_GET['page']+1)."' class='btn btn-info'>NEXT</a>";
					echo "<p>Total pages: ".$total."</p></center>";
				}
			}
		}
	}
?>

<html>
<head>
</head>
<body>

<div class='searching'>
<fieldset class="form-group">

	<form>
      <legend>Search for users</legend><br>

        <input class="form my-2 my-lg-0" type="text" placeholder="Search" name="search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit" name='search_btn'>Search</button><br>

      <div class="form-check form-check-inline">
      <label class="form-check-label">
          <input type="radio" class="form-check-input" name="optionsRadios" id="byID" value="byID" checked="">
          Search by ID
        </label>
      </div>

	  <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="optionsRadios" id="byGrade" value="byGrade" >
          Search by Grade
        </label>
      </div>

	  <div class="form-group" style='width:200px;'>
		<br><select class="custom-select" name='filter_grades'>
			<option selected="Filter grades"value="gt">Greater than</option>
			<option value="lt">Less than</option>
		</select><br>
		</div>

		<div class="form-group" style='width:170px;'>
		<label for="exampleSelect1">Select a grade to filter by</label>
      <select class="form-control" id="exampleSelect1" name='select_grades'>
        <option value=1>1</option>
        <option value=2>2</option>
        <option value=3>3</option>
        <option value=4>4</option>
        <option value=5>5</option>
		<option value=6>6</option>
		<option value=7>7</option>
		<option value=8>8</option>
		<option value=9>9</option>
      </select><br>
	  </div>

	  <div class="custom-control custom-switch" class="form-inline my-2 my-lg-0">
		<input type="checkbox" class="custom-control-input" id="customSwitch1" name='sort'>
		<label class="custom-control-label" for="customSwitch1">Sort from high to low</label>
      </div>
	</form>

</fieldset>
</div>
</body>
</html>
