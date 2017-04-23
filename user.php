<?php

class user
{
	public $userID;
	public $firstName;
	public $lastName;
	
	function __construct1($fromDatabase)
	{
		$this->userID = $fromDatabase["userID"];
		$this->lastName = $fromDatabase["lastName"];
		$this->firstName = $fromDatabase["firstName"];		
	}
	
}






?>