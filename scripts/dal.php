<?php

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
		elset
		{
			while($row = $result->fetch_assoc()){
				$ret[] = $row;
			}
		}

		return $ret;
	}



	static function ValidateLogin($userName, $password)
	{	
		$result = self::$conn->query("SELECT pass AS result FROM account WHERE username ='".$userName."'");
		$row = $result->fetch_assoc();

		$ret = false;
		//Check if the password is the same	
		if(strcmp($password, $row['result']) == 0){
			$ret = true;
		}
		
		return $ret;
	}
	
	
	
	
	static function SeachEmployees($lastName, $firstName, $sin)
	{
		$lastNameFilter = $lastName.'%';
		
		$firstNameFilter = $firstName.'%';
		$sinFilter = $sin.'%';
		$first = true;
		
		$query = "SELECT * FROM employee WHERE ";
		
		
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
				$query = $query . "socialInsuranceNumber = " . $sinFilter;
				echo "<script>console.log( 'Debug Objects: " . $query . "' );</script>";
			}				
			else
				$query = $query . " AND sin LIKE '" . $sinFilter . "'";
		}		
		
		
		$query = $query . ';';
		$ret = self::Execute_GetMultipleRows($query);		
		
		return $ret;
	}
	
	
	// This should return list of employees, not workterms
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


	static function GetAllCompany()
	{
		$query = "SELECT * FROM company;";
		
		// run the query
		$ret = self::Execute_GetMultipleRows($query);
		
		return $ret;
	}


	static function GetAllEmployee()
	{
		$query = "SELECT * FROM employees;"

		$ret = self::Execute_GetMultipleRows($query);

		return $ret;
	}


	static function GetAllEmployee_WithoutContractEmployee()
	{
		$query = "SELECT * FROM employees WHERE employeeTypeName!='Contract';"

		$ret = self::Execute_GetMultipleRows($query);

		return $ret;
	}


	static function GetAllWorkTerm($employeeID)
	{
		$query = "SELECT * FROM employees WHERE employeeID=".$employeeID.";";

		$ret = self::Execute_GetMultipleRows($query);

		return $ret;
	}
}
?>