<?php
	session_start();                    
     include 'templates/tutor_nav.html';  
?>

<html>
<head></head>
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
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>

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

if (!$_GET['sort']) {
	echo "Sort from low to high";
} else {
	echo "Sort from high to low";
}
?>