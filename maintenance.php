<!doctype html>

<?php require './scripts/pageGeneration.php' ?>

<html lang="en">
<head>

	<style>
		
	</style>
<link rel="stylesheet" type="text/css" href="/styles/common.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<?php
		//Get the security level of the user
		$securityLevel = Admin;
		//Get the form_type if it is set
		//ini_set('display_errors', 0);
		if(isset($_POST["form_type"])){
			if(!empty($_POST["form_type"])){
				$formType = $_POST["form_type"];
			}
			else{
				$formType = FullTime;
			}
		}
		else{
			$formType = FullTime;
		}
		
		//Get the employee ID if there is one
		if(isset($_POST["emp_id"])){
			$employeeID = $_POST["emp_id"];
		}
		else{
			$employeeID = 0;
		}
		
		//Get the page type if there is one
		if(isset($_POST["page_type"])){
			$pageType = $_POST["page_type"];
		}
		else{
			$pageType = EmpForm;
		}
		
		//Get the response message if there is one
		if(isset($_POST["response"])){
			$response = $_POST["response"];
		}
		else{
			$response = "";
		}
		
		//Get the date if there is one
		if(isset($_POST["week_start"])){
			$weekStart = $_POST["week_start"];
		}
		else{
			$weekStart =  date('Y-m-d');
		}
?>
<script>

	$(document).ready(pageReady);

	function pageReady(){
		$("#empTypeSelect").change(changeForm);
		
		//Check if form info needs to be filled in
		
		//Select the right option from type
		var currentType = "<?php echo $formType; ?>";
		if(currentType == "<?php echo FullTime; ?>"){
			$('#empTypeSelect').val('<?php echo FullTime; ?>');
		}
		else if(currentType == "<?php echo PartTime; ?>"){
			$('#empTypeSelect').val('<?php echo PartTime; ?>');
		}
		else if(currentType == "<?php echo Seasonal; ?>"){
			$('#empTypeSelect').val("<?php echo Seasonal; ?>");
		}
		else if(currentType == "<?php echo Contract; ?>"){
			$('#empTypeSelect').val("<?php echo Contract; ?>");
		}
		else{
			$('#empTypeSelect').val("<?php echo FullTime; ?>");
		}
		
		//Select the right tab on the page
		var pageType = "<?php echo $pageType; ?>";
		if(pageType == "<?php echo EmpForm; ?>"){
			$("#empFormTab").click();
		}
		else if (pageType == "<?php echo TimeCard; ?>"){
			$("#timeCardTab").click();
		}
		else{
			$("#empFormTab").click();
		}
		
	}
	
	function changeForm(e){
		e.preventDefault();
		var newType = $('#empTypeSelect').find(":selected").text();
		$("#form_type").val(newType);
		$("#formChange").submit();
	}
	
	function openTab(evt, tabName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(tabName).style.display = "block";
		//If it the tabName is EmpInfo set the hidden
		if(tabName == EmpInfo){
			$("#page_type").val("<?php echo EmpForm; ?>");
		}
		//Else set it to TimeCardInfo
		else{
			$("#page_type").val("<?php echo TimeCard; ?>");
		}		
		evt.currentTarget.className += " active";
	}
</script>

</head>

<body>
	<?php echo GenerateHeader(EmpMaintenance); ?>
	<div id='maintenanceContent'>
		<div class="tab">
			<button class="tablinks" id='empFormTab' onclick="openTab(event, 'EmpInfo')">Employee Information</button>
			<button class="tablinks" id='timeCardTab' onclick="openTab(event, 'TimeCardInfo')">Time Card Information</button>
		</div>
		<p class='responseMessage'><?php echo $response; ?></p>
		<div id="EmpInfo" class="tabcontent">
			<form id='employeeForm' action='' method='post'>
				<h3 class='customFormLabel'>Select Employee</h3>
				<select class='customFormInput'>
					<?php echo GenerateEmployeeList($securityLevel, true); ?>
				</select>
				<h3 class='customFormLabel'>Employee Type</h3>
				<select class='customFormInput' id='empTypeSelect'>
					<?php echo GenerateEmployeeTypeList($securityLevel); ?>
				</select>
				<?php echo GenerateEmployeeForm($formType, $securityLevel, $employeeID); ?>
			</form>
		</div>
		<div id="TimeCardInfo" class="tabcontent">
			<form id='timeCardForm' action='' method='post'>
				<h3 class='customFormLabel'>Select Employee</h3>
					<select class='customFormInput'>
						<?php echo GenerateEmployeeList($securityLevel, false); ?>
					</select>
				<h3 class='customFormLabel'>Week Start Date</h3>
				<input class='customFormInput' type='date' name='week_start' value='<?php echo date('Y-m-d'); ?>'>
				<input type='hidden' id='page_type' name='page_type' value=''>
				<h3 class='customFormLabel'>Time Card</h3>
				<?php echo GenerateEmployeeTimeCard($securityLevel, $employeeID, $weekStart); ?>
			</form>
		</div>
		<form id='formChange' action='maintenance.php' method='post'>
				<input type='hidden' id='form_type' name='form_type' value=''>
				<input type='hidden' id='emp_ip' name='emp_id' value=''>
				<input type='hidden' id='page_type' name='page_type' value=''>
		</form>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>