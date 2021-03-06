<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class DAL {
		
	public static $conn;
	public static $initialized = false;
	
	static function Init()
	{
		if (self::$initialized)
            return;		
		self::$conn = new mysqli("localhost", "root", "Conestoga1", "ems_pss");
	}
	
	static function Execute_GetMultipleRows($query)
	{
		$result = self::$conn->query($query);
		$ret = array();
		if (!$result) {

		}
		else
		{
			while($row = $result->fetch_assoc()){
				$ret[] = $row;
			}
		}

		return $ret;
	}
	
	static function ValidateLogin($userID, $password)
	{	
		$result = self::$conn->query("SELECT pass AS result FROM users WHERE userID ='".$userID."'");
		$row = $result->fetch_assoc();

		$ret = false;
		//Check if the password is the same	
		if(strcmp($password, $row['result']) == 0){
			$ret = true;
		}
		
		return $ret;
	}
	
	static function GetUserDetails($userID)
	{	
		$result = self::$conn->query("SELECT firstName, lastName, userTypeName FROM users JOIN usertype ON users.userTypeID = usertype.userTypeID WHERE userID ='".$userID."'");
		
		$row = $result->fetch_assoc();
		$ret = array(
			"firstName" => $row["firstName"],
			"lastName" => $row["lastName"],
			"userType" => $row["userTypeName"]
		);
		
		return $ret;
	}
	
	
	static function SeachEmployees($lastName, $firstName, $sin)
	{
		$lastNameFilter = $lastName.'%';
		
		$firstNameFilter = $firstName.'%';
		$sinFilter = $sin.'%';
		$first = true;
		
		$query = "SELECT * FROM employeeWorkterm WHERE ";
		
		
		if (strcmp($lastName, "") != 0)
		{			
			$query = $query . "lastName LIKE '" . $lastNameFilter . "'";
			$first = false;
		}
		
		if (strcmp($firstName, "") != 0)
		{
			if ($first)
			{
				$query = $query . "firstName LIKE '" . $firstNameFilter . "'";
				$first = false;
			}
			else
			{
				$query = $query . " AND firstName LIKE '" . $firstNameFilter . "'";
			}
		}
		
		if (strcmp($sin, "") != 0)
		{
			if ($first)
			{				
				$query = $query . "CAST(socialInsuranceNumber as CHAR) LIKE '" . $sinFilter . "';";
			}				
			else
				$query = $query . " AND CAST(socialInsuranceNumber as CHAR) LIKE '" . $sinFilter . "';";
		}		
		
		
		$query = $query . ';';
		//echo "<script>console.log( 'Debug Objects: '" . $query . "'' );</script>";
		// run the query
		$result = self::$conn->query($query);
		$ret = array();
		if (!$result) {
				
		}
		else
		{
			while($row = $result->fetch_assoc()){
				$ret[] = $row;		
			}
		}
		
		
		return $ret;
	}
	
	
	
	static function SeachEmployee($id)
	{
		$query = "SELECT * FROM employee WHERE employeeID=".$id.";";
		
		// run the query
		$result = self::$conn->query($query);
		$ret = array();
		if (!$result) {
				
		}
		else
		{
			while($row = $result->fetch_assoc()){
				$ret = $row;	
				break;
			}
		}
		
		return $ret;
	}


	
	static function SearchWorkTerm($id)
	{
		$query = "SELECT * FROM employeeWorkterm WHERE worktermID=".$id.";";
		
		// run the query
		$result = self::$conn->query($query);
		$ret = array();
		if (!$result) {
				
		}
		else
		{
			while($row = $result->fetch_assoc()){
				$ret = $row;	
				break;
			}
		}
				
		return $ret;
	}
		
	static function GetAllCompany()
	{
		$query = "SELECT * FROM company;";
		
		// run the query
		$ret = self::Execute_GetMultipleRows($query);
		
		return $ret;
	}


	static function GetAllEmployee()
	{
		$query = "SELECT * FROM employeeWorkterm GROUP BY employeeID;";

		$ret = self::Execute_GetMultipleRows($query);

		return $ret;
	}


	static function GetAllEmployee_WithoutContractEmployee()
	{
		$query = "SELECT * FROM employeeWorkterm WHERE employeeTypeName!='Contract' GROUP BY employeeID;";

		$ret = self::Execute_GetMultipleRows($query);

		return $ret;
	}


	static function GetAllWorkTerm($employeeID)
	{
		$query = "SELECT * FROM employeeWorkterm WHERE employeeID=".$employeeID.";";

		$ret = self::Execute_GetMultipleRows($query);

		return $ret;
	}

	static function GetAllWorkTerm_WithoutContractEmployee($employeeID)
	{
		$query = "SELECT * FROM employeeWorkterm WHERE employeeID=".$employeeID." AND employeeTypeName!='Contract';";

		$ret = self::Execute_GetMultipleRows($query);

		return $ret;
	}

	static function GetAllUser()
	{
		$query = "SELECT * FROM users;";

		$ret = self::Execute_GetMultipleRows($query);

		return $ret;
	}

	static function GetTimeCard($worktermID, $startDate)
	{
		$query = "SELECT * FROM employeeTimeCardInfo WHERE worktermID=".$worktermID." AND cardDate='".$startDate."';";
		$ret = self::Execute_GetMultipleRows($query);
		return $ret;
	}

	static function GetReport_ActiveEmployement($companyName)
	{
		$query = "CALL getActiveEmploymentReport('". $companyName ."');";
		$ret = self::Execute_GetMultipleRows($query);		
		return $ret;
	}

	static function GetReport_InactiveEmployement($companyName)
	{
		$query = "CALL getInactiveEmploymentReport('". $companyName ."');";
		$ret = self::Execute_GetMultipleRows($query);		
		return $ret;
	}

	static function GetReport_Payroll($companyName, $cardDate)
	{
		$query = "CALL getPayrollReport('". $companyName ."', '". $cardDate ."');";
		$ret = self::Execute_GetMultipleRows($query);		
		return $ret;
	}

	static function GetReport_Seniority($companyName)
	{
		$query = "CALL getSeniorityReport('". $companyName ."');";
		$ret = self::Execute_GetMultipleRows($query);		
		return $ret;
	}


	static function GetReport_WeeklyHoursWorked($companyName, $cardDate)
	{
		$query = "CALL getWeeklyHoursWorkedReport('". $companyName ."', '". $cardDate ."');";
		$ret = self::Execute_GetMultipleRows($query);		
		return $ret;
	}

	static function GetEmployeeAudit($employeeID, $numOfResults)
	{
		$query = "CALL getAuditEmployeeReport(". $employeeID .", ". $numOfResults .");";
		$ret = self::Execute_GetMultipleRows($query);		
		return $ret;
	}


	static function InsertEmployee($firstName, $lastName, $socialInsuranceNumber, $dateOfBirth)
	{
		$query = "INSERT INTO employee(firstName, lastName, socialInsuranceNumber, dateOfBirth, incomplete) VALUES('".$firstName."', '".$lastName."', '".$socialInsuranceNumber."', '".$dateOfBirth."', 0);";
		$succeeded = self::$conn->query($query);


	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }
		
		return $ret;
		
	}



	static function UpdateEmployee($employeeID, $firstName, $lastName, $socialInsuranceNumber, $dateOfBirth)
	{
		$query = "UPDATE employee SET firstName='".$firstName."', lastName='".$lastName."', socialInsuranceNumber='".$socialInsuranceNumber."', dateOfBirth='".$dateOfBirth."', incomplete=0 WHERE employeeID=".$employeeID.";";
		$succeeded = self::$conn->query($query);


	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }
		
		return $ret;		
	}


	static function InsertWorkTerm($employeeTypeID, $employeeID, $companyName, $dateOfHire, $dateOfTermination, $pay, $status)
	{
		$query = "INSERT INTO workterm(employeeTypeID, employeeID, companyID, dateOfHire, dateOfTermination, pay, reasonForLeaving, incomplete) 
					VALUES(".$employeeTypeID.", ".$employeeID.", (SELECT companyID FROM company WHERE companyName='".$companyName."'), '".$dateOfHire."', ".$dateOfTermination.", ".$pay.", ".$status.", 0)";

		
	    $succeeded = self::$conn->query($query);


	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }
		
		return $ret;	
	}



	static function UpdateWorkTerm($worktermID, $employeeTypeID, $employeeID, $companyName, $dateOfHire, $dateOfTermination, $pay, $status)
	{
		$query = "UPDATE workterm SET employeeTypeID=".$employeeTypeID.", employeeID=".$employeeID.", companyID=(SELECT companyID FROM company WHERE companyName='".$companyName."'), dateOfHire='".$dateOfHire."', dateOfTermination=".$dateOfTermination.", pay=".$pay.", reasonForLeaving=".$status." WHERE worktermID=".$worktermID.";";

		
	    $succeeded = self::$conn->query($query);


	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }
		
		return $ret;	
	}


	static function CheckTimeCard($worktermID, $cardDate)
	{
		$query = "SELECT COUNT(*) FROM timecard WHERE worktermID=".$worktermID." AND cardDate='".$cardDate."';";
		
	    $result = self::$conn->query($query);
	    $row = $result->fetch_row();

	    return $row[0];
	}


	static function InsertTimeCard($worktermID, $cardDate, $hours, $pieces)
	{
		$query = "INSERT INTO timecard(worktermID, cardDate, sunHours, monHours, tueHours, wedHours, thuHours, friHours, satHours, sunPieces, monPieces, tuePieces, wedPieces, thuPieces, friPieces, satPieces) VALUES(".$worktermID.", '".$cardDate."', ".$hours['sun'].", ".$hours['mon'].", ".$hours['tue'].", ".$hours['wed'].", ".$hours['thu'].", ".$hours['fri'].", ".$hours['sat'].", ".$pieces['sun'].", ".$pieces['mon'].", ".$pieces['tue'].", ".$pieces['wed'].", ".$pieces['thu'].", ".$pieces['fri'].", ".$pieces['sat'].");";
		echo $query;
		$succeeded = self::$conn->query($query);

	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }

	    return $ret;
	}

	static function UpdateTimeCard($worktermID, $cardDate, $hours, $pieces)
	{
		$query = "UPDATE timecard SET sunHours=".$hours['sun'].", monHours=".$hours['mon'].", tueHours=".$hours['tue'].", wedHours=".$hours['wed'].", thuHours=".$hours['thu'].", friHours=".$hours['fri'].", satHours=".$hours['sat'].", sunPieces=".$pieces['sun'].", monPieces=".$pieces['mon'].", tuePieces=".$pieces['tue'].", wedPieces=".$pieces['wed'].", thuPieces=".$pieces['thu'].", friPieces=".$pieces['fri'].", satPieces=".$pieces['sat']." WHERE worktermID=".$worktermID." AND cardDate='".$cardDate."';";

		$succeeded = self::$conn->query($query);

	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }

	    return $ret;
	}


	static function InsertUser($firstName, $lastName, $password, $userTypeID)
	{
		$query = "INSERT INTO users(firstName, lastName, pass, userTypeID, active) VALUES('".$firstName."', '".$lastName."', '".$password."', ".$userTypeID.", 1);";

		echo $query;
		
		$succeeded = self::$conn->query($query);

	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }

	    return $ret;
	}

	static function UpdateUser($userID, $firstName, $lastName, $password, $userTypeID)
	{

		$query = "UPDATE users SET firstName='".$firstName."', lastName='".$lastName."', pass='".$password."', userTypeID=".$userTypeID." WHERE userID=".$userID.";";


		echo $query;
		
		$succeeded = self::$conn->query($query);

	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }

	    return $ret;

	}



	static function InsertCompany($companyName)
	{
		$query = "INSERT INTO company(companyName) VALUES('".$companyName."');";

		echo $query;
		
		$succeeded = self::$conn->query($query);

	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }

	    return $ret;
	}

	static function UpdateCompany($companyID, $companyName)
	{

		$query = "UPDATE company SET companyName='".$companyName."' WHERE companyID=".$companyID.";";


		echo $query;
		
		$succeeded = self::$conn->query($query);

	    $ret = 0;
	    if (!$succeeded)
	    {
	    	$ret = 1;
	    }

	    return $ret;

	}


}
?>