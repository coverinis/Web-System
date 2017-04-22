<?php

//Page name constants
define('Login', 'Login');
define('MainMenu', 'Main Menu');
define ('MainMenuLink', 'menu.php');
define('EmpMaintenance', 'Employee Maintenance');
define('EmpSearch', 'Employee Search');
define ('EmpReports', 'Employee Reports');
define('EmsSysAdmin', 'EMS System Administration');

//Employee Type Constants
define('FullTime', 'Full Time');
define('PartTime', 'Part Time');
define('Seasonal', 'Seasonal');
define('Contract', 'Contract');

//Security Level Constants
define('Admin', 'Admin');
define('General', 'General');

//Page Types
define('EmpForm', 'Employee Form');
define('TimeCard', 'Time Card');

//Make the bread crumb string
function GenerateBreadCrumbTrail($pageName){
	//The return string
	$breadCrumb = " > ";
	
	if(strcmp($pageName, MainMenu) == 0){
		$breadCrumb = $breadCrumb . MainMenu;
	}
	else if(strcmp($pageName, Login) == 0){
		$breadCrumb = $breadCrumb . Login;
	}
	else{
		$breadCrumb = $breadCrumb . GenerateLink(MainMenu, MainMenuLink) . " > ";
		if(strcmp($pageName, EmpMaintenance) == 0){
			$breadCrumb = $breadCrumb . EmpMaintenance;
		}
		else if(strcmp($pageName, EmpSearch) == 0){
			$breadCrumb = $breadCrumb . EmpSearch;
		}
		else if(strcmp($pageName, EmpReports) == 0){
			$breadCrumb = $breadCrumb . EmpReports;
		}
		else if(strcmp($pageName, EmsSysAdmin) == 0){
			$breadCrumb = $breadCrumb . EmsSysAdmin;
		}
		else{
			$breadCrumb = $breadCrumb . "Undefined";
		}
	}
	
	return $breadCrumb;
}

//Generate a link element for the bread crumb trail
function GenerateLink($pageName, $link){
	$returnString = "<a href='" . $link . "'>" . $pageName . "</a>";
	return $returnString;
}

function GenerateEmployeeTypeList($secLevel){
	ob_start();
?>
	<option value="<?php echo FullTime; ?>"><?php echo FullTime; ?></option>
	<option value="<?php echo PartTime; ?>"><?php echo PartTime; ?></option>
	<option value="<?php echo Seasonal; ?>"><?php echo Seasonal; ?></option>
<?php
	if(strcmp($secLevel, Admin) == 0){
?>
	<option value="<?php echo Contract; ?>"><?php echo Contract; ?></option>
<?php
	}
	
	return ob_get_clean();
}

?>

<?php
//Generate the common header
function GenerateHeader($pageName){
	ob_start();
?>
	<div id='pageHeader'>
		<div id='appTitle'>
			<p>EMSII</p>
		</div>
		<div id='userInfo'>
			
		</div>
		<div id='breadcrumb'>
			<?php echo GenerateBreadCrumbTrail($pageName); ?>
		</div>
		<div id='pageTitle'>
			<p> <?php echo $pageName; ?> </p>
			<hr>
		</div>
	</div>
<?php
	return ob_get_clean();
}

//Generate the common footer
function GenerateFooter(){
	ob_start();
?>
	<div id='pageFooter'>
		<hr>
		<div id='footerCopyright'>
			<p>EMSII - &copy 2017 Team Void</p>
		</div>
	</div>
<?php
	return ob_get_clean();
}

function GenerateEmployeeForm($empType, $secLevel, $empID){
	$formCode = "";
	
	if(strcmp($empType, FullTime) == 0){
		ob_start();
?>
		<h3 class='customFormLabel'>First Name</h3>
		<input class='customFormInput' type='text' name='fname' value='<?php echo $empID; ?>'>
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
<?php
		if(strcmp($secLevel, Admin) == 0){
?>
			<h3 class='customFormLabel'>Date of Termination</h3>
			<input class='customFormInput' type='text' name='dot'>
			<h3 class='customFormLabel'>Salary</h3>
			<input class='customFormInput' type='text' name='pay'>
			<h3 class='customFormLabel'>Status</h3>
			<input class='customFormInput' type='text' name='status'>
<?php	
		}
?>
		<button class='customFormInput'>Submit</button>
<?php	
		$formCode = ob_get_clean();
	}
	else if(strcmp($empType, PartTime) == 0){
		ob_start();
?>
		<h3 class='customFormLabel'>First Name</h3>
		<input class='customFormInput' type='text' name='fname' value='<?php echo $empID; ?>'>
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
<?php
		if(strcmp($secLevel, Admin) == 0){
?>
			<h3 class='customFormLabel'>Date of Termination</h3>
			<input class='customFormInput' type='text' name='dot'>
			<h3 class='customFormLabel'>Wage</h3>
			<input class='customFormInput' type='text' name='pay'>
			<h3 class='customFormLabel'>Status</h3>
			<input class='customFormInput' type='text' name='status'>
<?php
		}
?>
			<button class='customFormInput'>Submit</button>
<?php		
		$formCode = ob_get_clean();
	}
	else if(strcmp($empType, Seasonal) == 0){
		ob_start();
?>
		<h3 class='customFormLabel'>First Name</h3>
		<input class='customFormInput' type='text' name='fname' value='<?php echo $empID; ?>'>
		<h3 class='customFormLabel'>Last Name</h3>
		<input class='customFormInput' type='text' name='lname'>
		<h3 class='customFormLabel'>Company Name</h3>
		<input class='customFormInput' type='text' name='cname'>
		<h3 class='customFormLabel'>Social Insurance Number</h3>
		<input class='customFormInput' type='text' name='sin'>
		<h3 class='customFormLabel'>Date of Birth</h3>
		<input class='customFormInput' type='text' name='dob'>
		<h3 class='customFormLabel'>Season</h3>
		<input class='customFormInput' type='text' name='doh'>
		<h3 class='customFormLabel'>Season Year</h3>
		<input class='customFormInput' type='text' name='doh_detail'>
<?php
		if(strcmp($secLevel, Admin) == 0){
?>
			<h3 class='customFormLabel'>Piece Pay</h3>
			<input class='customFormInput' type='text' name='pay'>
			<h3 class='customFormLabel'>Status</h3>
			<input class='customFormInput' type='text' name='status'>
<?php
		}
?>
		<button class='customFormInput'>Submit</button>
<?php		
		$formCode = ob_get_clean();
	}
	else if(strcmp($empType, Contract) == 0 && strcmp($secLevel, Admin) == 0){
		ob_start();
?>
		<h3 class='customFormLabel'>Corporation Name</h3>
		<input class='customFormInput' type='text' name='lname' value='<?php echo $empID; ?>'>
		<h3 class='customFormLabel'>Company Name</h3>
		<input class='customFormInput' type='text' name='cname'>
		<h3 class='customFormLabel'>Business Number</h3>
		<input class='customFormInput' type='text' name='sin'>
		<h3 class='customFormLabel'>Date of Incorporation</h3>
		<input class='customFormInput' type='text' name='dob'>
		<h3 class='customFormLabel'>Contract Start Date</h3>
		<input class='customFormInput' type='text' name='doh'>
		<h3 class='customFormLabel'>Contract End Date</h3>
		<input class='customFormInput' type='text' name='dot'>
		<h3 class='customFormLabel'>Contract Amount</h3>
		<input class='customFormInput' type='text' name='pay'>
		<h3 class='customFormLabel'>Status</h3>
		<input class='customFormInput' type='text' name='status'>
		<button class='customFormInput'>Submit</button>
<?php		
		$formCode = ob_get_clean();
	}
	else{
		ob_start();
?>
		<h3 class='customFormLabel'>Error</h3>
<?php		
		$formCode = ob_get_clean();
	}
	
	return $formCode;
}

//Create a time card table
function GenerateEmployeeTimeCard($securityLevel, $employeeID){
	ob_start();
?>
	<table class='timeCardTable'>
		<tr>
			<th></th>
			<th>Mon</th>
			<th>Tues</th>
			<th>Wed</th>
			<th>Thurs</th>
			<th>Fri</th>
			<th>Sat</th>
			<th>Sun</th>
		</tr>
		<tr>
			<th>Hours</th>
			<td><input type='number' name='monHours'></td>
			<td><input type='number' name='tuesHours'></td>
			<td><input type='number' name='wedHours'></td>
			<td><input type='number' name='thursHours'></td>
			<td><input type='number' name='friHours'></td>
			<td><input type='number' name='satHours'></td>
			<td><input type='number' name='sunHours'></td>
		</tr>
<?php
	//Check Employee Type to see if its seasonal to display pieces
?>
		<tr>
			<th>Pieces</th>
			<td><input type='number' name='monPieces'></td>
			<td><input type='number' name='tuesPieces'></td>
			<td><input type='number' name='wedPieces'></td>
			<td><input type='number' name='thursPieces'></td>
			<td><input type='number' name='friPieces'></td>
			<td><input type='number' name='satPieces'></td>
			<td><input type='number' name='sunPieces'></td>
		</tr>
		<tr>
		</tr>
	</table>
	<button class='customFormInput'>Submit</button>
<?php	
	return ob_get_clean();
}
?>