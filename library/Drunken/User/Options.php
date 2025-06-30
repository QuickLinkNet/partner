<?php

/**
 * 
 * @desc Insert, edit, delete and read all user-options of the user-option-table
 * Available Options:
 * - user_role
 * - linkbuy_clients_project_manager
 * @author Manuel Kramm
 *
 */
class Drunken_User_Options {
	/**
	 * 
	 * @desc Static error-container
	 * @var Array
	 */
	public static $error = array();
	
	/**
	 * 
	 * @desc Set available option key�s
	 * @var array
	 */
	private static $valid_options = array('user_roles', 'linkbuy_clients_project_manager');
	
	/**
	 * @desc Update 
	 * @param integer $user_id
	 * @param string $option_key
	 * @param mixed $option_value
	 */
	public static function setOption($uid, $okey, $ovalue) {
		if(is_array($ovalue)) {
			$v = mysqli_escape_string(json_encode($ovalue));
		} else {
			$a = array((string)$ovalue);
			$v = mysqli_escape_string(json_encode($a));
		}
		
		$sql = 'SELECT * FROM user_options WHERE user_id = "'.$uid.'" AND option_key = "'.$okey.'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		if(mysqli_num_rows($query) > '0') {
			$sql = 'UPDATE user_options SET option_value = "'.$v.'" WHERE user_id = "'.$uid.'" AND option_key = "'.$okey.'"';
			$query = Drunken_Database::query($sql);
			if(mysqli_affected_rows() > '0') {
				self::$error['msg'][] = 'Option successfully updated.';
				self::$error['success'] = true;
			} else {
				self::$error['msg'][] = 'Option can not be updated. PLease contact support.';
			}
		} else {
			$sql = 'INSERT INTO user_options (user_id, option_key, option_value) VALUES';
			$sql .= ' ("'.$uid.'", "'.$okey.'", "'.$v.'")';
			$query = Drunken_Database::query($sql);
			if(mysqli_affected_rows() > '0') {
				self::$error['msg'][] = 'Option successfully inserted.';
				self::$error['success'] = true;
			} else {
				self::$error['msg'][] = 'Option can not be inserted. Please contact support.';
			}
		}
	}
	
	
	/**
	 * 
	 * @desc Return an array of the user-options with a specific user-id and option-name
	 * @param Int $uid
	 * @param mixed $option_key (can be string or array)
	 * @return Array: the encoded JSON-String from user_options table
	 */
	public static function getOptions($uid = '', $option_key = '') {
		if((isset($uid) && $uid != '' && Drunken_User::userIdExist($uid)) || (isset($option_key) && $option_key != '')) {
			$sql = 'SELECT * FROM user_options';
			if(isset($uid) && $uid != '') {
				if(Drunken_User::userIdExist($uid)) {
					$sql .= ' WHERE user_id="'. $uid .'"';
				} else {
					self::$error['msg'][] = 'User with given id does not exist.';
				}
			}
			
			if($option_key != '') {
				if(is_array($option_key)) {
					foreach($option_key as $key) {
						strpos($sql, 'WHERE') !== false ? $op = 'AND' : $op = 'WHERE';
						$sql .= ' '.$op.' option_key = "'. $key .'"';
					}
				} else {
					strpos($sql, 'WHERE') !== false ? $op = 'AND' : $op = 'WHERE';
					$sql .= ' '.$op.' option_key = "'. $option_key .'"';
				}
			}
			
			$query = Drunken_Database::query($sql);
			if(mysqli_num_rows($query) > '0') {
				
				$user_options = array();
				
				while($row = Drunken_Database::fetchObject($query)) {
					$user_options[$row->option_key] = json_decode($row->option_value);
				}
				
				return $user_options;
			} else {
				self::$error['msg'][] = 'No options found';
			}
		} else {
			self::$error['msg'][] = 'No User-ID or Options-Key given.';
		}
	}
	
	/**
	 * 
	 * @desc Replace an option (json) value with another
	 * @param integer $uid
	 * @param string $key
	 * @param string $search
	 * @param string $replace
	 */
	public static function replaceOption($uid, $key, $search, $replace) {
		die('NOT FINISHED!');
		$sql = 'SELECT * FROM user_options WHERE user_id = "'.$uid.'" AND option_key = "'.$key.'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		if(mysqli_num_rows($query) > '0') {
			$res = json_decode(Drunken_Database::fetchObject($query));
			Drunken_Functions::getPre($res);
			die();
		}
	}
	
	/**
	 * 
	 * @desc Delete value from existing option
	 * @param integer $uid
	 * @param string $key
	 * @param string $value
	 */
	public static function moveOptionValue($from_uid, $to_uid, $okey, $ovalue) {
		#if($from_uid != $to_uid) {
			$sql = 'SELECT * FROM user_options WHERE user_id = "'.$from_uid.'" AND option_key = "'.$okey.'" LIMIT 1';
			$query = Drunken_Database::query($sql);
			if(mysqli_num_rows($query) > '0') {
				$res = json_decode(Drunken_Database::fetchObject($query)->option_value);
				$newvalues = $ovalue;
				if(in_array($newvalues, $res)) {
					
					foreach(array_keys($res, $newvalues) as $res_key => $newvalues) {
						unset($res[$newvalues]);
					}
					
					$sql = "UPDATE user_options SET option_value = '".str_replace('"', '\"', json_encode(array_values($res)))."'";
					$sql .= ' WHERE user_id = "'.$from_uid.'" AND option_key = "'.$okey.'"';
					$query = Drunken_Database::query($sql);
					if(mysqli_affected_rows() > '0') {
						self::$error['msg'][] = 'Value successfully deleted.';
						self::addOptionValue($to_uid, $okey, $ovalue);
					} else {
						self::$error['msg'][] = 'Value cannot be deleted. Please contact support';
					}
				} else {
					self::$error['msg'][] = 'Option doesnt contain the given value.';
				}
			} else {
				self::addOptionValue($to_uid, $okey, $ovalue);
			}
		#} else {
		#	self::$error['msg'][] = 'Cannot move value to the same user id.';
		#}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $value
	 * @param unknown_type $option_key
	 */
    public static function getUserByValue($value, $option_key = NULL) {
		$exist = false;
    	$sql = 'SELECT user_id, option_value FROM user_options ';
		$sql .= ($option_key != NULL) ? 'WHERE option_key = "'. $option_key .'"' : '';
    	
		$query = Drunken_Database::query($sql);
		
		if(mysqli_num_rows($query) > 0) {
	    	while($row = Drunken_Database::fetchObject($query)) {
	    		$arr_value = json_decode($row->option_value);
	    		if(in_array($value, $arr_value)) {
	    			$exist = true;
	    			return Drunken_User::getUserById($row->user_id);
	    		} 
	    	}
	    	if(!$exist) {
	    		return false;
	    	}
		}
    }
	
	
	
	/**
	 * 
	 * @desc Add a value to an existing option. If not exist than creat it.
	 * @param integer $uid
	 * @param string $okey
	 * @param string $ovalue
	 */
	public static function addOptionValue($uid, $okey, $ovalue) {
		$sql = 'SELECT * FROM user_options WHERE user_id = "'.$uid.'" AND option_key = "'.$okey.'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		if(mysqli_num_rows($query) > '0') {
			$res = Drunken_Database::fetchArray($query);
			$res = json_decode($res['option_value']);
			array_push($res, "" . $ovalue . "");
			
			
			$sql = 'UPDATE user_options SET option_value = "'.mysqli_escape_string(json_encode(array_values($res))).'" WHERE user_id = "'.$uid.'" AND option_key = "'.$okey.'"';
			$query = Drunken_Database::query($sql);
			if(mysqli_affected_rows() > '0') {
				self::$error['msg'][] = 'Value successfully added.';
				self::$error['success'] = true;
			} else {
				self::$error['msg'][] = 'Cannot add value. Please contact support.';
			}
		} else {
			self::setOption($uid, $okey, $ovalue);
		}
	}
	
	/**
	 * 
	 * @desc Update an user-option, if an value not exists and ignores other values
	 * @param Int $user_id
	 * @param String $option_key
	 * @param String|Array $option_value
	 * @return Boolean
	 */
	public static function appendOptionValue($user_id, $option_key, $option_value) {
		if($user_id != '' && $option_key != '' && $option_value != '') {
			$arr_options_value = self::getOptionValue($user_id, $option_key);
			$arr_temp = $arr_options_value;

			if(!is_array($option_value)) {
				if(!in_array($option_value, $arr_options_value)) {
					$arr_temp[] = (String)$option_value;
				}
			} else {
				foreach($option_value as $value) {
					if(!in_array($value, $arr_options_value)) {
						$arr_temp[] = (String)$value;
					}
				}
			}
			$sql  = 'UPDATE user_options ';
			$sql .= 'SET option_value = "'.str_replace('"', '\"', json_encode($arr_temp)).'" ';
			$sql .= 'WHERE user_id = "'.$user_id.'" ';
			$sql .= 'AND option_key = "'.$option_key.'"';

			if(Drunken_Database::query($sql)) {
				return true;
			} else {
				self::$error['msg'][] = 'Drunken_UserOptions::appendOptionValue(): SQL-Statement:<br /> '. $sql .'<br />SQL-Error:<br /> '.mysqli_error();
				return false;
			}
		} else {
			self::$error['msg'][] = 'Drunken_UserOptions::appendOptionValue(): SQL-Statement:<br /> '. $sql .'<br />SQL-Error:<br /> '.mysqli_error();
			return false;
		}
	}
	
	/**
	 * @desc Delete user-options by the user-id or special user-option-values; in addition it compare the option-value-array elements with the existing JSON-elements in the DB 
	 * @param Int $user_id
	 * @param Int (optional) $option_key
	 * @param Int (optional) $option_value
	 * @return Boolean
	 */
	public static function deleteOptions($user_id, $option_key = '', $option_value = '') {
		if(isset($user_id) && $user_id != '') {
			if(self::checkOption($user_id, $option_key)) {
				if($option_value == '') {
					$sql  = 'DELETE FROM user_options ';
					$sql .= 'WHERE user_id = "'.$user_id.'" ';
					$sql .= ($option_key != '') ? 'AND option_key = "'.$option_key.'" ' : '';
				
					if(Drunken_Database::query($sql)) {
						return true;
					} else {
						self::$error['msg'][] = 'Drunken_UserOptions::deleteOptions(): MySQL transfer problem for the following sql-statement:<br>'.$sql;
						return false;
					}
				} else {
					$arr_option_value = self::getOptionValue($user_id, $option_key);
				
					if(is_array($option_value)) {
						$option_value = Drunken_Functions::getArrayValuesAsString($option_value);
						foreach($option_value as $value) {
							$search = array_search($value, $arr_option_value);
							if($search !== false) {
								array_splice($arr_option_value, $search, 1);
							}
						}
					} else {
						$search = array_search((String)$option_value, $arr_option_value);
						if($search !== false) {
							array_splice($arr_option_value, (String)$search, 1);
						}
					}

					if(!empty($arr_option_value) && count($arr_option_value) > 0) {
						$sql  = 'UPDATE user_options ';
						$sql .= 'SET option_value = "'.str_replace('"', '\"', json_encode($arr_option_value)).'" ';
						$sql .= 'WHERE user_id = "'.$user_id.'" ';
						$sql .= 'AND option_key = "'.$option_key.'"';
					} else {
						$sql  = 'DELETE FROM user_options ';
						$sql .= 'WHERE user_id = "'.$user_id.'" ';
						$sql .= ($option_key != '') ? 'AND option_key = "'.$option_key.'" ' : '';
					}
								
					if(Drunken_Database::query($sql)) {
						return true;
					} else {
						self::$error['msg'][] = 'Drunken_UserOptions::deleteOptions(): SQL-Statement:<br /> '. $sql .'<br />SQL-Error:<br /> '.mysqli_error();
						return false;
					}
				}
			} else {
				self::$error['msg'][] = 'Drunken_UserOptions::deleteOptions(): The option "'.$option_key.'" is not exists.';
				return false;
			}
		} else {
			self::$error['msg'][] = 'Drunken_UserOptions::deleteOptions(): No User-id given';
			return false;
		}
	}
}

?>