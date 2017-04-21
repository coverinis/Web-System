<?php 
	class employee {
		
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
		
		function validateName($name) {
			
            // allowed characters are letters "'" and "-"
            // min 1 character, max 20 characters
			return preg_match("/^([A-Za-z'-]){1,20}$/", $name);
		}
	}
	// test code
	//$e = new employee("walters","zach","123456782","1993-11-05");
	//$e->setFirstName("name");
	//print($e->getFirstName());
	//print($e->getLastName());
	//print($e->validateName("zach"));
	//print($e->validateName("234234"));
?>