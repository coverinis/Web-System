<!doctype html>

<?php 
require './scripts/pageGeneration.php';

//Get the login message if their is one
//Get the response message if there is one
	if(isset($_POST["loginMessage"])){
		$loginMessage = $_POST["loginMessage"];
	}
	else{
		$loginMessage = "";
	}
?>

<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="/styles/common.css">
</head>

<body>
	<?php echo GenerateHeader(Login, false); ?>
	<div id='loginContent'>
		<form id='loginForm' action='/scripts/validateLogin.php' method='post'>
			<h3 class='customFormLabel'>Username</h3>
			<input class='customFormInput' type='text' name='username' required>
			<h3 class='customFormLabel'>Password</h3>
			<input class='customFormInput' type='password' name='password' required>
			<button class='customFormInput'>Log In</button>
		</form>
		<?php echo $loginMessage; ?>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>