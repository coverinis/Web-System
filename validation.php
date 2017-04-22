<?php 


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
		$yearMonthDay = explode('-',$date,3);
		
		// the date is a valid date
		return checkdate ($yearMonthDay[1] , $yearMonthDay[2], $yearMonthDay[0]);
	}
	
	function validatePastDate($date)
	{
		$yearMonthDay = explode('-',$date,3);
		$valid = false;
		// the date is a valid date
		if(checkdate ($yearMonthDay[1] , $yearMonthDay[2], $yearMonthDay[0]) == true)
		{
			$date = new DateTime($date);
			$now = new DateTime();
			// the date is in the past
			if($date <= $now)
			{
				$valid = true;
			}
		}
		return $valid;
	}
?>