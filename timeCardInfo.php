<?php

class timeCardInfo
{
	public $employeeID;
	public $cardDate;
	public $hours;
	public $pieces;
	public $pieceComplete;
	
	function __construct1($fromDatabase)
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

		$this->pieces["sun"] = $fromDatabase["sunPiece"];
		$this->pieces["mon"] = $fromDatabase["monPiece"];
		$this->pieces["tue"] = $fromDatabase["tuePiece"];
		$this->pieces["wed"] = $fromDatabase["wedPiece"];
		$this->pieces["thu"] = $fromDatabase["thurPiece"];
		$this->pieces["fri"] = $fromDatabase["friPiece"];
		$this->pieces["sat"] = $fromDatabase["satPiece"];

	}
	
}






?>