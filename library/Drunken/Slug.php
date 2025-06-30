<?php

/**
 * 
 * @desc Call Class-Methods to return an clear Slug-String
 * @author Manuel Kramm
 * @version 1.0
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 */

class Drunken_Slug
{
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $mixed
	 */
	public static function getSlug($var, $replacer = '')
	{
		if(is_array($var)) {
			$return = array_map('strtolower', $var);
			$return = array_map('trim', $return);
		} else {
			$return = strtolower($var);
			$return = str_replace(' ', '_', $return);
		}
		
		$return = preg_replace('/[^a-z0-9_]/', $replacer, $return);
		
		return $return;
	}
}

?>