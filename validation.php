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
	
	function validateSeason($season)
	{
		$valid = false;
		
		if(($season >= 1) && ($season <= 4))
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
?>