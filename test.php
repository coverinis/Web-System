<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Remember to include tools.php in scripts folder
require './scripts/tools.php';

// Initialize the DAL
DAL::Init();
$id = 1;


//$employee = GetEmployeeDetails("Coverini","",""); // This is for seaching
$employee = GetEmployeeDetail($id); // This is for edit
echo $employee->fName;




?>