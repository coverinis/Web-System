<?php 
	include 'employee.php';
	
	class seasonalEmployee extends employee  {
		
		var $season;
		var $piecePay;
		
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
				$this->season = 0;
				$this->piecePay = 0; 
			}
		}
		
		function __construct6($newLastName, $newFirstName, $newSocialInsuranceNumber, $newDateOfBirth, $newSeason, $newPiecePay){
			
			parent::__construct($newLastName, $newFirstName, $newSocialInsuranceNumber, $newDateOfBirth);
			$this->season = $newSeason;
			$this->piecePay = $newPiecePay;
		}
		
		function setSeason($newSeason) { 
			$this->season = $newSeason;
 		}
 
   		function getSeason() {
			return $this->season;
		}
		
		function setPiecePay($newPiecePay) { 
			$this->piecePay = $newPiecePay;
 		}
 
   		function getPiecePay() {
			return $this->piecePay;
		}
	}

?>