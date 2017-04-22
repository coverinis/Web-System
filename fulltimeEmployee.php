<?php 
	include 'employee.php';
	
	class fulltimeEmployee extends employee  
	{
		
		var $dateOfHire;
		var $dateOfTermination; 
		var $salary;
		
		function __construct()
		{
			
			$a = func_get_args();
			$i = func_num_args();
			if (method_exists($this,$f='__construct'.$i)) 
			{
				call_user_func_array(array($this,$f),$a);
			}
			else
			{
					
				$this->lastName = "";
				$this->firstName = "";
				$this->socialInsuranceNumber = "";
				$this->dateOfBirth = "";
				$this->dateOfHire = "";
				$this->dateOfTermination = ""; 
				$this->salary = "";
			}
		}
		
		function __construct7($newLastName, $newFirstName, $newSocialInsuranceNumber, $newDateOfBirth, $newDateOfHire, $newDateOfTermination, $newSalary)
		{
			
			parent::__construct($newLastName, $newFirstName, $newSocialInsuranceNumber, $newDateOfBirth);
			$this->dateOfHire = $newDateOfHire;
			$this->dateOfTermination = $newDateOfTermination; 
			$this->salary = $newSalary;
		}
		
		function setDateOfHire($newDateOfHire) 
		{ 
			$this->dateOfHire = $newDateOfHire;
 		}
 
   		function getDateOfHire() 
		{
			return $this->dateOfHire;
		}
		
		function setDateOfTermination($newDateOfTermination) 
		{ 
			$this->dateOfTermination = $newDateOfTermination;
 		}
 
   		function getDateOfTermination() 
		{
			return $this->dateOfTermination;
		}
		
		function setSalary($newSalary) 
		{ 
			$this->Salary = $newSalary;  
 		}
 
   		function getSalary() 
		{
			return $this->salary;
		}
	}

?>