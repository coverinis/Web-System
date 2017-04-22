<?php 
	include 'employee.php';
	
	class contractEmployee extends employee  
	{
		
		var $contractStartDate;
		var $contractEndDate; 
		var $fixedContractAmount;
		
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
				$this->hourlyRate = 0;
			}
		}
		
		function __construct7($newLastName, $newFirstName, $newSocialInsuranceNumber, $newDateOfBirth, $newContractStartDate, $newContractEndDate, $newFixedContractAmount)
		{
			
			parent::__construct($newLastName, $newFirstName, $newSocialInsuranceNumber, $newDateOfBirth);
			$this->contractStartDate = $newContractStartDate;
			$this->contractEndDate = $newContractEndDate; 
			$this->fixedContractAmount = $newFixedContractAmount;
		}
		
		function setContractStartDate($newContractStartDate) 
		{ 
			$this->contractStartDate = $newContractStartDate;
 		}
 
   		function getContractStartDate() 
		{
			return $this->contractStartDate;
		}
		
		function setContractEndDate($newContractEndDate) 
		{ 
			$this->contractEndDate = $newContractEndDate;
 		}
 
   		function getContractEndDate() 
		{
			return $this->contractEndDate;
		}
		
		function setFixedContractAmount($newFixedContractAmount) 
		{ 
			$this->fixedContractAmount = $newFixedContractAmount;  
 		}
 
   		function getFixedContractAmount() 
		{
			return $this->fixedContractAmount;
		}
	}

?>