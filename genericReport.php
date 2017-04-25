<?php 
	class genericReport {
		
		var $row1;
		var $row2; 
		var $row3; 
		var $row4; 
		var $row5; 
		var $row6;
		
		
		function __construct($fromDatabase, $reportType){
			switch ($reportType) {
				case 'ActiveEmployement':
					$this->row1 = $fromDatabase["Type"];
					$this->row2 = $fromDatabase["Employee Name"];
					$this->row3 = $fromDatabase["Date of Hire"];
					$this->row4 = $fromDatabase["Avg. Hours"];
					break;
				
				case 'InactiveEmployment':
					$this->row1 = $fromDatabase["Employee Name"];
					$this->row2 = $fromDatabase["Hired"];
					$this->row3 = $fromDatabase["Terminated"];
					$this->row4 = $fromDatabase["Type"];
					$this->row5 = $fromDatabase["Reason for Leaving"];
					break;

				case 'Payroll':
					$this->row1 = $fromDatabase["Employee Type"];
					$this->row2 = $fromDatabase["Employee Name"];
					$this->row3 = $fromDatabase["Hours"];
					$this->row4 = $fromDatabase["Gross"];
					$this->row5 = $fromDatabase["Notes"];
					break;

				case 'Seniority':
					$this->row1 = $fromDatabase["Employee Name"];
					$this->row2 = $fromDatabase["SIN"];
					$this->row3 = $fromDatabase["Type"];
					$this->row4 = $fromDatabase["Date of Hire"];
					$this->row5 = $fromDatabase["Years of Service"];
					break;

				case 'WeeklyHoursWorked':
					$this->row1 = $fromDatabase["Employee Type"];
					$this->row2 = $fromDatabase["Employee Name"];
					$this->row3 = $fromDatabase["SIN"];
					$this->row4 = $fromDatabase["Hours"];
					break;

				case 'Audit':
					$this->row1 = $fromDatabase["eventTimestamp"];
					$this->row2 = $fromDatabase["userID"];
					$this->row3 = $fromDatabase["eventType"];
					$this->row4 = $fromDatabase["attributeName"];
					$this->row5 = $fromDatabase["oldValue"];
					$this->row6 = $fromDatabase["newValue"];
			}
		}


	}
?>
