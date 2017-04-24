<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Remember to include tools.php in scripts folder
require './scripts/tools.php';

// Initialize the DAL
DAL::Init();
$id = 1;


//$employee = GetEmployeeDetails("Coverini","",""); // This is for seaching
$timecard = GetTimeCardInfo(1, '2017-04-23'); // This is for edit
echo $timecard[0]->cardDate;




?>