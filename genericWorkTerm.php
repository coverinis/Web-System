<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


define('SpringStartMonth', 5);
define('SummerStartMonth', 7);
define('FallStartMonth', 9);
define('WinterStartMonth', 12);

class genericWorkTerm
{
	public $workTermID;
	public $employeeID;
	public $firstName;
	public $lastName;
	public $companyName;
	public $socialInsuranceNumber;
	public $dateOfBirth;
	public $dateOfHire;
	public $dateOfHire_detail;
	public $dateOfTermination;
	public $pay;
	public $status;
	public $employeeType;	
	
	
	function __construct($fromDatabase)
	{
		$this->workTermID = $fromDatabase["workTermID"];
		$this->employeeID = $fromDatabase["employeeID"];
		$this->lastName = $fromDatabase["lastName"];
		$this->firstName = $fromDatabase["firstName"];
		$this->companyName = $fromDatabase["companyName"];
		$this->socialInsuranceNumber = $fromDatabase["socialInsuranceNumber"];
		$this->dateOfBirth = $fromDatabase["dateOfBirth"];
		$this->employeeType = $fromDatabase["employeeTypeName"];
		if ($this->employeeType == "Seasonal")
		{
			$time = strtotime($fromDatabase["dateOfHire"]);
			$month = date('m', $time);
			$this->dateOfHire_detail = date('Y', $time);
			switch($month)
			{
				case SpringStartMonth:
					$this->dateOfHire = "Spring";
					break;
					
				case SummerStartMonth:
					$this->dateOfHire = "Summer";
					break;
					
				case FallStartMonth:
					$this->dateOfHire = "Fall";
					break;
				
				case WinterStartMonth:
					$this->dateOfHire = "Winter";
					break;
			}
		}
		else
		{
			//$this->dateOfHire = strtotime($fromDatabase["dateOfHire"]);
			$this->dateOfHire = $fromDatabase["dateOfHire"];
			//$this->dateOfTermination = strtotime($fromDatabase["dateOfTermination"]);
			$this->dateOfTermination = $fromDatabase["dateOfTermination"];
		}
		
		$this->pay = $fromDatabase["pay"];
		$this->status = $fromDatabase["reasonForLeaving"];
		
	}
	
}






?>