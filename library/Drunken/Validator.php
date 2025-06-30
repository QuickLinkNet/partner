<?php

/**
 * 
 * Enter description here ...
 * @author Jürgen Schimpf
 *
 */
class Drunken_Validator {
	/**
	 * 
	 * @desc TODO
	 * @var unknown_type
	 */
	protected static $sql_injection = array('delete from',
											'drop table',
											'insert into',
											'select from',
											'select into',
											'update set' );
	
	/**
     * @var string Search pattern for numbers
	 */
	protected static $pt_int = '/^\d+$/';
	
	/*
	 * Regular expression for english float numbers, eg. 1,456.85
	 * Allowed are max. 3 numbers past to the commata and 1-2 numbers after the dot
	 */
	protected static $pt_float_en = '/^\$?(\d{1,3},?(\d{3},?)*\d{3}(\.\d{1,3})?|\d{1,3}(\.\d{1,2})?)$/';
	
	/**
	 * Regular Expression for german float numbers, eg. 5.456,35
	 * Allowed are max. 3 numbers past to the dot and 1-2 numbers after the commata
	 */
	protected static $pt_float_de = '/^\$?(\d{1,3}.?(\d{3}.?)*\d{3}(\,\d{1,3})?|\d{1,3}(\,\d{1,2})?)$/';
	
	/**
     * @var string Search pattern for postal numbers (germany)
	 */
	protected static $pt_zip = '/^[0-9]{5}$/';
	
	/**
     * @var string Search pattern for url�s
	 */
	protected static $pt_url = '/^(http|https)\:\/\/([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&%\$\-]+)*@)?((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.[a-zA-Z]{2,6})(\:[0-9]+)?(\/[a-zA-Z0-9\.\,\?\'\ \/\+&%\$#\=~_\-@]*)*$/';

	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	protected static $pt_email = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/';
	/**
	 * 
	 * @desc Validate a string of non-float numbers
	 * @param	string	$string
	 * @return	boolean	Returs true / false
	 */
	final public static function validateNumber($string) {
		if (preg_match( self::$pt_int, $string )) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * @desc Validate a string of float and interger numbers
	 * @param	string	$string
	 * @return	boolean	Returs true / false
	 */
	final public static function validateFloatNumbers($string, $lang = 'en') {
		$float_type = ($lang == 'en') ? self::$pt_float_en : self::$pt_float_de;  
		if (preg_match($float_type, $string)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * @desc Validate a url
	 * @param	string	$string 
	 * @return	boolean	Returns true / false
	 */
	final public static function validateUrl($string)
	{
		if (strtolower( substr( $string, 0, 7 ) ) != "http://" && strtolower( substr( $string, 0, 8 ) ) != "https://") {
			$string = "http://" .$string;
		}
		
		if (preg_match( self::$pt_url, $string )) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * @desc Validate a german zip code
	 * @param	integer $string zip Code
	 * @return	boolean	Returns true / false
	 */
	final public static function validateZIP($string)
	{
		if (preg_match( self::$pt_zip, $string )) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * @desc Validate a json string
	 * @param string $string
	 */
	public static function validateJson($string, $error = false) {
		
		switch ($string){
			case is_array($string);
				$ret = $error == true ? 'JSON - Array given, string needed' : false;
			break;
			case is_object($string);
				$ret = $error == true ? 'JSON - Object given, string needed' : false;
		}
		
		if(!isset($ret)) {
		    switch (json_last_error()) {
		        case JSON_ERROR_NONE:
		        	$ret = $error == true ? 'JSON - No errors' : true; 
		        break;
		        case JSON_ERROR_DEPTH:
		        	$ret = $error == true ? 'JSON - Maximum stack depth exceeded' : false; 
		        break;
		        case JSON_ERROR_STATE_MISMATCH:
		        	$ret = $error == true ? 'JSON - Underflow or the modes mismatch' : false; 
		        break;
		        case JSON_ERROR_CTRL_CHAR:
		        	$ret = $error == true ? 'JSON - Unexpected control character found' : false; 
		        break;
		        case JSON_ERROR_SYNTAX:
		        	$ret = $error == true ? 'JSON - Syntax error, malformed JSON' : false; 
		        break;
		        case JSON_ERROR_UTF8:
		        	$ret = $error == true ? 'JSON - Malformed UTF-8 characters, possibly incorrectly encoded' : false; 
		        break;
		        default:
		        	$ret = $error == true ? 'JSON - Unknown error' : false; 
		        break;
		    }
		}
	    
	    return $ret;
	}
		
	/**
	 * 
	 * @desc Validate email address
	 * @param	integer $string email-adress
	 * @return	boolean	Returns true / false
	 */
	final public static function validateEmailAdress($string)
	{
		if (preg_match( self::$pt_email, $string )) {
			return true;
		} else {
			return false;
		}
	}	
}

?>