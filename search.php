<!doctype html>

<?php require 'pageGeneration.php' ?>

<html lang="en">
<head>

	<style>
		
	</style>
<link rel="stylesheet" type="text/css" href="common.css">
</head>

<body>
	<?php echo GenerateHeader(EmpSearch); ?>
	<div id='searchContent'>
		<form>
			<h3 class='customFormLabel'>Search By</h3>
			<select class='customFormInput'>
				<option value="FirstName">First Name</option>
				<option value="LastName">Last Name</option>
				<option value="SIN">Social Insurance Number</option>
			</select>
			<input class="customFormInput" type='text'>
			<button class='customFormInput'>Search</button>
		</form>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>