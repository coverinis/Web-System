<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class timeCardInfo
{
	public $employeeID;
	public $cardDate;
	public $hours;
	public $pieces;
	public $pieceComplete;
	
	function __construct($fromDatabase)
	{
		$this->employeeID = $fromDatabase["employeeID"];
		$this->cardDate = $fromDatabase["cardDate"];

		$this->hours["sun"] = $fromDatabase["sunHours"];
		$this->hours["mon"] = $fromDatabase["monHours"];
		$this->hours["tue"] = $fromDatabase["tueHours"];
		$this->hours["wed"] = $fromDatabase["wedHours"];
		$this->hours["thu"] = $fromDatabase["thuHours"];
		$this->hours["fri"] = $fromDatabase["friHours"];
		$this->hours["sat"] = $fromDatabase["satHours"];

		$this->pieces["sun"] = $fromDatabase["sunPieces"];
		$this->pieces["mon"] = $fromDatabase["monPieces"];
		$this->pieces["tue"] = $fromDatabase["tuePieces"];
		$this->pieces["wed"] = $fromDatabase["wedPieces"];
		$this->pieces["thu"] = $fromDatabase["thuPieces"];
		$this->pieces["fri"] = $fromDatabase["friPieces"];
		$this->pieces["sat"] = $fromDatabase["satPieces"];

	}
	
}






?>