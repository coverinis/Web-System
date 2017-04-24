<!doctype html>

<?php
	require './scripts/pageGeneration.php';
	session_start();
?>


<html lang="en">
<head>

	<style>
		
	</style>
<link rel="stylesheet" type="text/css" href="/styles/common.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<?php
		//Get the security level of the user
		$securityLevel = $_SESSION["userType"];
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
		
		//Get the work term ID if there is one
		if(isset($_POST["work_term_id"])){
			$workTermID = $_POST["work_term_id"];
			
			//Check the employee type based on the work term and change it
			$formType = PartTime;
		}
		else{
			$workTermID = 0;
		}
		
		//Get the page type if there is one
		if(isset($_POST["submit_page_type"])){
			$pageType = $_POST["submit_page_type"];
		}
		else{
			if(isset($_POST["page_type"])){
				$pageType = $_POST["page_type"];
			}
			else{
				$pageType = EmpForm;
			}
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
		$("#employeeSelectEmp").change(changeEmployee);
		$("#workTermSelectEmployee").change(changeEmployee);
		$("#workTermSelectWorkTerm").change(changeWorkTerm);
		
		//Select the right employee from each select
		$('#employeeSelectEmp').val('<?php echo $employeeID; ?>');
		$('#workTermSelectEmp').val('<?php echo $employeeID; ?>');
		$('#timeCardSelectEmp').val('<?php echo $employeeID; ?>');
		
		//Select the right work term
		$("#workTermSelectWorkTerm").val('<?php echo $workTermID; ?>');
		
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
		else if (pageType == "<?php echo WorkTerm; ?>"){
			$("#workTermFormTab").click();
		}
		else{
			$("#empFormTab").click();
		}
		
	}
	
	function changeForm(e){
		e.preventDefault();
		var newType = $('#empTypeSelect').find(":selected").text();
		$("#form_type").val(newType);
		$("#work_term_id").val("0");
		$("#page_type").val("<?php echo WorkTerm; ?>");
		$("#formChange").submit();
	}
	
	function changeEmployee(e){
		e.preventDefault();
		var selectID = "#" + $(this).attr("id");
		var newID = $(selectID).val();
		
		//Get the employee details by ID in PHP
		
		
		//Change the inputs of the appropriate tab
		if(selectID == "#employeeSelectEmp"){
			//Fill in the hidden form and refresh the page
			$("#emp_id").val(newID);
			$("#page_type").val("<?php echo EmpForm; ?>");
			$("#formChange").submit();
		}
		else if(selectID == "#workTermSelectEmployee"){
			//Fill in the hidden form and refresh the page
			$("#emp_id").val(newID);
			$("#page_type").val("<?php echo WorkTerm; ?>");
			$("#formChange").submit();
		}
		else{
			//Fill in the hidden form and refresh the page
			$("#emp_id").val(newID);
			$("#page_type").val("<?php echo TimeCard; ?>");
			$("#formChange").submit();
		}
	}
	
	function changeWorkTerm(e){
		var selectID = "#" + $(this).attr("id");
		var newID = $(selectID).val();
		
		$("#work_term_id").val(newID);
		$("#page_type").val("<?php echo WorkTerm; ?>");
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
		if(tabName == "EmpInfo"){
			$("#page_type").val("<?php echo EmpForm; ?>");
		}
		//If its a work term set the hidden
		if(tabName == "WorkTerm"){
			$("#page_type").val("<?php echo WorkTerm; ?>");
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
	<?php echo GenerateHeader(EmpMaintenance, true); ?>
	<div id='maintenanceContent'>
		<div class="tab">
			<button class="tablinks" id='empFormTab' onclick="openTab(event, 'EmpInfo')">Employee Information</button>
			<button class="tablinks" id='workTermFormTab' onclick="openTab(event, 'WorkTerm')">Work Term Information</button>
			<button class="tablinks" id='timeCardTab' onclick="openTab(event, 'TimeCardInfo')">Time Card Information</button>
		</div>
		<p class='responseMessage'><?php echo $response; ?></p>
		<div id="EmpInfo" class="tabcontent">
			<form id='employeeForm' action='' method='post'>
				<h3 class='customFormLabel'>Select Employee</h3>
				<select class='customFormInput' id='employeeSelectEmp'>
					<?php echo GenerateEmployeeList($securityLevel, true); ?>
				</select>
				<input type='hidden' value='<?php echo EmpForm; ?>' name='submit_page_type'>
				<?php echo GenerateEmployeeForm($employeeID, $securityLevel); ?>
			</form>
		</div>
		<div id="WorkTerm" class="tabcontent">
			<form id='employeeForm' action='' method='post'>
				<h3 class='customFormLabel'>Select Employee</h3>
				<select class='customFormInput' id='workTermSelectEmployee'>
					<?php echo GenerateEmployeeList($securityLevel, false); ?>
				</select>
				<h3 class='customFormLabel'>Select Work Term</h3>
				<select class='customFormInput' id='workTermSelectWorkTerm'>
					<?php echo GenerateWorkTermList($employeeID, $securityLevel, true); ?>
				</select>
				<h3 class='customFormLabel'>Employee Type</h3>
				<select class='customFormInput' id='empTypeSelect'>
					<?php echo GenerateEmployeeTypeList($securityLevel); ?>
				</select>
				<input type='hidden' value='<?php echo WorkTerm; ?>' name='submit_page_type'>
				<?php echo GenerateWorkTermForm($formType, $securityLevel, $employeeID); ?>
			</form>
		</div>
		<div id="TimeCardInfo" class="tabcontent">
			<form id='timeCardForm' action='' method='post'>
				<h3 class='customFormLabel'>Select Employee</h3>
				<select class='customFormInput' id='timeCardSelectEmployee'>
					<?php echo GenerateEmployeeList($securityLevel, false); ?>
				</select>
				<h3 class='customFormLabel'>Week Start Date</h3>
				<input class='customFormInput' type='date' name='week_start' value='<?php echo date('Y-m-d'); ?>'>
				<input type='hidden' value='<?php echo TimeCard; ?>' name='submit_page_type'>
				<h3 class='customFormLabel'>Time Card</h3>
				<?php echo GenerateEmployeeTimeCard($securityLevel, $employeeID, $weekStart); ?>
			</form>
		</div>
		<form id='formChange' action='maintenance.php' method='post'>
				<input type='hidden' id='form_type' name='form_type' value=''>
				<input type='hidden' id='emp_id' name='emp_id' value=''>
				<input type='hidden' id='work_term_id' name='work_term_id' value=''>
				<input type='hidden' id='page_type' name='page_type' value=''>
		</form>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>