<?php 
	include 'employee.php';
	
	class parttimeEmployee extends employee  {
		
		var $dateOfHire;
		var $dateOfTermination; 
		var $hourlyRate;
		
		function __construct(){
			
			$a = func_get_args();
			$i = func_num_args();
			if (method_exists($this,$f='__construct'.$i)) {
				call_user_func_array(array($this,$f),$a);
			}
			else{
					
				$this->lastName = "";
				$this->firstName = "";
				$this->socialInsuranceNumber = "";
				$this->dateOfBirth = "";
				$this->dateOfHire = "";
				$this->dateOfTermination = ""; 
				$this->hourlyRate = 0;
			}
		}
		
		function __construct7($newLastName, $newFirstName, $newSocialInsuranceNumber, $newDateOfBirth, $newDateOfHire, $newDateOfTermination, $newHourlyRate){
			
			parent::__construct($newLastName, $newFirstName, $newSocialInsuranceNumber, $newDateOfBirth);
			$this->dateOfHire = $newDateOfHire;
			$this->dateOfTermination = $newDateOfTermination; 
			$this->hourlyRate = $newHourlyRate;
		}
		
		function setDateOfHire($newDateOfHire) { 
			$this->dateOfHire = $newDateOfHire;
 		}
 
   		function getDateOfHire() {
			return $this->dateOfHire;
		}
		
		function setDateOfTermination($newDateOfTermination) { 
			$this->dateOfTermination = $newDateOfTermination;
 		}
 
   		function getDateOfTermination() {
			return $this->dateOfTermination;
		}
		
		function setHourlyRate($newHourlyRate) { 
			$this->hourlyRate = $newHourlyRate;  
 		}
 
   		function getHourlyRate() {
			return $this->hourlyRate;
		}
	}

?>