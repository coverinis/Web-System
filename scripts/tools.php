<?php
require 'dal.php';
require './genericWorkTerm.php';
require './genericCompany.php';
require './employee.php';
require './user.php';
require './timeCardInfo.php';

define('Employee', 1);
define('Workterm', 2);
define('Company', 3);
define('User', 4);
define('TimeCardInfo', 5);

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
		}
		
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



function EmployeeMaintainance($employeeID, $firstName, $lastName, $socialInsuranceNumber, $dateOfBirth){

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


function EmployeeValidation($emp)
{

}


function ErrorCodeToMessage($errorCode){

}	
?>