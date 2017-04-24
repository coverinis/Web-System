<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'dal.php';
require './validation.php';
require './genericWorkTerm.php';
require './genericCompany.php';
require './employee.php';
require './user.php';
require './timeCardInfo.php';
require './genericReport.php';

define('Employee', 1);
define('Workterm', 2);
define('Company', 3);
define('User', 4);
define('TimeCardInfo', 5);
define('Report', 6);

define('Invalid_LastName', 1);
define('Invalid_FirstName', 2);
define('Invalid_DateOfBirth', 3);
define('Invalid_SocialInsuranceNumber', 4);


// This is used within this class only
function ParseToGenericArray($fromDatabase, $type){
	$ret = array();
	$i = 0;
	foreach($fromDatabase as $row)
	{
		switch ($type) {
			case Employee:
				$ret[$i] = new employee($row);
				break;
			
			case Workterm:
				$ret[$i] = new genericWorkTerm($row);
				break;

			case Company:
				$ret[$i] = new genericCompany($row);
				break;

			case User:
				$ret[$i] = new user($row);
				break;

			case TimeCardInfo:
				$ret[$i] = new timeCardInfo($row);
				break;

			case Report:
				$ret[$i] = new genericReport($row);
				break;
		}
		
		$i++;
	}

	return $ret;
}


function ParseToGenericArray_Report($fromDatabase, $reportType){
	$ret = array();
	$i = 0;

	foreach($fromDatabase as $row)
	{
		$ret[$i] = new genericReport($row, $reportType);	
		$i++;	
	}

	return $ret;
}



// Get employee's workterm detail
// Params: lName, fName, sin
// Return: list of employee objects
function GetEmployeeDetails($lastName, $firstName, $sin){
	$fromDatabase = DAL::SeachEmployees($lastName, $firstName, $sin);
	return ParseToGenericArray($fromDatabase, Workterm);
}


// Get employee's workterm detail
// Params: lName, fName, sin
// Return: list of employee object(s)
function GetEmployeeDetail($id){
	$fromDatabase = DAL::SeachEmployee($id);
	$ret = new employee($fromDatabase);
	return $ret;
}

function GetEmployeeList($securityLevel){

	$fromDatabase = array();
	
	if (strcmp($securityLevel, 'Administrator'))
	{
		$fromDatabase = DAL::GetAllEmployee();
	}
	else
	{
		$fromDatabase = DAL::GetAllEmployee_WithoutContractEmployee();
	}

	return ParseToGenericArray($fromDatabase, Workterm);
}

function GetCompanyList(){
	$fromDatabase = DAL::GetAllCompany();
	return ParseToGenericArray($fromDatabase, Company);
}


function GetWorkTermList($employeeID, $securityLevel){	
	$fromDatabase = array();
	if (strcmp($securityLevel, 'Administrator'))
	{
		$fromDatabase = DAL::GetAllWorkTerm($employeeID);
	}
	else
	{
		$fromDatabase = DAL::GetAllWorkTerm_WithoutContractEmployee($employeeID);
	}

	return ParseToGenericArray($fromDatabase, Workterm);
}


function GetWorkTerm($workTermID){
	$fromDatabase = DAL::SearchWorkTerm($workTermID);
	$ret = new genericWorkTerm($fromDatabase);
	return $ret;
}



function GetUserList(){
	$fromDatabase = DAL::GetAllUser();
	return ParseToGenericArray($fromDatabase, User);
}



function GetTimeCardInfo($workTermID, $weekStartDate){
	$fromDatabase = DAL::GetTimeCard($workTermID, $weekStartDate);
	return ParseToGenericArray($fromDatabase, TimeCardInfo);
}


function GetReport($reportType, $companyName, $cardDate){
	$fromDatabase = array();
	switch ($reportType) {
		case 'ActiveEmployement':
			$fromDatabase = DAL::GetReport_ActiveEmployement($companyName);
			break;
		
		case 'InactiveEmployment':
			$fromDatabase = DAL::GetReport_InactiveEmployement($companyName);
			break;

		case 'Payroll':
			$fromDatabase = DAL::GetReport_Payroll($companyName, $cardDate);
			break;

		case 'Seniority':
			$fromDatabase = DAL::GetReport_Seniority($companyName);
			break;

		case 'WeeklyHoursWorked':
			$fromDatabase = DAL::GetReport_WeeklyHoursWorked($companyName, $cardDate);
			break;
	}

	return ParseToGenericArray_Report($fromDatabase, $reportType);
	
}





function EmployeeMaintainance($employeeID, $firstName, $lastName, $socialInsuranceNumber, $dateOfBirth){

	// validate the employee
	$returnCode = 0;
	if (strcmp($firstName,'') == 0)
	{
		// contract employee
		$returnCode = validateBaseContractEmployee($lastName, $socialInsuranceNumber, $dateOfBirth);
	}
	else
	{
		// other types of employee
		$returnCode = validateBaseEmployee($firstName, $lastName, $socialInsuranceNumber, $dateOfBirth);
	}

	if ($returnCode != 0)
	{
		return ErrorCodeToMessage($returnCode);
	}


	/*$emp = new employee();
	if (strcmp($firstName,'') == 0)
	{
		// contract employee
		$emp = new employee($employeeID, $firstName, $lastName, $socialInsuranceNumber, $dateOfBirth);
	}
	else
	{
		// other types of employee
		$emp = new employee($employeeID, $firstName, $lastName, $socialInsuranceNumber, $dateOfBirth);
	}*/

	
	// if OK
	if ($employeeID == 0)
	{
		// Inserting
		$returnCode = DAL::InsertEmployee($firstName, $lastName, $socialInsuranceNumber, $dateOfBirth);
	}
	else
	{
		// updating
		$returnCode = DAL::UpdateEmployee($employeeID, $firstName, $lastName, $socialInsuranceNumber, $dateOfBirth);
	}

	$ret = array();
	if ($returnCode != 0)
	{
		$ret[0] = "Database error. Please try again later";
	}
	
	

	return $returnCode;
}


function WorkTermMaintenance($workTermIDs, $employeeID, $firstName, $lastName, $socialInsuranceNumber, $dateOfBirth){

	/*$emp = new employee($employeeID, $firstName, $lastName, $socialInsuranceNumber, $dateOfBirth);
	$returnCode = EmployeeValidation($emp);
	if ($returnCode == OK)
	{
		// if OK
		if ($employeeID == 0)
		{
			// Inserting
			$returnCode = DAL::InsertEmployee($firstName, $lastName, $socialInsuranceNumber, $dateOfBirth);
		}
		else
		{
			// updating
			$returnCode = DAL::UpdateEmployee($firstName, $lastName, $socialInsuranceNumber, $dateOfBirth);
		}
	}
	else
	{
		// if not OK
	}
	

	return $returnCode;*/



}


function ErrorCodeToMessage($errorCode){
	$ret = array();
	if(($errorCode & kInvalidFirstName) != 0){
		$ret[] = "Invalid First Name.";
	}
	if(($errorCode & kInvalidLastName) != 0){
		$ret[] = "Invalid Last Name.";
	}
	if(($errorCode & kInvalidSIN) != 0){
		$ret[] = "Invalid Social Insurance Number.";
	}
	if(($errorCode & kInvalidDateOfBirth) != 0){
		$ret[] = "Invalid Date of Birth.";
	}
	if(($errorCode & kInvalidDateOfHire) != 0){
		$ret[] = "Invalid Date of Hire.";
	}
	if(($errorCode & kInvalidDateOfTermination) != 0){
		$ret[] = "Invalid Date of Termination.";
	}
	if(($errorCode & kInvalidPay) != 0){
		$ret[] = "Invalid Pay amount.";
	}
	if(($errorCode & kInvalidSeason) != 0){
		$ret[] = "Invalid Season.";
	}
	if(($errorCode & kInvalidBusinessNumber) != 0){
		$ret[] = "Invalid Business Number.";
	}

	return $ret;
}	
?>