<?php 

require './scripts/tools.php';

//Get the post information from the page
//user id
if(isset($_POST["company_id"])){
	$companyID = $_POST["company_id"];
}
else{
	$companyID = "";
}

//first name
if(isset($_POST["companyName"])){
	if(!empty($_POST["companyName"])){
		$companyName = $_POST["companyName"];
	}
	else{
		$companyName = "";
	}
}
else{
	$companyName = "";
}

//If employee ID is not set return error message
if(strcmp($companyID, "") == 0){
	$responseMessage = "Please Select a Company.";
}
//Else call bobbys function
else{
	DAL::Init();
	$retStrings = companyMaintenance($companyID, $companyName);
	//Build responseMessage
	if(sizeof($retStrings) == 0){
		$responseMessage = "Maintenance on " . $companyName . " was successful.";
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

/*echo $companyID;
echo $companyName;*/
	
?>

<form id="myForm" action="../admin.php" method="post">
    <input type="hidden" name="company_id" value="<?php echo $companyID; ?>">
	<input type="hidden" name="page_type" value="<?php echo $pageType; ?>">
	<input type="hidden" name="response" value="<?php echo $response; ?>">
</form>
 
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>