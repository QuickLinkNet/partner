<?php

/**
 * 
 * @desc
 * @author Manuel Kramm
 * @version 1.0
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 */

class Drunken_StatusCourse
{
  public $acquisition_id = '';
  public $user_id = null;
  public $lawyer_contact_person_id = null;
  public $partner_contact_person_id = null;
  public $status_id = '';
  public $datetime = '';
  public $description = '';
  public $period = '';
    
    
  /**
   * @return the $period
   */
  public function getPeriod() {
    return $this->period;
  }

	/**
   * @param field_type $period
   */
  public function setPeriod($period) {
    $this->period = $period;
  }

	/**
   * @return the $user_id
   */
  public function getUser_id ()
  {
    return $this->user_id;
  }

	/**
   * @param field_type $user_id
   */
  public function setUser_id ($user_id) {
      $this->user_id = $user_id;
  }
  
	/**
   * @return the $user_id
   */
  public function getLawyerContactPersonId () {
    return $this->lawyer_contact_person_id;
  }

	/**
   * @param field_type $user_id
   */
  public function setLawyerContactPersonId ($lawyer_contact_person_id) {
      $this->lawyer_contact_person_id = $lawyer_contact_person_id;
  }
  
	/**
   * @return the $user_id
   */
  public function getPartnerContactPersonId () {
    return $this->partner_contact_person_id;
  }

	/**
   * @param field_type $user_id
   */
  public function setPartnerContactPersonId ($partner_contact_person_id) {
      $this->partner_contact_person_id = $partner_contact_person_id;
  }

	/**
   * @return the $acquisition_id
   */
  public function getAcquisition_id ()
  {
      return $this->acquisition_id;
  }

	/**
   * @return the $status_id
   */
  public function getStatus_id ()
  {
      return $this->status_id;
  }

	/**
     * @return the $datetime
     */
    public function getDatetime ()
    {
        return $this->datetime;
    }

	/**
     * @return the $description
     */
    public function getDescription ()
    {
        return $this->description;
    }

	/**
     * @param field_type $acquisition_id
     */
    public function setAcquisition_id ($acquisition_id)
    {
        $this->acquisition_id = $acquisition_id;
    }

	/**
     * @param field_type $status_id
     */
    public function setStatus_id ($status_id)
    {
        $this->status_id = $status_id;
    }

	/**
     * @param field_type $datetime
     */
    public function setDatetime ($datetime)
    {
        $this->datetime = $datetime;
    }

	/**
     * @param field_type $description
     */
    public function setDescription ($description)
    {
        $this->description = $description;
    }
    
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

    public function setStatusCourse() {

        if ($this->user_id == '') {
          $user_id = 'null';
        } else {
          $user_id = '"'.$this->user_id.'"';
        }

        if ($this->lawyer_contact_person_id == '') {
          $lawyer_contact_person_id = 'null';
        } else {
          $lawyer_contact_person_id = '"'.$this->user_id.'"';
        }

        if ($this->partner_contact_person_id == '') {
          $partner_contact_person_id = 'null';
        } else {
          $partner_contact_person_id = '"'.$this->partner_contact_person_id.'"';
        }

        if ($this->period == '') {
          $period = 'null';
        } else {
          $period = '"'.$this->period.'"';
        }

        $sql = 'INSERT INTO status_course (acquisition_id, user_id, lawyer_contact_person_id, partner_contact_person_id, status_id, datetime, description, period) VALUES ("'.$this->acquisition_id.'", '.$user_id.', '.$lawyer_contact_person_id.', '.$partner_contact_person_id.', "'.$this->status_id.'", "'.$this->datetime.'", "'.$this->description.'", '.$period.')';
        if(Drunken_Database::query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @desc Get Status course from acquisition id
     * @param acquisition id $id
     */
    public static function getStatCourse($id) {
        $sql = 'SELECT * FROM status_course where acquisition_id = "'.$id.'" ORDER BY datetime DESC';
        $query = Drunken_Database::query($sql);
        
        $stats = Array();
        
        while($status = Drunken_Database::fetchObject($query)) {
            array_push($stats, $status);
        }
        
        return $stats;
    }
    
    public static function getCurrentStatByAcquisitionId($aid) {
        $sql = 'SELECT * FROM status_course WHERE acquisition_id = "'.$aid.'" ORDER BY datetime DESC LIMIT 1';
        $query = Drunken_Database::query($sql);
        $res = Drunken_Database::fetchObject($query);
        
        return $res;
    }
    
    public static function getSecondLastStatusByAcquisitionId($aid) {
        $sql = 'SELECT * FROM status_course WHERE acquisition_id = "'.$aid.'" ORDER BY datetime DESC LIMIT 1 OFFSET 1';
        $query = Drunken_Database::query($sql);
        $res = Drunken_Database::fetchObject($query);
        
        return $res;
    }
    
    public static function setAppointmentSuccess($id, $bol) {
    	
    	$sql = 'UPDATE status_course SET success = '.$bol.' WHERE acquisition_id = '.$id.' ORDER BY id desc LIMIT 1';
    	
    	if(Drunken_Database::query($sql)) {
    		return true;
    	} else {
    		return false;
    	}
    	
    }
    
    public static function checkCourseOfId($aid, $sid) {
      
      $status_course = self::getStatCourse($aid);
      
      if(count($status_course) > 0) {
        for($i = 0; $i < count($status_course); $i ++) {
          if($status_course[$i]->status_id == $sid) {
            return true;
          }
        }
      }
      
      return false;
    }
    
    public static function checkLastStatus($aid, $sid) {
    	$sql = 'SELECT * FROM status_course WHERE id = (SELECT MAX(id) as id FROM status_course sc WHERE acquisition_id = '.$aid.') AND status_id = '.$sid;
    	$query = Drunken_Database::query($sql);
    	
    	if(mysqli_num_rows($query) > 0) {
    		return true;
    	}
    }
    
    public static function getLastStatusWithIds($aid, $ids) {
      $sql = 'SELECT * FROM status_course WHERE acquisition_id = "'.$aid.'" AND status_id IN ("'.join('","', $ids).'") ORDER BY datetime desc LIMIT 1';
      return Drunken_Database::fetchObject(Drunken_Database::query($sql));
    }
    
    public static function getLastPhotoFitterByAcquisitionId($id) {
      $sql = 'SELECT * FROM status_course WHERE acquisition_id = "'.$id.'" AND status_id IN ("25", "26")';
      $sql .= ' AND datetime = (SELECT MAX(datetime) FROM status_course WHERE acquisition_id = "'.$id.'" AND status_id IN ("25", "26"))';
      $query = Drunken_Database::query($sql);
      
      if(mysqli_num_rows($query) > 0) {
        $res = Drunken_Database::fetchObject($query);
        $sql = 'SELECT CONCAT(first_name, " " , last_name) as name FROM user WHERE id = "'.$res->user_id.'"';
        
        $query = Drunken_Database::query($sql);
        
        if(mysqli_num_rows($query) > 0) {
          $res = Drunken_Database::fetchObject($query);
          return $res->name;
        }
      }
    }
}

?>
