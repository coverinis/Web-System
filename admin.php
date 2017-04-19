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
	<?php echo GenerateHeader(EmsSysAdmin); ?>
	<div id='adminContent'>
		<div class="tab">
			<button class="tablinks" id='defaultOpen' onclick="openTab(event, 'UserInfo')">User Information</button>
			<button class="tablinks" onclick="openTab(event, 'AuditInfo')">Audit Information</button>
		</div>
		<div id="UserInfo" class="tabcontent">
			<form>
				
				<h3 class='customFormLabel'>Username</h3>
				<input class='customFormInput' type='text' name='username'>
				<h3 class='customFormLabel'>Password</h3>
				<input class='customFormInput' type='password' name='password'>
				<h3 class='customFormLabel'>User Type</h3>
				<select class='customFormInput'>
					<option value="General">General</option>
					<option value="Admin">Admin</option>
				</select>
				<button class='customFormInput'>Submit</button>
			</form>
		</div>
		<div id="AuditInfo" class="tabcontent">
		  <form>
			<h3 class='customFormLabel'>Audit Information</h3>
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