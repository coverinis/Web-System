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

//Report Types
define('SeniorityReport', 'Seniority Report');
define('WeeklyHoursReport', 'Weekly Hours Worked Report');
define('PayrollReport', 'Payroll Report');
define('ActiveEmpReport', 'Active Employee Report');
define('InactiveEmpReport', 'Inactive Employee Report');

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

function GenerateReportList($secLevel){
	ob_start();
?>
	<option value="<?php echo SeniorityReport; ?>"><?php echo SeniorityReport; ?></option>
	<option value="<?php echo WeeklyHoursReport; ?>"><?php echo WeeklyHoursReport; ?></option>
<?php
	if(strcmp($secLevel, Admin) == 0){
?>
	<option value="<?php echo PayrollReport; ?>"><?php echo PayrollReport; ?></option>
	<option value="<?php echo ActiveEmpReport; ?>"><?php echo ActiveEmpReport; ?></option>
	<option value="<?php echo InactiveEmpReport; ?>"><?php echo InactiveEmpReport; ?></option>
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
	
	//$employee = GetDetails($empID);
	
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
function GenerateEmployeeTimeCard($securityLevel, $employeeID, $weekStart){
	//Convert the date to a monday
	$weekStart = ConvertDateToMonday($weekStart);
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
	<br>
<?php
	echo "For Week Starting: " . $weekStart; 
	return ob_get_clean();
}

function GenerateSearchResult($securityLevel, $lastName, $firstName, $SIN){
	
	$tableCode = "";
	
	if(strlen($lastName) == 0 && strlen($firstName) == 0 && strlen($SIN) == 0){
		//Do search
		
		$tableCode = "No Result";
	}
	else{
		//Make table
		ob_start();
?>
		<h3 class='customFormLabel'>Test Result<h3>
		<table class='searchResultTable'>
			<tr>
				<th>Employee</th>
				<th>Actions</th>
			</tr>
			<?php echo GenerateSearchResultRow("blah", 1, $securityLevel); ?>
			<?php echo GenerateSearchResultRow("blah", 2, $securityLevel); ?>
		</table>
<?php
		$tableCode = ob_get_clean();
	}
	
	return $tableCode;
}

function GenerateSearchResultRow($employeeResult, $resultNumber, $securityLevel){
	$rowCode = "";
	
	ob_start();
?>
	<tr>
		<td>
			Hergott, Justin. (123456782)
			<button class='tablink  detailButton' onclick="openTab(event, '<?php echo 'item' . $resultNumber . 'Content'?>')">More...</button>
			<div id='<?php echo 'item' . $resultNumber . 'Content'?>' class='tabcontent'>
				Company: <br>
				Date of Birth: <br>
				Date of Hire: <br>
<?php
				if(strcmp($securityLevel, Admin) == 0){
?>
					Date of Termination: <br>
					Pay: <br>
					Status: <br>
<?php
				}
?>
				<button class='tablink detailButton' onclick="closeTab(event, '<?php echo 'item' . $resultNumber . 'Content'?>')">Less...</button>
			</div>
		</td>
		<td>
			<form class='actionForm' action='maintenance.php' method='post'>
				<input type='hidden' name='emp_id' value='1'/>
				<input type='hidden' name='form_type' value='Part Time'/>
				<input type='hidden' name='page_type' value='<?php echo EmpForm; ?>'/>
				<button class='actionButton'>Edit...</button>
			</form>
			<form class='actionForm' action='maintenance.php' method='post'>
				<input type='hidden' name='emp_id' value='1'/>
				<input type='hidden' name='form_type' value='Part Time'/>
				<input type='hidden' name='page_type' value='<?php echo TimeCard; ?>'/>
				<button class='actionButton'>Time Card...</button>
			</form>
		</td>
	</tr>
<?php	
	$rowCode = ob_get_clean();
	
	return $rowCode;
}

function GenerateReport($userID, $securityLevel, $reportType, $company, $date){
	$reportCode = "";
	
	//Convert date to monday
	$date = ConvertDateToMonday($date);
	
	if(strlen($company) == 0){
		$reportCode = "No Report.";
	}
	else{
		if(strcmp($reportType, SeniorityReport) == 0){
			//Generate Seniority Report
			$reportCode = GenerateSeniorityReport($userID, $company);
		}
		else if(strcmp($reportType, WeeklyHoursReport) == 0){
			//Generate Weekly Hours Worker Report
			$reportCode = GenerateWeeklyHoursReport($userID, $company, $date);
		}
		else if(strcmp($reportType, PayrollReport) == 0 && strcmp($securityLevel, Admin) == 0){
			//Generate Payroll Report
			$reportCode = GeneratePayrollReport($userID, $company, $date);
		}
		else if(strcmp($reportType, ActiveEmpReport) == 0 && strcmp($securityLevel, Admin) == 0){
			//Generate Active Employee Report
			$reportCode = GenerateActiveEmployeeReport($userID, $company);
		}
		else if(strcmp($reportType, InactiveEmpReport) == 0 && strcmp($securityLevel, Admin) == 0){
			//Generate Inactive Employee Report
			$reportCode = GenerateInactiveEmployeeReport($userID, $company);
		}
		else{
			$reportCode = "Unknown Report";
		}
	}
	
	return $reportCode;
}

function GenerateReportEnd($userID){
	$returnString = "";
	
	//Get the current Date
	$date = new DateTime();
	$strip = $date->format('Y-m-d');
	
	return "<br>Date Generated: " . $strip . "<br>" . "Run By: " . $userID;
}

function GenerateSeniorityReport($userID, $company){
	$seniorityReportCode = "";
	
	//Get Report Results
	
	ob_start();
?>
	<h3 class='customFormLabel'>Seniority Report (Company)</h3>
	<table class='reportResultTable'>
		<tr>
			<th>Employee Name</th>
			<th>SIN</th>
			<th>Type</th>
			<th>Date of Hire</th>
			<th>Years of Service</th>
		</tr>
		<tr>
			<td>Hergott, Justin</td>
			<td>1234567892</td>
			<td>Full Time</td>
			<td>2000-01-01</td>
			<td>17 Years</td>
		</tr>
	</table>
<?php	
	$seniorityReportCode = ob_get_clean();
	
	return $seniorityReportCode . GenerateReportEnd($userID);
}

function GenerateWeeklyHoursReport($userID, $company, $date){
	$weeklyHoursReportCode = "";
	
	//Get Report Results
	
	ob_start();
?>
	<h3 class='customFormLabel'>Weekly Hours Worked Report (Company)</h3>
<?php
	//For each Full Time Employee
	echo GenerateWeeklyHoursReportTable("blah", FullTime);
	//Part Time Employees
	echo GenerateWeeklyHoursReportTable("blah", PartTime);
	//Seasonal Employees
	echo GenerateWeeklyHoursReportTable("blah", Seasonal);
	
	$weeklyHoursReportCode = ob_get_clean();
	
	//Week Ending
	$weekEnding = "For Week Ending: " . date('Y-m-d', strtotime("next sunday", strtotime($date)));
	
	return $weeklyHoursReportCode . $weekEnding . GenerateReportEnd($userID);
}

function GenerateWeeklyHoursReportTable($results, $employeeType){
	$tableCode = "";
	
	ob_start();
	//For each employee that matches the type
?>
	<table class='reportResultTable'>
		<tr>
			<th colspan='3'><?php echo $employeeType; ?></th>
		</tr>
		<tr>
			<th>Employee Name</th>
			<th>SIN</th>
			<th>Hours</th>
		</tr>
		<tr>
			<td>Hergott, Justin</td>
			<td>1234567892</td>
			<td>40.00</td>
		</tr>
	</table>
	<br>
<?php
	
	$tableCode = ob_get_clean();
	
	return $tableCode;
}

function GeneratePayrollReport($userID, $company, $date){
	$payrollReportCode = "";
	
	//Get Report Results
	
	ob_start();
?>
	<h3 class='customFormLabel'>Payroll Report (Company)</h3>
<?php
	//For each Full Time Employee
	echo GeneratePayrollReportTable("blah", FullTime);
	//Part Time Employees
	echo GeneratePayrollReportTable("blah", PartTime);
	//Seasonal Employees
	echo GeneratePayrollReportTable("blah", Seasonal);
	//Contract Employees
	echo GeneratePayrollReportTable("blah", Contract);
	
	$payrollReportCode = ob_get_clean();
	
	//Week Ending
	$weekEnding = "For Week Ending: " . date('Y-m-d', strtotime("next sunday", strtotime($date)));
	
	return $payrollReportCode . $weekEnding . GenerateReportEnd($userID);
}

function GeneratePayrollReportTable($results, $employeeType){
	$tableCode = "";
	
	ob_start();
	//For each employee that matches the type
?>
	<table class='reportResultTable'>
		<tr>
			<th colspan='4'><?php echo $employeeType; ?></th>
		</tr>
		<tr>
			<th>Employee Name</th>
			<th>Hours</th>
			<th>Gross</th>
			<th>Notes</th>
		</tr>
		<tr>
			<td>Hergott, Justin</td>
			<td>40.00</td>
			<td>1,000.00</td>
			<td>Not Full Work Week</td>
		</tr>
	</table>
	<br>
<?php
	
	$tableCode = ob_get_clean();
	
	return $tableCode;
}

function GenerateActiveEmployeeReport($userID, $company){
	$activeReportCode = "";
	
	//Get Report Results
	
	ob_start();
?>
	<h3 class='customFormLabel'>Active Employee Report (Company)</h3>
<?php
	//For each Full Time Employee
	echo GenerateActiveEmployeeReportTable("blah", FullTime);
	//Part Time Employees
	echo GenerateActiveEmployeeReportTable("blah", PartTime);
	//Seasonal Employees
	echo GenerateActiveEmployeeReportTable("blah", Seasonal);
	//Contract Employees
	echo GenerateActiveEmployeeReportTable("blah", Contract);
	
	$activeReportCode = ob_get_clean();
	
	return $activeReportCode . GenerateReportEnd($userID);
}

function GenerateActiveEmployeeReportTable($results, $employeeType){
	$tableCode = "";
	
	ob_start();
	//For each employee that matches the type
?>
	<table class='reportResultTable'>
		<tr>
			<th colspan='3'><?php echo $employeeType; ?></th>
		</tr>
		<tr>
			<th>Employee Name</th>
			<th>Date of Hire</th>
			<th>Avg. Hours</th>
		</tr>
		<tr>
			<td>Hergott, Justin</td>
			<td>2017-02-28</td>
			<td>40.00</td>
		</tr>
	</table>
	<br>
<?php
	
	$tableCode = ob_get_clean();
	
	return $tableCode;
}

function GenerateInactiveEmployeeReport($userID, $company){
	$inactiveReportCode = "";
	
	//Get Report Results
	
	ob_start();
?>
	<h3 class='customFormLabel'>Inactive Employee Report (Company)</h3>
	<table class='reportResultTable'>
		<tr>
			<th>Employee Name</th>
			<th>Hired</th>
			<th>Terminated</th>
			<th>Type</th>
			<th>Reason for Leaving</th>
		</tr>
		<tr>
			<td>Hergott, Justin</td>
			<td>2000-01-01</td>
			<td>2000-01-02</td>
			<td>Full Time</td>
			<td>Bad Employee</td>
		</tr>
	</table>
<?php	
	$inactiveReportCode = ob_get_clean();
	
	return $inactiveReportCode . GenerateReportEnd($userID);
}

function ConvertDateToMonday($date){
	
	$returnDate = "";
	$time = strtotime($date);
	
	if(strtotime($date) == false){
		$returnDate = "False";
	}
	
	$returnDate =  date('Y-m-d', $time);
	
	$day = date('D', $time);
	if( strcmp($day, "Mon") == 0 ){
		//Date is a monday
		$returnDate = $date;
	}
	else{
		//Convert date to last monday
		$returnDate = date('Y-m-d', strtotime("last monday", strtotime($date)));	
	}
	
	return $returnDate;
}
?>