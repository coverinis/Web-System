<?php 

	// first and last name
	function validateName($name) 
	{
		// allowed characters are letters "'" and "-"
		// min 1 character, max 20 characters
		return preg_match("/^([A-Za-z'-]){1,20}$/", $name);
	}

	function validateSocialInsuranceNumber($SIN)
	{
		$valid = false;
        // social Insurance Number must be nine digits long
		if(preg_match("/^[0-9]{9}$/", $SIN) == 1)
		{
			$array = str_split($SIN);
			
            // Take the number in the even positions and multiply by 2.
			for ($i = 1; $i < 8; $i+=2) 
			{
				$array[$i] *= 2;
			}
			$checkDigit = 0;
			// Take number from step 1 and add each digit. (ie.  If the number is 12, then add 1 and 2 to get 3)
			for ($i = 1; $i < 8; $i+=2) 
			{
				if($array[$i] >= 10) 
				{
					$ones = $array[$i] % 10;
					$tens = floor($array[$i] / 10);
					$checkDigit += $ones + $tens;
				}
				else
				{
					$checkDigit += $array[$i];
				}
			}
			// Take the number in the odd position and add them, not including the check digit (9th digit).
			for ($i = 0; $i < 8; $i += 2) 
			{
				$checkDigit += $array[$i];
            }
			// the next highest number ending with 0
			$nextHighestNumber = $checkDigit;
			// loop until nextHighestNumber is a multiple of 10
			while (($nextHighestNumber % 10) != 0)
            {
				$nextHighestNumber++;
            }
			//Subtract the number from Step 4 from the next highest number ending with 0 (ie. 40).  
            //This number should be your last digit of your SIN.
			if (($nextHighestNumber - $checkDigit) == $array[8])
            {
				$valid = true;
            }
			
		}
		return $valid;
	}
	
	function validateDate($date)
	{
		$yearMonthDay = explode('-', $date, 3);
		
		// the date is a valid date
		return checkdate ($yearMonthDay[1] , $yearMonthDay[2], $yearMonthDay[0]);
	}
	
	function validatePastDate($date)
	{
		$now = new DateTime();
		return validateEarlierDate($date, $now->format('Y-m-d'));
	}
	
	function validateEarlierDate($earlierDate, $laterDate)
	{
		$soonerYearMonthDay = explode('-', $earlierDate, 3);
		$laterYearMonthDay = explode('-', $laterDate, 3);
		$valid = false;
		// the date is a valid date
		if((checkdate ($soonerYearMonthDay[1] , $soonerYearMonthDay[2], $soonerYearMonthDay[0]) == true) &&
			(checkdate ($laterYearMonthDay[1] , $laterYearMonthDay[2], $laterYearMonthDay[0]) == true))
		{
			$past = new DateTime($earlierDate);
			$now = new DateTime($laterDate);
			// the date is in the past
			if($past <= $now)
			{
				$valid = true;
			}
		}
		return $valid;
	}
	
	function validateCompanyName($companyName)
	{
		return preg_match("/^[^\/|]{1,40}$/", $companyName);
	}
	
	function validateBusinessNumber($dateOfIncorporation, $businessNumber)
	{
		$valid = false;
		$dateOfIncorporationArray = str_split($dateOfIncorporation);
		$businessNumberArray = str_split($businessNumber);
		
		if((sizeof($dateOfIncorporationArray) >= 4) &&
			(sizeof($businessNumberArray) >= 2) && 
			($businessNumberArray[0] == $dateOfIncorporationArray[2]) &&
			($businessNumberArray[1] == $dateOfIncorporationArray[3]))
		{
			
			$valid = validateSocialInsuranceNumber($businessNumber);
		}
		return $valid;
	}
	
	function validateSeason($startDate, $endDate)
	{
		$valid = false;
		
		$past = new DateTime($startDate);
		$now = new DateTime($endDate);
		$interval = $past->diff($now)->format('%a');
		
		if($interval >= 89 && $interval <= 91)
		{
			$valid = true;
		}
		
		return $valid;
	}
	
	// piecepay, hourly rate, salary, fixed contract amount
	function validatePay($pay)
	{
		$valid = false;
		
		if($pay > 0)
		{
			$valid = true;
		}
		return $valid;
	}
	
	const kInvalidFirstName = 0x01;
	const kInvalidLastName = 0x02;
	const kInvalidSIN = 0x04;
	const kInvalidDateOfBirth = 0x08;
	const kInvalidDateOfHire = 0x10;
	const kInvalidDateOfTermination = 0x20;
	const kInvalidPay = 0x40; // hourly rate, salary, piecePay, contract amount
	const kInvalidSeason = 0x80; 
	const kInvalidBusinessNumber = 0x100;
	
	// validates full time and part time employees
	function validateFullParttimeEmployee($dateOfHire, $dateOfTermination, $pay)
	{
		$invalidFields = 0;
		
		if(validateDate($dateOfHire) == false)
		{
			$invalidFields |= kInvalidDateOfHire;
		}
		if(($dateOfTermination != null) && (validateEarlierDate($dateOfHire, $dateOfTermination) == false))
		{
			$invalidFields |= kInvalidDateOfTermination;
		}
		if(validatePay($pay) == false)
		{
			$invalidFields |= kInvalidPay;
		}
		
		return $invalidFields;
	}
	
	function validateSeasonalEmployee($piecePay)
	{
		$invalidFields = 0;
		
		if(validatePay($piecePay) == false)
		{
			$invalidFields |= kInvalidPay;
		}
		
		return $invalidFields;
	}
	
	function validateContractEmployee($contractStartDate, $contractEndDate, $fixedContractAmount)
	{
		 $invalidFields = 0;		
		
		if(validateDate($contractStartDate) == false)
		{
			$invalidFields |= kInvalidDateOfHire;
		}
		if(validateEarlierDate($contractStartDate, $contractEndDate) == false)
		{
			$invalidFields |= kInvalidDateOfTermination;
		}
		if(validatePay($fixedContractAmount) == false)
		{
			$invalidFields |= kInvalidPay;
		}
		
		return $invalidFields;
	}


	function validateBaseEmployee($firstName, $lastName, $socialInsuranceNumber, $dateOfBirth)
	{
		$invalidFields = 0;
		
		if(validateName($firstName) == false)
		{
			$invalidFields |= kInvalidFirstName;
		}
		if(validateName($lastName) == false)
		{
			$invalidFields |= kInvalidLastName;
		}
		if(validateSocialInsuranceNumber($socialInsuranceNumber) == false)
		{
			$invalidFields |= kInvalidSIN;
		}
		if(validatePastDate($dateOfBirth) == false)
		{
			$invalidFields |= kInvalidDateOfBirth;
		}
		
		return $invalidFields;
	}


	function validateBaseContractEmployee($lastName, $businessNumber, $dateOfBirth)
	{
		$invalidFields = 0;
		
		if(validateName($lastName) == false)
		{
			$invalidFields |= kInvalidLastName;
		}
		if(validateBusinessNumber($businessNumber) == false)
		{
			$invalidFields |= kInvalidBusinessNumber;
		}
		if(validatePastDate($dateOfBirth) == false)
		{
			$invalidFields |= kInvalidDateOfBirth;
		}
		
		return $invalidFields;
	}

	function validateNames($firstName, $lastName)
	{
		$invalidFields = 0;
		
		if(validateName($firstName) == false)
		{
			$invalidFields |= kInvalidFirstName;
		}
		if(validateName($lastName) == false)
		{
			$invalidFields |= kInvalidLastName;
		}

		return $invalidFields;
	}


	
	// example
	/*
	if((validateFullParttimeEmployee("Ro!chelle", "Anderson", 375435807, "1948-10-1", "2010-5-6", "2014-2-1", 72572) & kInvalidFirstName) != 0){
		print("first name is invalid");
	}
	*/
?>