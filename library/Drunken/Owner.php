<?php

/**
 * @desc PHP Autoloader
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class Drunken_Owner
{
    private $company = '';
    private $contact_person = '';
    private $salutation = '';
    private $title = '';
    private $first_name = '';
    private $last_name = '';
    private $address = '';
    private $zip_code = '';
    private $city = '';
    private $email = '';
    private $fax = '';
    private $phone = '';
    private $mobile = '';
    private $notice = '';
    
    
    
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
    
    
    public function setOwner() {
      /**
       * TODO KONTROLLSTRUKTUR
       */
      $sql = 'INSERT INTO owner (id, salutation, title, company, contact_person, first_name, last_name, address, zip_code, city, email, fax, phone, mobile, notice) VALUES ("",
      																	"'.$this->salutation.'",
      																	"'.$this->title.'",
      																	"'.$this->company.'",
      																	"'.$this->contact_person.'",
      																	"'.$this->first_name.'",
      																	"'.$this->last_name.'",
      																	"'.$this->address.'",
      																	"'.$this->zip_code.'",
      																	"'.$this->city.'",
      																	"'.$this->email.'",
      																	"'.$this->fax.'",
      																	"'.$this->phone.'",
      																	"'.$this->mobile.'",
      																	"'.$this->notice.'")';
      
      return Drunken_Database::query($sql);
  }
  
  /**
   * @return the $address
   */
  public static function getAddress ()
  {
      return Drunken_Owner::$address;
  }

	/**
   * @param field_type $address
   */
  public static function setAddress ($address)
  {
      Drunken_Owner::$address = $address;
  }

	public static function getOwners() {
      $sql = 'SELECT * FROM owner';
      $query = Drunken_Database::query($sql);
      
      $owners = array();
      
      while($owner = Drunken_Database::fetchObject($query)) {
          $owners[$owner->id] = $owner;
      }
      
      return $owners;
  }
    
  public static function getOwnerById($oid) {
      $sql = 'SELECT * FROM owner WHERE id = "'.$oid.'"';
      $query = Drunken_Database::query($sql);
      return Drunken_Database::fetchObject($query);
  }
  
  public static function search($string) {
    
    $return = Array('data' => Array(), 'count' => 0, 'success' => false, 'success_msg' => Array(), 'error_msg' => Array());
    
    if(trim($string) == '') {
      $return['error_msg'][] = 'Bitte geben Sie einen Suchbegriff ein.';
      return $return;
    }
    
    $sql = 'SELECT * FROM owner WHERE company like "%'.$string.'%"
    															 OR contact_person like "%'.$string.'%"
    															 OR first_name like "%'.$string.'%"
    															 OR last_name like "%'.$string.'%"
    															 OR address like "%'.$string.'%"
    															 OR zip_code like "%'.$string.'%"
    															 OR city like "%'.$string.'%"
    															 OR email like "%'.$string.'%"';
    
//    die($sql);
    
    if($query = Drunken_Database::query($sql)) {
      
      while($p = Drunken_Database::fetchObject($query)) {
        $return['data'][] = $p;
      }
      
      $return['count'] = count($return['data']);
      $return['success'] = true;
      
    } else {
      $return['error_msg'][] = 'Leider konnte die Abfrage nicht ausgeführt werden. Bitte kontaktieren Sie den Support.';
    }
    
    return $return;
  }
  
}
?>