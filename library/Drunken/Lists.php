<?php

/**
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class Drunken_Lists {
	
	public static function getLists() {
		$sql = 'SELECT * FROM lists';
		$query = Drunken_Database::query($sql);
		
		$lists = Array();
		
		while($list = Drunken_Database::fetchObject($query)) {
			$list->status = (array) json_decode($list->status);
			array_push($lists, $list);
		}
		
		return $lists;
	}
	
	/**
	 * @desc Get list by given ID
	 * @param integer	site-id
	 */
	public static function getListById($sid) {
		$sql = 'SELECT * FROM lists WHERE id = "'.$sid.'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		
		return Drunken_Database::fetchObject($query);
	}
	
	/**
	 * @desc Get list by given name
	 * @param integer	site-id
	 */
	public static function getListByName($name) {
		$sql = 'SELECT * FROM lists WHERE name = "'.$name.'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		
		return Drunken_Database::fetchObject($query);
	}
	
	public static function setListStatus($lid, $status) {
		
		$return = Array('success' => false, 'success_msg' => Array(), 'error_msg' => Array());
		
		$sql = 'UPDATE lists SET status = "'.mysqli_escape_string(Drunken_Database::getConnection(), $status).'" WHERE id = "'.$lid.'"';
		
		if(Drunken_Database::query($sql)) {
			$return['success'] = true;
			$return['success_msg'][] = 'Status-Filter wurde erfolgreich gespeichert.';
		}
		
		return $return;
	}
	
	public static function getListStatus($slug) {
		$sql = 'SELECT * FROM lists WHERE slug = "'.$slug.'" LIMIT 1';
		return Drunken_Database::fetchObject(Drunken_Database::query($sql));
	}
	
	public static function listExist($slug) {
		$sql = 'SELECT * FROM lists WHERE slug = "'.$slug.'"';
		$query = Drunken_Database::query($sql);
		
		if(mysqli_num_rows($query) > 0) {
			return true;
		} else {
			return false;
		}
	}
}

?>