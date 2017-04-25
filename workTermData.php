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

//Get the post information from the page
//work_term id
if(isset($_POST["work_term_id"])){
	$workTermID = $_POST["work_term_id"];
}
else{
	$workTermID = "";
}

//company name
if(isset($_POST["company_name"])){
	if(!empty($_POST["company_name"])){
		$companyName = $_POST["company_name"];
	}
	else{
		$companyName = "";
	}
}
else{
	$companyName = "";
}

//employee type
if(isset($_POST["employee_type"])){
	if(!empty($_POST["employee_type"])){
		$employeeType = $_POST["employee_type"];
	}
	else{
		$employeeType = "";
	}
}
else{
	$employeeType = "";
}

//doh
if(isset($_POST["doh"])){
	if(!empty($_POST["doh"])){
		$doh = $_POST["doh"];
	}
	else{
		$doh = "";
	}
}
else{
	$doh = "";
}

//doh_detail
if(isset($_POST["doh_detail"])){
	if(!empty($_POST["doh_detail"])){
		$doh_detail = $_POST["doh_detail"];
	}
	else{
		$doh_detail = "";
	}
}
else{
	$doh_detail = "";
}

//dot
if(isset($_POST["dot"])){
	if(!empty($_POST["dot"])){
		$dot = $_POST["dot"];
	}
	else{
		$dot = "";
	}
}
else{
	$dot = "";
}

//pay
if(isset($_POST["pay"])){
	if(!empty($_POST["pay"])){
		$pay = $_POST["pay"];
	}
	else{
		$pay = "";
	}
}
else{
	$pay = "";
}

//pay
if(isset($_POST["status"])){
	if(!empty($_POST["status"])){
		$status = $_POST["status"];
	}
	else{
		$status = "";
	}
}
else{
	$status = "";
}

//If employee ID is not set return error message
if(strcmp($workTermID, "") == 0){
	$responseMessage = "Please Select a Work Term.";
}
//Else call bobbys function
else{
	DAL::Init();
	$retStrings = WorkTermMaintenance($workTermID, $employeeID, $employeeType, $companyName, $doh, $doh_detail, $dot, $pay, $status);
	//Build responseMessage
	if(sizeof($retStrings) == 0){
		$responseMessage = "Work Term Maintenance Successful.";
	}
	else{
		foreach($retStrings as $string){
			$responseMessage .= $string . "<br>";
		}
	}
}

//Set up post paramters to go back
$pageType = $_POST["submit_page_type"];
$response = $responseMessage;

/*echo $employeeID;
echo $workTermID;
echo $employeeType;
echo $doh;
echo $doh_detail;
echo $dot;
echo $pay;
echo $status;*/
	
?>

<form id="myForm" action="../maintenance.php" method="post">
    <input type="hidden" name="emp_id" value="<?php echo $employeeID ?>">
	<input type="hidden" name="page_type" value="<?php echo $pageType ?>">
	<input type="hidden" name="response" value="<?php echo $response ?>">
	<input type="hidden" name="form_type" value="<?php echo $employeeType ?>">
	<input type="hidden" name="work_term_id" value="<?php echo $workTermID ?>">
</form>
 
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>