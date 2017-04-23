<?php
define('SpringStartDate', '1');
define('SummerStartDate', '4');
define('FallStartDate', '7');
define('WinterStartDate', '10');

class genericEmployee
{
	public $id;
	public $fName;
	public $lName;
	public $cName;
	public $sin;
	public $dob;
	public $doh;
	public $doh_detail;
	public $dot;
	public $pay;
	public $status;
	public $type;	
	
	
	function __construct($fromDatabase)
	{
		$this->id = $fromDatabase["employeeID"];
		$this->lName = $fromDatabase["lastName"];
		$this->fName = $fromDatabase["firstName"];
		$this->cName = $fromDatabase["companyName"];
		$this->sin = $fromDatabase["socialInsuranceNumber"];
		$this->dob = $fromDatabase["dateOfBirth"];
		$this->type = $fromDatabase["employeeTypeName"];
		if ($this->type == "Seasonal")
		{
			$time = strtotime($fromDatabase["dateOfHire"]);
			$month = date('m', $time);
			$this->doh_detail = date('Y', $time);
			switch($month)
			{
				case SpringStartDate:
					$this->doh = "Spring";
					break;
					
				case SummerStartDate:
					$this->doh = "Summer";
					break;
					
				case FallStartDate:
					$this->doh = "Fall";
					break;
				
				case WinterStartDate:
					$this->doh = "Winter";
					break;
			}
		}
		else
		{
			$this->doh = strtotime($fromDatabase["dateOfHire"]);
			$this->dot = strtotime($fromDatabase["dateOfTermination"]);
		}
		
		$this->pay = $fromDatabase["pay"];
		$this->status = $fromDatabase["reasonForLeaving"];
		
	}
	
}






?>