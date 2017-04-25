<?php 

require './scripts/tools.php';

//Get the post information from the page
//user id
if(isset($_POST["user_id"])){
	$userID = $_POST["user_id"];
}
else{
	$userID = "";
}

//user name
if(isset($_POST["username"])){
	if(!empty($_POST["username"])){
		$userName = $_POST["username"];
	}
	else{
		$userName = "";
	}
}
else{
	$userName = "";
}

//password
if(isset($_POST["password"])){
	if(!empty($_POST["password"])){
		$password = $_POST["password"];
	}
	else{
		$password = "";
	}
}
else{
	$password = "";
}

//user_type
if(isset($_POST["user_type"])){
	if(!empty($_POST["user_type"])){
		$userType = $_POST["user_type"];
	}
	else{
		$userType = "";
	}
}
else{
	$userType = "";
}

//If employee ID is not set return error message
if(strcmp($userID, "") == 0){
	$responseMessage = "Please Select a User.";
}
//Else call bobbys function
/*else{
	DAL::Init();
	$retStrings = WorkTermMaintenance($workTermID, $employeeID, $employeeType, $companyName, $doh, $doh_detail, $dot, $pay, $status);
	//Build responseMessage
	if(sizeof($retStrings) == 0){
		$responseMessage = $workTermID . " was successfully added.";
	}
	else{
		foreach($retStrings as $string){
			$responseMessage = $string . "<br>";
		}
	}
}*/

//Set up post paramters to go back
$pageType = $_POST["submit_page_type"];
$response = $responseMessage;

echo $userID;
echo $userName;
echo $password;
echo $userType;
	
?>

<form id="myForm" action="../admin.php" method="post">
    <input type="hidden" name="user_id" value="<?php echo $employeeID ?>">
	<input type="hidden" name="page_type" value="<?php echo $pageType ?>">
	<input type="hidden" name="response" value="<?php echo $response ?>">
</form>
 
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>