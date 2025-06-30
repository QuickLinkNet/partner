<?php

/**
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class Drunken_Lawyer_Transfer
{
  private $id = '';
  private $lawyer_id = '';
  private $acquisition_id = '';
  
	public $error = array();
  
  public function __set($property, $value) {
  		if (property_exists($this, $property)) {
  			$this->$property = $value;
  		}
  }
  
  public function __get($property) {
  		if (property_exists($this, $property)) {
  			return $this->$property;
  		}
  }
  
  public static function checkLawyerTransfer($aid) {
    $sql = 'SELECT * FROM lawyer_transfers WHERE acquisition_id = "'.$aid.'"';
    $query = Drunken_Database::query($sql);
    
    if(mysqli_num_rows($query) > 0) {
      return true;
    } else {
      return false;
    }
  }
  
  public function setTransfer() {
    $sql = 'INSERT INTO lawyer_transfers (lawyer_id, acquisition_id) VALUES ("'.$this->lawyer_id.'", "'.$this->acquisition_id.'")';
    if(Drunken_Database::query($sql)) {
      return true;
    } else {
      return false;
    }
  }
  
  public function resetTransfer() {
    $sql = 'DELETE FROM lawyer_transfers WHERE acquisition_id = '.$this->acquisition_id;
    if(Drunken_Database::query($sql)) {
      return true;
    } else {
      return false;
    }
  }
  
}
?>