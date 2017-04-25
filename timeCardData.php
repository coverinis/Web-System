<?php 

require './scripts/tools.php';

//Get the post information from the page
//employee id
if(isset($_POST["emp_id"])){
	$employeeID = $_POST["emp_id"];
}
else{
	$employeeID = "";
}

//employee id
if(isset($_POST["work_term_id"])){
	$workTermID = $_POST["work_term_id"];
}
else{
	$workTermID = "";
}

//Get the post information from the page
//week_start
if(isset($_POST["week_start"])){
	$weekStart = $_POST["week_start"];
}
else{
	$weekStart = "";
}

//week_start
if(isset($_POST["form_type"])){
	$formType = $_POST["form_type"];
}
else{
	$formType = "";
}

//monHours
if(isset($_POST["monHours"])){
	if(!empty($_POST["monHours"])){
		$monHours = $_POST["monHours"];
	}
	else{
		$monHours = "";
	}
}
else{
	$monHours = "";
}

//tueHours
if(isset($_POST["tueHours"])){
	if(!empty($_POST["tueHours"])){
		$tueHours = $_POST["tueHours"];
	}
	else{
		$tueHours = "";
	}
}
else{
	$tueHours = "";
}

//wedHours
if(isset($_POST["wedHours"])){
	if(!empty($_POST["wedHours"])){
		$wedHours = $_POST["wedHours"];
	}
	else{
		$wedHours = "";
	}
}
else{
	$wedHours = "";
}

//thuHours
if(isset($_POST["thuHours"])){
	if(!empty($_POST["thuHours"])){
		$thuHours = $_POST["thuHours"];
	}
	else{
		$thuHours = "";
	}
}
else{
	$thuHours = "";
}

//friHours
if(isset($_POST["friHours"])){
	if(!empty($_POST["friHours"])){
		$friHours = $_POST["friHours"];
	}
	else{
		$friHours = "";
	}
}
else{
	$friHours = "";
}

//satHours
if(isset($_POST["satHours"])){
	if(!empty($_POST["satHours"])){
		$satHours = $_POST["satHours"];
	}
	else{
		$satHours = "";
	}
}
else{
	$satHours = "";
}

//sunHours
if(isset($_POST["sunHours"])){
	if(!empty($_POST["sunHours"])){
		$sunHours = $_POST["sunHours"];
	}
	else{
		$sunHours = "";
	}
}
else{
	$sunHours = "";
}

//monPieces
if(isset($_POST["monPieces"])){
	if(!empty($_POST["monPieces"])){
		$monPieces = $_POST["monPieces"];
	}
	else{
		$monPieces = "";
	}
}
else{
	$monPieces = "";
}

//monPieces
if(isset($_POST["monPieces"])){
	if(!empty($_POST["monPieces"])){
		$monPieces = $_POST["monPieces"];
	}
	else{
		$monPieces = "";
	}
}
else{
	$monPieces = "";
}

//tuePieces
if(isset($_POST["tuePieces"])){
	if(!empty($_POST["tuePieces"])){
		$tuePieces = $_POST["tuePieces"];
	}
	else{
		$tuePieces = "";
	}
}
else{
	$tuePieces = "";
}

//wedPieces
if(isset($_POST["wedPieces"])){
	if(!empty($_POST["wedPieces"])){
		$wedPieces = $_POST["wedPieces"];
	}
	else{
		$wedPieces = "";
	}
}
else{
	$wedPieces = "";
}

//thuPieces
if(isset($_POST["thuPieces"])){
	if(!empty($_POST["thuPieces"])){
		$thuPieces = $_POST["thuPieces"];
	}
	else{
		$thuPieces = "";
	}
}
else{
	$thuPieces = "";
}

//friPieces
if(isset($_POST["friPieces"])){
	if(!empty($_POST["friPieces"])){
		$friPieces = $_POST["friPieces"];
	}
	else{
		$friPieces = "";
	}
}
else{
	$friPieces = "";
}

//satPieces
if(isset($_POST["satPieces"])){
	if(!empty($_POST["satPieces"])){
		$satPieces = $_POST["satPieces"];
	}
	else{
		$satPieces = "";
	}
}
else{
	$satPieces = "";
}

//sunPieces
if(isset($_POST["sunPieces"])){
	if(!empty($_POST["sunPieces"])){
		$sunPieces = $_POST["sunPieces"];
	}
	else{
		$sunPieces = "";
	}
}
else{
	$sunPieces = "";
}

//If employee ID is not set return error message
if(strcmp($workTermID, "") == 0){
	$responseMessage = "Please Select a Work Term.";
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

echo $employeeID . "<br>";
echo $workTermID . "<br>";
echo $formType . "<br>";
echo $weekStart . "<br>";
echo $monHours . "<br>";
echo $tueHours . "<br>";
echo $wedHours . "<br>";
echo $thuHours . "<br>";
echo $friHours . "<br>";
echo $satHours . "<br>";
echo $sunHours . "<br>";
echo $monPieces . "<br>";
echo $tuePieces . "<br>";
echo $wedPieces . "<br>";
echo $thuPieces . "<br>";
echo $friPieces . "<br>";
echo $satPieces . "<br>";
echo $sunPieces . "<br>";
	
?>

<form id="myForm" action="../maintenance.php" method="post">
    <input type="hidden" name="emp_id" value="<?php echo $employeeID ?>">
	<input type="hidden" name="work_term_id" value="<?php echo $workTermID ?>">
	<input type="hidden" name="page_type" value="<?php echo $pageType ?>">
	<input type="hidden" name="form_type" value="<?php echo $formType ?>">
	<input type="hidden" name="response" value="<?php echo $response ?>">
</form>
 
<script type="text/javascript">
    //document.getElementById('myForm').submit();
</script>