<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'dal.php';

session_start();

//Get the sent password and name
$sentName = $_POST['username'];
$sentPassword = $_POST['password'];

DAL::Init();

$validCredentials = DAL::ValidateLogin($sentName, $sentPassword);

//Check if the password is the same
if($validCredentials == true){
	//Get the details
	$currentDetails = DAL::GetUserDetails($sentName);
	//Start session variable
	$_SESSION["userID"] = $sentName;
	$_SESSION["userFName"] = $currentDetails["firstName"];
	$_SESSION["userLName"] = $currentDetails["lastName"];
	$_SESSION["userType"] = $currentDetails["userType"];
	header("Location: ../menu.php"); /* Redirect browser */
	exit();
}
else{
	$loginMessage = "Incorrect Password.";
}

?>

<form id="myForm" action="../login.php" method="post">
	<input type="hidden" name="loginMessage" value="<?php echo $loginMessage ?>">
</form>

<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>