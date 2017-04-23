<?php
define('SpringStartDate', '1');
define('SummerStartDate', '4');
define('FallStartDate', '7');
define('WinterStartDate', '10');

class genericWorkTerm
{
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
				case SpringStartDate:
					$this->dateOfHire = "Spring";
					break;
					
				case SummerStartDate:
					$this->dateOfHire = "Summer";
					break;
					
				case FallStartDate:
					$this->dateOfHire = "Fall";
					break;
				
				case WinterStartDate:
					$this->dateOfHire = "Winter";
					break;
			}
		}
		else
		{
			$this->dateOfHire = strtotime($fromDatabase["dateOfHire"]);
			$this->dateOfTermination = strtotime($fromDatabase["dateOfTermination"]);
		}
		
		$this->pay = $fromDatabase["pay"];
		$this->status = $fromDatabase["reasonForLeaving"];
		
	}
	
}






?>