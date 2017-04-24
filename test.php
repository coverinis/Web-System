<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Remember to include tools.php in scripts folder
require './scripts/tools.php';

// Initialize the DAL
DAL::Init();
$id = 1;


//$employee = GetEmployeeDetails("Coverini","",""); // This is for seaching
$ret = GetReport('ActiveEmployement', 'Conestoga College', '');
echo $ret[0]->row1;



?>