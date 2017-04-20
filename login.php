<!doctype html>

<?php require 'pageGeneration.php' ?>

<html lang="en">
<head>

	<style>
		
	</style>
<link rel="stylesheet" type="text/css" href="common.css">
</head>

<body>
	<?php echo GenerateHeader(Login); ?>
	<div id='loginContent'>
		<form>
			<h3 class='customFormLabel'>Username</h3>
			<input class='customFormInput' type='text' name='uname' required>
			<h3 class='customFormLabel'>Password</h3>
			<input class='customFormInput' type='password' name='pass' required>
			<button class='customFormInput'>Log In</button>
		</form>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>