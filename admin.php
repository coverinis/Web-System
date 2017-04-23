<!doctype html>

<?php require './scripts/pageGeneration.php' ?>

<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="/styles/common.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<?php
	//Get the security level of the user
	$securityLevel = Admin;

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
	
	//Get the user ID if there is one
	if(isset($_POST["user_id"])){
		$userID = $_POST["user_id"];
	}
	else{
		$userID = "0";
	}
	
	//Get the employee id if there is one
	if(isset($_POST["employee_id"])){
		$employeeID = $_POST["employee_id"];
	}
	else{
		$employeeID = "0";
	}
	
	//Get the number of results if there is one
	if(isset($_POST["number_of_results"])){
		$numberOfResults = $_POST["number_of_results"];
	}
	else{
		$numberOfResults = "0";
	}
	
	//Get the Company ID if there is one
	if(isset($_POST["company_id"])){
		$companyID = $_POST["company_id"];
	}
	else{
		$companyID = "0";
	}
?>
<script>

$(document).ready(pageReady);

function pageReady(){
	//Set the event handler for the user switch
	$('#userSelect').change(changeUser);
	//Set the event handler for the company switch
	$('#companySelect').change(changeCompany);
	
	//Select the correct company and user from the drop downs
	$('#userSelect').val('<?php echo $userID; ?>');
	$('#companySelect').val('<?php echo $companyID; ?>');
	
	//Select the right tab on the page
	var pageType = "<?php echo $pageType; ?>";
	if(pageType == "<?php echo UserForm; ?>"){
		$("#userFormTab").click();
	}
	else if (pageType == "<?php echo AuditForm; ?>"){
		$("#auditFormTab").click();
	}
	else if (pageType == "<?php echo CompanyForm; ?>"){
		$("#companyFormTab").click();
	}
	else{
		$("#userFormTab").click();
	}
}

function changeUser(e){
	var selectID = "#" + $(this).attr("id");
	var newID = $(selectID).val();
	
	$("#user_id").val(newID);
	$("#page_type").val("<?php echo UserForm; ?>");
	$("#formChange").submit();
}

function changeCompany(e){	
	var selectID = "#" + $(this).attr("id");
	var newID = $(selectID).val();
	
	$("#company_id").val(newID);
	$("#page_type").val("<?php echo CompanyForm; ?>");
	$("#formChange").submit();
}

function passwordsMatch(){
	var originalPass = $('#password').val();
	var confirmPass = $('#confirm_password').val();
	if(originalPass == confirmPass){
		$('#response').text("");
		return true;
	}
	else{
		$('#response').text("Passwords Must Match");
		$('#response').css('color', 'red');
		return false;
	}
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
	<?php echo GenerateHeader(EmsSysAdmin); ?>
	<div id='adminContent'>
		<div class="tab">
			<button class="tablinks" id='userFormTab' onclick="openTab(event, 'UserInfo')">User Information</button>
			<button class="tablinks" id='auditFormTab' onclick="openTab(event, 'AuditInfo')">Audit Information</button>
			<button class="tablinks" id='companyFormTab' onclick="openTab(event, 'CompanyInfo')">Company Information</button>
		</div>
		<div id="UserInfo" class="tabcontent">
			<form onsubmit="return passwordsMatch()" method='post'>
				<h3 class='customFormLabel'>Select User</h3>
				<select class='customFormInput' id='userSelect'>
					<?php echo GenerateUserList(true); ?>
				</select>
				<?php echo GenerateUserForm($userID); ?>
				<h3 class='customFormLabel'>Password</h3>
				<input class='customFormInput' type='password' name='password' id='password' required>
				<h3 class='customFormLabel'>Confirm Password</h3>
				<input class='customFormInput' type='password' id='confirm_password' required>
				<h3 class='customFormLabel'>User Type</h3>
				<select class='customFormInput'>
					<option value="General">General</option>
					<option value="Admin">Admin</option>
				</select>
				<input type='hidden' name='submit_page_type' value='<?php echo UserForm; ?>'>
				<button class='customFormInput'>Submit</button>
			</form>
			<p id='response'></p>
		</div>
		<div id="AuditInfo" class="tabcontent">
		  <form method='post'>
			<h3 class='customFormLabel'>Select Employee</h3>
			<select class='customFormInput' name='employee_id'>
				<?php echo GenerateEmployeeList($securityLevel, false); ?>
			</select>
			<h3 class='customFormLabel'>Results</h3>
			<select class='customFormInput' name='number_of_results'>
				<option value="10">10</option>
				<option value="25">25</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
			<input type='hidden' name='submit_page_type' value='<?php echo AuditForm; ?>'>
			<button class='customFormInput'>Submit</button>
			<?php echo GenerateAuditTable($employeeID, $numberOfResults); ?>
		  </form>
		</div>
		<div id="CompanyInfo" class="tabcontent">
			<form method='post'>
			<h3 class='customFormLabel'>Select Company</h3>
			<select class='customFormInput' id='companySelect'>
				<?php echo GenerateCompanyList(true); ?>
			</select>
			<?php echo GenerateCompanyForm($companyID); ?>
			<input type='hidden' name='submit_page_type' value='<?php echo CompanyForm; ?>'>
			<button class='customFormInput'>Submit</button>
		  </form>
		</div>
		<form id='formChange' action='' method='post'>
			<input type='hidden' id='company_id' name='company_id' value='<?php echo $companyID; ?>'>
			<input type='hidden' id='user_id' name='user_id' value='<?php echo $userID; ?>'>
			<input type='hidden' id='page_type' name='page_type' value='<?php echo $pageType; ?>'>
		</form>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>