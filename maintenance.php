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
		ini_set('display_errors', 0);
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
?>
<script>

	$(document).ready(pageReady);

	function pageReady(){
		$("#empTypeSelect").change(changeForm);
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
		evt.currentTarget.className += " active";
	}
</script>

</head>

<body>
	<?php echo GenerateHeader(EmpMaintenance); ?>
	<div id='maintenanceContent'>
		<div class="tab">
			<button class="tablinks" id='defaultOpen' onclick="openTab(event, 'EmpInfo')">Employee Information</button>
			<button class="tablinks" onclick="openTab(event, 'TimeCardInfo')">Time Card Information</button>
		</div>
		<div id="EmpInfo" class="tabcontent">
			<form>
				<h3 class='customFormLabel'>Select Employee</h3>
				<select class='customFormInput'>
					<option value="AddNew">Add New...</option>
				</select>
				<h3 class='customFormLabel'>Employee Type</h3>
				<select class='customFormInput' id='empTypeSelect'>
					<option value="Full Time">Full Time</option>
					<option value="Part Time">Part Time</option>
					<option value="Seasonal">Seasonal</option>
				</select>
				<?php echo GenerateEmployeeForm($formType, $securityLevel); ?>
			</form>
			<form id='formChange' action='maintenance.php' method='post'>
				<input type='hidden' id='form_type' name='form_type' value=''>
			</form>
		</div>
		<div id="TimeCardInfo" class="tabcontent">
		  <form>
			<h3 class='customFormLabel'>Select Employee</h3>
				<select class='customFormInput'>
					<option value="AddNew">Add New...</option>
				</select>
			<h3 class='customFormLabel'>Week Start Date</h3>
			<input class='customFormInput' type='date' name='weekStart'>
			<h3 class='customFormLabel'>Time Card</h3>
		  </form>
		</div>
	</div>
	<?php echo GenerateFooter(); ?>
	<script>
		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();
	</script>
</body>
</html>