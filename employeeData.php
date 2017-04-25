<?php 

require './scripts/tools.php';

//Get the post information from the page
//employee id
if(isset($_POST["employee_id"])){
	$employeeID = $_POST["employee_id"];
}
else{
	$employeeID = "";
}

//fname
if(isset($_POST["fname"])){
	if(!empty($_POST["fname"])){
		$firstName = $_POST["fname"];
	}
	else{
		$firstName = "";
	}
}
else{
	$firstName = "";
}

//lname
if(isset($_POST["lname"])){
	if(!empty($_POST["lname"])){
		$lastName = $_POST["lname"];
	}
	else{
		$lastName = "";
	}
}
else{
	$lastName = "";
}

//sin
if(isset($_POST["sin"])){
	if(!empty($_POST["sin"])){
		$sin = $_POST["sin"];
	}
	else{
		$sin = "";
	}
}
else{
	$sin = "";
}

//dob
if(isset($_POST["dob"])){
	if(!empty($_POST["dob"])){
		$dob = $_POST["dob"];
	}
	else{
		$dob = "";
	}
}
else{
	$dob = "";
}

//If employee ID is not set return error message
if(strcmp($workTermID, "") == 0){
	$responseMessage = "Please Select a Work Term.";
}
//Else call bobbys function
else{
	DAL::Init();
	$retStrings = EmployeeMaintainance($employeeID, $firstName, $lastName, $sin, $dob);
	//Build responseMessage
	if(sizeof($retStrings) == 0){
		$responseMessage = $firstName . " " . $lastName . " was successfully added.";
	}
	else{
		foreach($retStrings as $string){
			$responseMessage = $string . "<br>";
		}
	}
}

//Set up post paramters to go back
$pageType = $_POST["submit_page_type"];
$response = $responseMessage;
	
?>

<form id="myForm" action="../maintenance.php" method="post">
    <input type="hidden" name="emp_id" value="<?php echo $employeeID ?>">
	<input type="hidden" name="page_type" value="<?php echo $pageType ?>">
	<input type="hidden" name="response" value="<?php echo $response ?>">
</form>
 
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>