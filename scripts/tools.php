<?php
require 'dal.php';
require './genericEmployee.php';


function GetEmployeeDetails($lastName, $firstName, $sin){
	$fromDatabase = DAL::SeachEmployees($lastName, $firstName, $sin);
	$ret = array();
	$i = 0;
	foreach($fromDatabase as $employee)
	{
		$ret[$i] = new genericEmployee($employee);
		$i++;
	}
	return $ret;
}


function GetEmployeeDetail($id){
	$fromDatabase = DAL::SeachEmployee($id);
	$ret = new genericEmployee($fromDatabase);
	return $ret;
}


?>