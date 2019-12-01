<?php
	session_start();                    
    include 'templates/tutor_nav.html'; 
	include 'config.php';
	include 'models.php';

	 // $_SESSION['user_profile']; //
	$full_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
?>

<?php
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

 $tableBottom = "</tr>
  </tbody>
</table>
</center>
<form action='search.php'>
<center>

</center>
</form>";

?>

<?php
	if (isset($_GET['search_btn'])) {
		// IF search button is pressed
		if ($_GET['optionsRadios'] == 'byID') {
			//--IF by ID is selected
			if (empty($_GET['search'])) {
				//IF searched term is empty, return all results //
				$students = search_all_students(3, $conn);
				echo $tableTop;

				foreach($students as $student) {
					echo "<tr class='table-active'>";
					echo "<a href='?prof={$student['e_mail']}'><th scope='row'><a href='' name='user_prof'>".$student['e_mail']."</th></a>";
					echo "<td>".$student['uid']."</td>";
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
?>

<html>
<head>
</head>
<body>

<div>
<fieldset class="form-group">

	<form name="search_" >
      <legend>Search for users</legend>

	  <div class="custom-control custom-switch" class="form-inline my-2 my-lg-0">
		<input type="checkbox" class="custom-control-input" id="customSwitch1" name='sort'>
		<label class="custom-control-label" for="customSwitch1">Sort from high to low</label>
      </div>

        <input class="form-inline my-2 my-lg-0" type="text" placeholder="Search" name="search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit" name='search_btn'>Search</button>

		<div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="optionsRadios" id="byGrade" value="byGrade" checked="">
          Search by grade
        </label>
      </div>

      <div class="form-check">
      <label class="form-check-label">
          <input type="radio" class="form-check-input" name="optionsRadios" id="byID" value="byID">
          Search by ID
        </label>
      </div>
	</form>

</fieldset>
</div>
</body>
</html>

<?php
echo $_GET['sort'];  ///SORT VALUE = ON if high to low is selected, blank if otherwise
echo "<br>";
echo $_GET['optionsRadios']; // either byID or byGrade
echo "<br>";
echo $_GET['search']; //Returns search term
echo "<br>";

if (!$_GET['sort']) {
	echo "Sort from low to high";
	echo "<br>";
} else {
	echo "Sort from high to low";
}

?>
