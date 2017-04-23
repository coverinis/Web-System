<?php

class genericCompany
{
	public $id;
	public $name;	
	
	function __construct($fromDatabase)
	{
		$this->id = $fromDatabase["companyID"];
		$this->name = $fromDatabase["companyName"];
	}
	
}






?>