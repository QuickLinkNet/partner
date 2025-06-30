<?php

class Drunken_User_Log
{
	/**
	 * 
	 * @desc Id
	 * @var integer
	 */
	public $id;
	
	/**
	 * 
	 * @desc User-Id
	 * @var integer
	 */
	public $user_id;
	
	/**
	 * 
	 * @desc Datetime
	 * @var datetime
	 */
	public $datetime;
	
	/**
	 * 
	 * @desc Set an Drunken_UserRole property
	 * @param mixed $property
	 */
	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}
	
	/**
	 * 
	 * @desc Get an Drunken_UserRole property
	 * @param mixed $property
	 */
	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}
	}
	
	public function addLog() {
	  
	  $old_time = strtotime('-5 minutes');
    $old_time = date('Y-m-d H:i:s', $old_time);

	  $sql = 'SELECT * FROM user_log WHERE user_id = "'.$this->user_id.'" AND datetime >  "'.$old_time.'"';
	  $query = Drunken_Database::query($sql);
	  
	  if(mysqli_num_rows($query) <= 0) {
	    $sql = 'INSERT INTO user_log VALUES ("", "'.$this->user_id.'", "'.$this->datetime.'")';
	  }
	  
	  if(Drunken_Database::query($sql)) {
	    return true;
	  } else {
	    return false;
	  }
	}
	
	public function setLog() {
	  
	}
	
	public static function getLog($uid) {
	  
	}
}

?>