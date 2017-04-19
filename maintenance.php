<!doctype html>

<?php require 'pageGeneration.php' ?>

<html lang="en">
<head>

	<style>
		
	</style>
<link rel="stylesheet" type="text/css" href="common.css">

<script>
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
				<select class='customFormInput'>
					<option value="FullTime">Full Time</option>
					<option value="FullTime">Part Time</option>
					<option value="FullTime">Seasonal Time</option>
				</select>
				<h3 class='customFormLabel'>First Name</h3>
				<input class='customFormInput' type='text' name='fname'>
				<h3 class='customFormLabel'>Last Name</h3>
				<input class='customFormInput' type='text' name='lname'>
				<h3 class='customFormLabel'>Company Name</h3>
				<input class='customFormInput' type='text' name='cname'>
				<h3 class='customFormLabel'>Social Insurance Number</h3>
				<input class='customFormInput' type='text' name='sin'>
				<h3 class='customFormLabel'>Date of Birth</h3>
				<input class='customFormInput' type='text' name='dob'>
				<h3 class='customFormLabel'>Date of Hire</h3>
				<input class='customFormInput' type='text' name='doh'>
				<button class='customFormInput'>Submit</button>
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