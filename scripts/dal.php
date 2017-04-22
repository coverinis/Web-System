<?php

public class DAL {
		
	public static $conn;
	public static $initialized = false;
	
	static function Init()
	{
		if (self::$initialized)
            return;		
		
		$conn = new mysqli("192.168.174.1", "newuser", "newuser", "websiteLogins");
	}
	
	
	
	
	static function ValidateLogin($userName, $password)
	{	
		$result = $conn->query("SELECT pass AS result FROM account WHERE username ='".$userName."'");
		$row = $result->fetch_assoc();

		$ret = false;
		//Check if the password is the same	
		if(strcmp($password, $row['result']) == 0){
			ret = true;
		}
		
		return ret;
	}
	
	
	
	
	static function SeachEmployees($lastName, $firstName, $sin)
	{
		$lastNameFilter = $lastName.'%';
		$firstNameFilter = $firstName.'%';
		$sinFilter = $sin.'%';
		$first = true;
		$query = "SELECT * FROM Employee WHERE ";
		
		
		if (strcmp($lastName, "") == 0)
		{
			$query = $query . 'lastName LIKE \'' . $lastNameFilter . '\'';
			$first = false;
		}
		if (strcmp($firstName, "") == 0)
		{
			if ($first)
				$query = $query . 'firstName LIKE \'' . $firstNameFilter . '\'';
				$first = false;
			else
				$query = $query . ' AND firstName LIKE \'' . $firstNameFilter . '\'';
		}
		if (strcmp($sinFilter, "") == 0)
		{
			if ($first)
				$query = $query . 'sin LIKE \'' . $sinFilter . '\'';
			else
				$query = $query . ' AND sin LIKE \'' . $sinFilter . '\'';
		}		
		
		// run the query
		$result = $conn->query($query);
		
		// get returned values and send it back
	}
		

}





?>