<?php

require 'tools.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
define('Admin', 'Administrator');
define('General', 'General');

//Page Types
define('EmpForm', 'Employee Form');
define('WorkTerm', 'Work Term Form');
define('TimeCard', 'Time Card');
define('UserForm', 'User Form');
define('AuditForm', 'Audit Form');
define('CompanyForm', 'Company Form');

//Report Types
define('SeniorityReport', 'Seniority Report');
define('WeeklyHoursReport', 'Weekly Hours Worked Report');
define('PayrollReport', 'Payroll Report');
define('ActiveEmpReport', 'Active Employee Report');
define('InactiveEmpReport', 'Inactive Employee Report');

//Initialize DAL
DAL::Init();

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

function GenerateEmployeeList($secLevel, $addNew){
	
	//Get the employee details
	$employeeList = GetEmployeeList($secLevel);
	
	ob_start();
	if($addNew == true){
?>
	<option value="0">Add New...</option>
<?php
	}
	//Loop through employees
	foreach($employeeList as $row){
?>
		<option value='<?php echo $row->employeeID; ?>'><?php echo $row->firstName . " " . $row->lastName . " (" . $row->socialInsuranceNumber . ")"; ?></option>
<?php
	}
	
	return ob_get_clean();
}

function GenerateWorkTermList($employeeID, $secLevel, $addNew){
	
	//Get the employee details
	$workTermList = GetWorkTermList($employeeID, $secLevel);
	ob_start();
	if($addNew == true){
?>
	<option value="0">Add New...</option>
<?php
	}
	//Loop through employees
	foreach($workTermList as $workTerm){
?>
		<option value='<?php echo $workTerm->workTermID; ?>'><?php echo $workTerm->companyName . " - " . $workTerm->employeeType . " - " . $workTerm->dateOfHire; ?></option>
<?php
	}
	
	return ob_get_clean();
}

function GenerateCompanyList($addNew){
	
	//Get the companies
	$companies = GetCompanyList();
	
	ob_start();
	if($addNew == true){
?>
	<option value="0">Add New...</option>
<?php
	}
	//Loop through companies
	foreach($companies as $comp){
?>
		<option value="<?php echo $comp->name; ?>"><?php echo $comp->name; ?></option>
<?php
	}
	return ob_get_clean();
}

function GenerateUserList($addNew){
	
	//Get the users
	
	ob_start();
	if($addNew == true){
?>
	<option value="0">Add New...</option>
<?php
	}
	//Loop through users
?>
	<option value="<?php echo "1"; ?>"><?php echo "User1"; ?></option>
<?php
	return ob_get_clean();
}

?>

<?php
//Generate the common header
function GenerateHeader($pageName, $showUserInfo){
	ob_start();
?>
	<div id='pageHeader'>
		<div id='appTitle'>
			<p>EMSII</p>
		</div>
<?php 
		if($showUserInfo == true){
?>
			<div id='userInfo'>
<?php 
			if(!isset($_SESSION["userID"])){
				//Not logged in, redirect to login page
				header("Location: ../login.php"); /* Redirect browser */
				exit();
			}
?>
				<p>Logged In As: <?php echo $_SESSION["userFName"] . " " . $_SESSION["userLName"]; ?><br>Security Level: <?php echo $_SESSION["userType"]; ?></p><br>
				<a href='/scripts/logout.php'>Log Out</a>
			</div>
<?php 
		}
?>
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

function GenerateEmployeeForm($empID, $secLevel){
	$formCode = "";
	
	$employee = GetEmployeeDetail($empID);
	
	ob_start();
?>
	<h3 class='customFormLabel'>First Name</h3>
	<input class='customFormInput' type='text' id='empFName' name='fname' value='<?php echo $employee->firstName; ?>'>
	<h3 class='customFormLabel'>Last Name<?php if(strcmp($secLevel, Admin) == 0){ echo " (Corporation Name)"; } ?></h3>
	<input class='customFormInput' type='text' id='empLName' name='lname' value='<?php echo $employee->lastName; ?>'>
	<h3 class='customFormLabel'>Social Insurance Number<?php if(strcmp($secLevel, Admin) == 0){ echo " (Business Number)"; } ?></h3>
	<input class='customFormInput' type='text' id='empSIN' name='sin' value='<?php echo $employee->socialInsuranceNumber; ?>'>
	<h3 class='customFormLabel'>Date of Birth<?php if(strcmp($secLevel, Admin) == 0){ echo " (Date of Incorporation)"; } ?></h3>
	<input class='customFormInput' type='text' id='empDOB' name='dob' value='<?php echo $employee->dateOfBirth; ?>'>
	<button class='customFormInput'>Submit</button>
<?php

	$formCode = ob_get_clean();
	
	return $formCode;
}

function GenerateWorkTermForm($empType, $secLevel, $workTermID){
	$formCode = "";
	
	$workTerm = GetWorkTerm($workTermID);
	
	if(strcmp($empType, FullTime) == 0){
		ob_start();
?>
		<h3 class='customFormLabel'>Select Company</h3>
		<select class='customFormInput' id='cname'>
			<?php echo GenerateCompanyList(false); ?>
		</select>
		<h3 class='customFormLabel'>Date of Hire</h3>
		<input class='customFormInput' type='text' name='doh' value='<?php echo $workTerm->dateOfHire; ?>'>
<?php
		if(strcmp($secLevel, Admin) == 0){
?>
			<h3 class='customFormLabel'>Date of Termination</h3>
			<input class='customFormInput' type='text' name='dot' value='<?php echo $workTerm->dateOfTermination; ?>'>
			<h3 class='customFormLabel'>Salary</h3>
			<input class='customFormInput' type='text' name='pay' value='<?php echo $workTerm->pay; ?>'>
			<h3 class='customFormLabel'>Status</h3>
			<input class='customFormInput' type='text' name='status' value='<?php echo $workTerm->status; ?>'>
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
		<h3 class='customFormLabel'>Select Company</h3>
		<select class='customFormInput' id='cname'>
			<?php echo GenerateCompanyList(false); ?>
		</select>
		<h3 class='customFormLabel'>Date of Hire</h3>
		<input class='customFormInput' type='text' name='doh' value='<?php echo $workTerm->dateOfHire; ?>'>
<?php
		if(strcmp($secLevel, Admin) == 0){
?>
			<h3 class='customFormLabel'>Date of Termination</h3>
			<input class='customFormInput' type='text' name='dot' value='<?php echo $workTerm->dateOfTermination; ?>'>
			<h3 class='customFormLabel'>Wage</h3>
			<input class='customFormInput' type='text' name='pay' value='<?php echo $workTerm->pay; ?>'>
			<h3 class='customFormLabel'>Status</h3>
			<input class='customFormInput' type='text' name='status' value='<?php echo $workTerm->status; ?>'>
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
		<h3 class='customFormLabel'>Select Company</h3>
		<select class='customFormInput' id='cname'>
			<?php echo GenerateCompanyList(false); ?>
		</select>
		<h3 class='customFormLabel'>Season</h3>
		<input class='customFormInput' type='text' name='doh' value='<?php echo $workTerm->dateOfHire; ?>'>
		<h3 class='customFormLabel'>Season Year</h3>
		<input class='customFormInput' type='text' name='doh_detail' value='<?php echo $workTerm->dateOfHire_detail; ?>'>
<?php
		if(strcmp($secLevel, Admin) == 0){
?>
			<h3 class='customFormLabel'>Piece Pay</h3>
			<input class='customFormInput' type='text' name='pay' value='<?php echo $workTerm->pay; ?>'>
			<h3 class='customFormLabel'>Status</h3>
			<input class='customFormInput' type='text' name='status' value='<?php echo $workTerm->status; ?>'>
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
		<h3 class='customFormLabel'>Select Company</h3>
		<select class='customFormInput' id='cname'>
			<?php echo GenerateCompanyList(false); ?>
		</select>
		<h3 class='customFormLabel'>Contract Start Date</h3>
		<input class='customFormInput' type='text' name='doh' value='<?php echo $workTerm->dateOfHire; ?>'>
		<h3 class='customFormLabel'>Contract End Date</h3>
		<input class='customFormInput' type='text' name='dot' value='<?php echo $workTerm->dateOfTermination; ?>'>
		<h3 class='customFormLabel'>Contract Amount</h3>
		<input class='customFormInput' type='text' name='pay' value='<?php echo $workTerm->pay; ?>'>
		<h3 class='customFormLabel'>Status</h3>
		<input class='customFormInput' type='text' name='status' value='<?php echo $workTerm->status; ?>'>
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
function GenerateEmployeeTimeCard($securityLevel, $workTermID, $weekStart){
	
	//Time card code
	$timeCardCode = "";
	
	//Convert the date to a monday
	$weekStart = ConvertDateToMonday($weekStart);

	//Get the work term detail
	$workTerm = GetWorkTerm($workTermID);
	
	//Get the time card
	$timeCard = GetTimeCardInfo($workTermID, $weekStart);
	
	if($workTermID != 0 && strcmp($workTermID, "0") != 0){
	ob_start();
?>
	<h3 class='customFormLabel'>Time Card</h3>
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
			<td><input type='number' name='monHours' value='<?php echo $timeCard[0]->hours["mon"]; ?>'></td>
			<td><input type='number' name='tueHours' value='<?php echo $timeCard[0]->hours["tue"]; ?>'></td>
			<td><input type='number' name='wedHours' value='<?php echo $timeCard[0]->hours["wed"]; ?>'></td>
			<td><input type='number' name='thuHours' value='<?php echo $timeCard[0]->hours["thu"]; ?>'></td>
			<td><input type='number' name='friHours' value='<?php echo $timeCard[0]->hours["fri"]; ?>'></td>
			<td><input type='number' name='satHours' value='<?php echo $timeCard[0]->hours["sat"]; ?>'></td>
			<td><input type='number' name='sunHours' value='<?php echo $timeCard[0]->hours["sun"]; ?>'></td>
		</tr>
<?php
	//Check Employee Type to see if its seasonal to display pieces
	if(strcmp($workTerm->employeeType, Seasonal) == 0){
?>
		<tr>
			<th>Pieces</th>
			<td><input type='number' name='monPieces' value='<?php echo $timeCard[0]->pieces["mon"]; ?>'></td>
			<td><input type='number' name='tuePieces' value='<?php echo $timeCard[0]->pieces["mon"]; ?>'></td>
			<td><input type='number' name='wedPieces' value='<?php echo $timeCard[0]->pieces["mon"]; ?>'></td>
			<td><input type='number' name='thuPieces' value='<?php echo $timeCard[0]->pieces["mon"]; ?>'></td>
			<td><input type='number' name='friPieces' value='<?php echo $timeCard[0]->pieces["mon"]; ?>'></td>
			<td><input type='number' name='satPieces' value='<?php echo $timeCard[0]->pieces["mon"]; ?>'></td>
			<td><input type='number' name='sunPieces' value='<?php echo $timeCard[0]->pieces["mon"]; ?>'></td>
		</tr>
		<tr>
		</tr>
<?php
	}
?>
	</table>
	<button class='customFormInput'>Submit</button>
	<br>
<?php
	echo "For Week Starting: " . $weekStart;
	
	$timeCardCode =  ob_get_clean();
	}

	return $timeCardCode;
}

function GenerateSearchResult($securityLevel, $lastName, $firstName, $SIN){
	
	$tableCode = "";
	
	if(strlen($lastName) == 0 && strlen($firstName) == 0 && strlen($SIN) == 0){		
		$tableCode = "No Result";
	}
	else{
		//Do search
		$searchList = GetEmployeeDetails($lastName, $firstName, $SIN);
		if(sizeof($searchList) == 0){
			$tableCode = "0 Results Found.";
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
<?php
		$resultNumber = 1;
		foreach($searchList as $result){
			echo GenerateSearchResultRow($result, $resultNumber, $securityLevel);
			$resultNumber++;
		}
?>
		</table>
<?php
		$tableCode = ob_get_clean();
		}
	}
	
	return $tableCode;
}

function GenerateSearchResultRow($employeeResult, $resultNumber, $securityLevel){
	$rowCode = "";
	
	ob_start();
?>
	<tr>
		<td>
			<?php echo $employeeResult->lastName . ", " . $employeeResult->firstName . ". (" . $employeeResult->socialInsuranceNumber . ")"; ?>
			<button class='tablink  detailButton' onclick="openTab(event, '<?php echo 'item' . $resultNumber . 'Content'?>')">More...</button>
			<div id='<?php echo 'item' . $resultNumber . 'Content'?>' class='tabcontent'>
				Company: <?php echo $employeeResult->companyName; ?><br>
				Date of Birth: <?php echo $employeeResult->dateOfBirth; ?><br>
				Date of Hire: <?php echo $employeeResult->dateOfHire; ?><br>
<?php
				if(strcmp($securityLevel, Admin) == 0){
?>
					Date of Termination: <?php echo $employeeResult->dateOfTermination; ?><br>
					Pay: <?php echo $employeeResult->pay; ?><br>
					Status: <?php echo $employeeResult->status; ?><br>
<?php
				}
?>
				<button class='tablink detailButton' onclick="closeTab(event, '<?php echo 'item' . $resultNumber . 'Content'?>')">Less...</button>
			</div>
		</td>
		<td>
			<form class='actionForm' action='maintenance.php' method='post'>
				<input type='hidden' name='emp_id' value='<?php echo $employeeResult->employeeID; ?>'/>
				<input type='hidden' name='form_type' value='<?php echo $employeeResult->employeeType; ?>'/>
				<input type='hidden' name='page_type' value='<?php echo EmpForm; ?>'/>
				<button class='actionButton'>Edit...</button>
			</form>
			<form class='actionForm' action='maintenance.php' method='post'>
				<input type='hidden' name='emp_id' value='<?php echo $employeeResult->employeeID; ?>'/>
				<input type='hidden' name='form_type' value='<?php echo $employeeResult->employeeType; ?>'/>
				<input type='hidden' name='page_type' value='<?php echo TimeCard; ?>'/>
				<input type='hidden' name='work_term_id' value='<?php echo $employeeResult->workTermID; ?>'/>
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
	$report = GetReport('Seniority', $company, '');
	
	ob_start();
?>
	<h3 class='customFormLabel'>Seniority Report (<?php echo $company; ?>)</h3>
	<table class='reportResultTable'>
		<tr>
			<th>Employee Name</th>
			<th>SIN</th>
			<th>Type</th>
			<th>Date of Hire</th>
			<th>Years of Service</th>
		</tr>
<?php
	foreach($report as $reportRow){
?>
		<tr>
			<td><?php echo $reportRow->row1; ?></td>
			<td><?php echo $reportRow->row2; ?></td>
			<td><?php echo $reportRow->row3; ?></td>
			<td><?php echo $reportRow->row4; ?></td>
			<td><?php echo $reportRow->row5; ?></td>
		</tr>
<?php
	}
?>
	</table>
<?php	
	$seniorityReportCode = ob_get_clean();
	
	return $seniorityReportCode . GenerateReportEnd($userID);
}

function GenerateWeeklyHoursReport($userID, $company, $date){
	$weeklyHoursReportCode = "";
	
	//Get Report Results
	$report = GetReport('WeeklyHoursWorked', $company, $date);
	
	ob_start();
?>
	<h3 class='customFormLabel'>Weekly Hours Worked Report (<?php echo $company; ?>)</h3>
<?php
	//For each Full Time Employee
	echo GenerateWeeklyHoursReportTable($report, FullTime);
	//Part Time Employees
	echo GenerateWeeklyHoursReportTable($report, PartTime);
	//Seasonal Employees
	echo GenerateWeeklyHoursReportTable($report, Seasonal);
	
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
<?php
		foreach($results as $resultRow){
			if(strcmp($resultRow->row1, $employeeType) == 0){
?>
				<tr>
					<td><?php echo $resultRow->row2; ?></td>
					<td><?php echo $resultRow->row3; ?></td>
					<td><?php echo $resultRow->row4; ?></td>
				</tr>
<?php
			}
		}
?>
	</table>
	<br>
<?php
	
	$tableCode = ob_get_clean();
	
	return $tableCode;
}

function GeneratePayrollReport($userID, $company, $date){
	$payrollReportCode = "";
	
	//Get Report Results
	$report = GetReport('Payroll', $company, $date);
	
	ob_start();
?>
	<h3 class='customFormLabel'>Payroll Report (<?php echo $company; ?>)</h3>
<?php
	//For each Full Time Employee
	echo GeneratePayrollReportTable($report, FullTime);
	//Part Time Employees
	echo GeneratePayrollReportTable($report, PartTime);
	//Seasonal Employees
	echo GeneratePayrollReportTable($report, Seasonal);
	//Contract Employees
	echo GeneratePayrollReportTable($report, Contract);
	
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
<?php
		foreach($results as $resultRow){
			if(strcmp($resultRow->row1, $employeeType) == 0){
?>
		<tr>
			<td><?php echo $resultRow->row2; ?></td>
			<td><?php echo $resultRow->row3; ?></td>
			<td><?php echo $resultRow->row4; ?></td>
			<td><?php echo $resultRow->row5; ?></td>
		</tr>
<?php
			}
		}
?>
	</table>
	<br>
<?php
	
	$tableCode = ob_get_clean();
	
	return $tableCode;
}

function GenerateActiveEmployeeReport($userID, $company){
	$activeReportCode = "";
	
	//Get Report Results
	$report = GetReport('ActiveEmployement', $company, '');
	
	ob_start();
?>
	<h3 class='customFormLabel'>Active Employee Report (<?php echo $company; ?>)</h3>
<?php
	//For each Full Time Employee
	echo GenerateActiveEmployeeReportTable($report, FullTime);
	//Part Time Employees
	echo GenerateActiveEmployeeReportTable($report, PartTime);
	//Seasonal Employees
	echo GenerateActiveEmployeeReportTable($report, Seasonal);
	//Contract Employees
	echo GenerateActiveEmployeeReportTable($report, Contract);
	
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
<?php
		foreach($results as $resultRow){
			if(strcmp($resultRow->row1, $employeeType) == 0){
?>
		<tr>
			<td><?php echo $resultRow->row2; ?></td>
			<td><?php echo $resultRow->row3; ?></td>
			<td><?php echo $resultRow->row4; ?></td>
		</tr>
<?php
			}
		}
?>
	</table>
	<br>
<?php
	
	$tableCode = ob_get_clean();
	
	return $tableCode;
}

function GenerateInactiveEmployeeReport($userID, $company){
	$inactiveReportCode = "";
	
	//Get Report Results
	$report = GetReport('InactiveEmployment', $company, '');
	
	ob_start();
?>
	<h3 class='customFormLabel'>Inactive Employee Report (<?php echo $company; ?>)</h3>
	<table class='reportResultTable'>
		<tr>
			<th>Employee Name</th>
			<th>Hired</th>
			<th>Terminated</th>
			<th>Type</th>
			<th>Reason for Leaving</th>
		</tr>
<?php
		foreach($report as $resultRow){
?>
		<tr>
			<td><?php echo $resultRow->row1; ?></td>
			<td><?php echo $resultRow->row2; ?></td>
			<td><?php echo $resultRow->row3; ?></td>
			<td><?php echo $resultRow->row4; ?></td>
			<td><?php echo $resultRow->row5; ?></td>
		</tr>
<?php
		}
?>
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

function GenerateUserForm($userID){
	$formCode = "";
	
	//Get the username from the id
	
	ob_start();
?>
	<h3 class='customFormLabel'>Username</h3>
	<input class='customFormInput' type='text' name='username' id='username' required>
<?php
	
	$formCode = ob_get_clean();
	
	return $formCode;
}

function GenerateAuditTable($employeeID, $numberOfResults){
	$tableCode = "";
	
	//Get Audit Records
	
	ob_start();
	if(strcmp($employeeID, "0") != 0){
?>
	<h3 class='customFormLabel'>Audit Records For:</h3>
	<table class='reportResultTable'>
		<tr>
			<th>Timestamp</th>
			<th>Username</th>
			<th>Event Type</th>
			<th>Attribute Changed</th>
			<th>Old Value</th>
			<th>New Value</th>
		</tr>
<?php
	//For each audit record
?>
		<tr>
			<th>Date</th>
			<th>Hergott</th>
			<th>MOD</th>
			<th>FNAME</th>
			<th>JUSTIN</th>
			<th>Justin</th>
		</tr>
	</table>
	<br>
<?php
	}
	$tableCode = ob_get_clean();
	
	return $tableCode;
}

function GenerateCompanyForm($companyID){
	$formCode = "";
	
	//Get the company name from the id
	
	ob_start();
?>
	<h3 class='customFormLabel'>Company Name</h3>
	<input class='customFormInput' type='text' name='companyName' id='companyName' required>	
<?php
	
	$formCode = ob_get_clean();
	
	return $formCode;
}
?>