<?php 
	class employee {
		
		var $id;
		var $firstName; 
		var $lastName; 
		var $socialInsuranceNumber; 
		var $dateOfBirth;
		
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
			}
		}

		function __construct1($fromDatabase){
			$this->employeeID = $fromDatabase["employeeID"];
			$this->lastName = $fromDatabase["lastName"];
			$this->firstName = $fromDatabase["firstName"];
			$this->socialInsuranceNumber = $fromDatabase["socialInsuranceNumber"];
			$this->dateOfBirth = $fromDatabase["dateOfBirth"];
		}
		
		function __construct4($newLastName, $newFirstName, $newSocialInsuranceNumber, $newDateOfBirth){
			
			$this->lastName = $newLastName;
			$this->firstName = $newFirstName;
			$this->socialInsuranceNumber = $newSocialInsuranceNumber;
			$this->dateOfBirth = $newDateOfBirth;
		}
		
		function setLastName($newLastName) { 
			$this->lastName = $newLastName;  
 		}
 
   		function getLastName() {
			return $this->lastName;
		}
		
		function setFirstName($firstName) { 
			$this->firstName = $firstName;  
 		}
 
   		function getFirstName() {
			return $this->firstName;
		}
		
		function setSocialInsuranceNumber($newSocialInsuranceNumber) { 
			$this->socialInsuranceNumber = $newSocialInsuranceNumber;  
 		}
 
   		function getSocialInsuranceNumber() {
			return $this->socialInsuranceNumber;
		}
		
		function setDateOfBirth($newDateOfBirth) { 
			$this->dateOfBirth = $newDateOfBirth;  
 		}
 
   		function getDateOfBirth() {
			return $this->dateOfBirth;
		}
	}
?>
