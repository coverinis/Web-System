<?php
require 'dal.php';
require './genericWorkTerm.php';
require './genericCompany.php';
require './employee.php';

define('Employee', 1);
define('WorkTerm', 2);
define ('Company', 3);

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
			
			case WorkTerm:
				$ret[$i] = new genericWorkTerm($row);
				break;

			case Company:
				$ret[$i] = new genericCompany($row);
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
	return ParseToGenericArray($fromDatabase, Employee);
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
	
	if (strcmp($securityLevel, 'Admin'))
	{
		$fromDatabase = DAL::GetAllEmployee();
	}
	else
	{
		$fromDatabase = DAL::GetAllEmployee_WithoutContractEmployee();
	}

	return ParseToGenericArray($fromDatabase, true);
}

function GetCompanyList(){
	$fromDatabase = DAL::GetAllCompany();
	return $ParseToGenericArray($fromDatabase, Company);
}


function GetWorkTermList($employeeID){
	$fromDatabase = DAL::GetAllCompany();
	return $ParseToGenericArray($fromDatabase, WorkTerm);
}




?>