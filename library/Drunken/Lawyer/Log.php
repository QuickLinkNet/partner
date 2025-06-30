<?php

class Drunken_Lawyer_Log
{
	/**
	 * 
	 * @desc Id
	 * @var integer
	 */
	public $id;
	
	/**
	 * 
	 * @desc Layer-Contact-Person-Id
	 * @var integer
	 */
	public $lawyer_contact_person_id;
	
	/**
	 * 
	 * @desc Datetime
	 * @var datetime
	 */
	public $datetime;
	
	/**
	 * 
	 */
	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}
	
	/**
	 * 
	 */
	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}
	}
	
	public function addLog() {
	  
	  $old_time = strtotime('-5 minutes');
    $old_time = date('Y-m-d H:i:s', $old_time);

	  $sql = 'SELECT * FROM lawyer_log WHERE lawyer_contact_person_id = "'.$this->lawyer_contact_person_id.'" AND datetime >  "'.$old_time.'"';
	  $query = Drunken_Database::query($sql);
	  
	  if(mysqli_num_rows($query) <= 0) {
	    $sql = 'INSERT INTO lawyer_log VALUES ("", "'.$this->lawyer_contact_person_id.'", "'.$this->datetime.'")';
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