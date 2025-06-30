<?php

class Drunken_Holidays
{
	public static function getEaster()
	{
		$easter = new DateTime('now');
		$year = $easter->format('Y');
		$easter->setDate($year, 3, 21);
		$easter->setTime(0, 0, 0);
		$easter->modify('+' . easter_days($year) . 'days');
		return $easter;
	}

	public static function holidays()
	{
		$buss_und_bettag = new DateTime('nov 23');

		return  array(  "neujahr"           	    => new DateTime('jan 1st'),
				"heilige_drei_koenige"      => new DateTime('jan 6'),
//				"gruendonnerstag"           => self::getEaster()->modify('-3 days'),
				"karfreitag"                => self::getEaster()->modify('-2 days'),
				"ostermontag"               => self::getEaster()->modify('+1 day'),
				"tag_der_arbeit"            => new DateTime('may 1st'),
				"christi_himmelfahrt"       => self::getEaster()->modify('+39 days'),
				"pfingstmontag"             => self::getEaster()->modify('+50 days'),
				"fronleichnam"              => self::getEaster()->modify('+60 days'),
				"maria_himmelfahrt"         => new DateTime('aug 15'),
				"tag_der_deutschen_einheit" => new DateTime('oct 3'),
				"reformationstag"           => new DateTime('oct 31'),
				"allerheiligen"             => new DateTime('nov 1st'),
				"buss_und_bettag"           => $buss_und_bettag->modify('last Wednesday'),
				"weihnachtstag1"            => new DateTime('dec 25th'),
				"weihnachtstag2"            => new DateTime('dec 26th'),
		);	
	}
	
	/**
	 * Check if this is a holiday
	 * @param  string|date object  $date accepts valid date/time string or valid date object
	 * @return boolean
	 */
	public static function isHoliday($date = 'now')
	{
		$holidays = self::holidays();
		// create object in case of a time string
		if(is_string($date)){
			$date = new  DateTime($date);
		}
		$date->setTime(0, 0, 0);

		foreach($holidays as $holy => $day){
			// $date->diff($day)->days;
			// returns 0 if date is the same or just compare 
			// http://php.net/manual/en/datetime.diff.php
			if($date == $day){
				return TRUE;
			}
		}

		return FALSE;
	}
}

?>