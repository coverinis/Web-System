<?php
require './dal.php'
require '../genericEmployee.php'


function GetEmployeeDetails($lastName, $firstName, $sin){
	$fromDatabase = DAL::SeachEmployee($lastName, $firstName, $sin);
	$ret = array();
	foreach($fromDatabase as $employee)
	{
		$ret[] = new genericEmployee($employee);
	}
	return $ret;
}


function GetEmployeeDetails($id){
	$fromDatabase = DAL::SeachEmployee($id);
	$ret = new genericEmployee($fromDatabase);
	return $fromDatabase;
}


?>