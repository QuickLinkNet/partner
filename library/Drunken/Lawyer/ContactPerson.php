<?php

/**
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class Drunken_Lawyer_ContactPerson
{
  private $id = '';
  private $lawyer_id = '';
  private $salutation = '';
  private $first_name = '';
  private $last_name = '';
  private $phone = '';
  private $fax = '';
  private $email = '';
  private $username = '';
  private $password = '';
  private $sid = '';
  private $active = '';
  
  /**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	public $return = array('data' => '', 'error_msg' => array(), 'success_msg' => array(), 'success' => false);
  
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
  
  public function addContactPerson() {
    
    $sql = 'INSERT INTO lawyer_contact_person (id, lawyer_id, salutation, first_name, last_name, phone, fax, email, username, password, active) VALUES ';
    $sql .= ' ("", "'.$this->lawyer_id.'", "'.$this->salutation.'", "'.$this->first_name.'", "'.$this->last_name.'", "'.$this->phone.'", "'.$this->fax.'", "'.$this->email.'", "'.$this->username.'", "'.md5($this->password + 'standortfabrik').'", "'.$this->active.'")';
    
    $email = new Drunken_PhpMailer();
    $email->From      = 'noreply@crm-standortfabrik.de';
    $email->FromName  = 'Standortfabrik';
    $email->Subject   = 'Login-Daten';
    
    $email->AddAddress($this->email);
    
    $body = '
      <style>
      	body { font-size:14px; font-family:Arial, Verdana, Georgia; }
      </style>
    ';
    
    $body .= '<body>';
    $body .= '<span style="font-size:16px; font-weight:bold;">Hallo ' . $this->first_name . ' ' . $this->last_name . '!</span>';
    $body .= '<br><br>';
    $body .= 'Eine Konto mit folgenden Login-Daten wurde für Sie angelegt:';
    $body .= '<br><br>';
    $body .= '<table>';
    $body .= '  <tr>';
    $body .= '    <td style="font-family: Arial, Verdana, Georgia; font-size:18px; font-weight:bold; color:#fff; padding:25px 50px; background-color:#999;">';
    $body .= '      ' . $this->username . '<br>';
    $body .= '      ' . $this->password;
    $body .= '    </td>';
    $body .= '  </tr>';
    $body .= '</table>';
    $body .= '<br><br>';
    $body .= 'Bitte verraten Sie niemandem Ihr Password und löschen Sie diese E-mail umgehend<br>';
    $body .= 'damit keine andere Person Ihr Passwort einsehen und benutzen kann.';
    $body .= '<br><br>';
    $body .= 'Mit freundlichen Grüßen,<br>';
    $body .= 'Ihr Standortfabrik-Team';
    $body .= '</body>';
    
    $email->CharSet = 'UTF-8';
    
    $email->msgHTML($body);
    
    $email->send();
    
    if(Drunken_Database::query($sql)) {
      return true;
    } else {
      return false;
    }
  }
  
  public function setContactperson() {
  	/**
     * Check E-Mail
     */
    $sql = 'SELECT * FROM lawyer_contact_person WHERE email = "'.$this->email.'" AND id != "'.$this->id.'"';
    $query = Drunken_Database::query($sql);
    if(mysqli_num_rows($query) > 0) {
      $this->return['error_msg'][] = 'Die angegebene E-Mail Adresse existiert bereits.';
    }
    if(!Drunken_Validator::validateEmailAdress($this->email)) {
      $this->return['error_msg'][] = 'Bitte gib eine korrekte E-Mail Adresse ein.';
    }
    
  	/**
     * Check Username
     */
    $sql = 'SELECT * FROM lawyer_contact_person WHERE username = "'.$this->username.'" AND id != "'.$this->id.'"';
    $query = Drunken_Database::query($sql);
    if(mysqli_num_rows($query) > 0) {
      $this->return['error_msg'][] = 'Der angegebene Username existiert bereits.';
    }
    
    if(count($this->return['error_msg']) <= 0) {
      
      $sql = 'SELECT * FROM lawyer_contact_person WHERE id = "'.$this->id.'" LIMIT 1';
  	  $query = Drunken_Database::query($sql);
  	  $pcp = Drunken_Database::fetchObject($query);
  	  
  	  $new_password = $this->password;
  	  
  	  trim($this->password) == '' ? $this->password = $pcp->password : $this->password = md5($this->password);
  	  
      if(mysqli_num_rows($query) > 0) {
        
  	    /**
  	     * E-Mail needed?
  	     */
        
  	    if($pcp->username != $this->username || $pcp->email != $this->email || ($pcp->password != $this->password && trim($this->password) != '')) {
  	      
    	    $email = new Drunken_PhpMailer();
          $email->From      = 'noreply@crm-standortfabrik.de';
          $email->FromName  = 'Standortfabrik';
          $email->Subject   = 'Login-Daten geändert';
          
          $email->AddAddress($pcp->email);
          
          $body = '
            <style>
            	body { font-size:14px; font-family:Arial, Verdana, Georgia; }
            </style>
          ';
          
          $body .= '<body>';
          $body .= '<span style="font-size:16px; font-weight:bold;">Hallo ' . $pcp->first_name . ' ' . $pcp->last_name . '!</span>';
          $body .= '<br><br>';
          
          if($pcp->username != $this->username) {
            $body .= 'Ihr Username wurde geändert:';
            
            $body .= '<br><br>';
            $body .= '<table>';
            $body .= '  <tr>';
            $body .= '    <td style="font-family: Arial, Verdana, Georgia; font-size:18px; font-weight:bold; color:#fff; padding:25px 50px; background-color:#999;">';
            $body .= '      ' . $this->username;
            $body .= '    </td>';
            $body .= '  </tr>';
            $body .= '</table>';
            $body .= '<br><br>';
          }
          
          if($pcp->email != $this->email) {
            $body .= 'Ihre E-Mail Adresse wurde geändert:';
            
            $body .= '<br><br>';
            $body .= '<table>';
            $body .= '  <tr>';
            $body .= '    <td style="font-family: Arial, Verdana, Georgia; font-size:18px; font-weight:bold; color:#fff; padding:25px 50px; background-color:#999;">';
            $body .= '      ' . $this->email;
            $body .= '    </td>';
            $body .= '  </tr>';
            $body .= '</table>';
            $body .= '<br><br>';
          }
          
          if($pcp->password != $this->password && trim($this->password) != '') {
            $body .= 'Ihre Passwort wurde geändert:';
            
            $body .= '<br><br>';
            $body .= '<table>';
            $body .= '  <tr>';
            $body .= '    <td style="font-family: Arial, Verdana, Georgia; font-size:18px; font-weight:bold; color:#fff; padding:25px 50px; background-color:#999;">';
            $body .= '      ' . $new_password;
            $body .= '    </td>';
            $body .= '  </tr>';
            $body .= '</table>';
            $body .= '<br><br>';
          }
          
          $body .= 'Bitte verraten Sie niemandem Ihre Login-Daten und löschen Sie diese E-mail umgehend<br>';
          $body .= 'damit keine andere Person Ihre Login-Daten einsehen und benutzen kann.';
          $body .= '<br><br>';
          $body .= 'Mit freundlichen Grüßen,<br>';
          $body .= 'Ihr Standortfabrik-Team';
          $body .= '</body>';
          
          $email->CharSet = 'UTF-8';
          
          $email->msgHTML($body);
          
          if($email->send()) {
            $this->return['success_msg'][] = 'E-Mail wurde erfolgreich gesendet.';
          } else {
            $this->return['error_msg'][] = 'E-Mail konnte nicht gesendet werden.';
          }
  	    }
  	  }
      
      $sql = 'UPDATE lawyer_contact_person SET salutation = "'.$this->salutation.'",
      																					first_name = "'.$this->first_name.'",
      																					last_name = "'.$this->last_name.'",
      																					phone = "'.$this->phone.'",
      																					fax = "'.$this->fax.'",
      																					email = "'.$this->email.'",
      																					username = "'.$this->username.'",
      																					password = "'.$this->password.'"
      																					WHERE id = "'.$this->id.'"';
      
      if(Drunken_Database::query($sql)) {
        $this->return['success'] = true;
        $this->return['success_msg'][] = 'Die Daten wurden erfolgreich geändert.';
        return $this->return;
      } else {
        $this->return['success'] = false;
        $this->return['success_msg'][] = 'Die Daten konnten leider nicht geändert werden.';
        return $this->return;
      }
    } else {
      $this->return['success'] = false;
      return $this->return;
    }
  }
  
  public static function getContactPerson($id) {
    $sql = 'SELECT * FROM lawyer_contact_person WHERE lawyer_id = "'.$id.'"';
    $query = Drunken_Database::query($sql);
    
    $contact_persons = array();
    
    while($cp = Drunken_Database::fetchObject($query)) {
      $contact_persons[$cp->id] = $cp;
    }
    
    return $contact_persons;
    
  }
  
  public static function checkUsername($username) {
    $sql = 'SELECT * FROM lawyer_contact_person WHERE username = "'.$username.'"';
    $query = Drunken_Database::query($sql);
    
    if(mysqli_num_rows($query) > '0') {
      return false;
    } else {
      return true;
    }
  }
  
  public static function checkEmail($email) {
    $sql = 'SELECT * FROM lawyer_contact_person WHERE email = "'.$email.'"';
    $query = Drunken_Database::query($sql);
    
    if(mysqli_num_rows($query) > '0') {
      return false;
    } else {
      return true;
    }
  }
  
  public static function checkContactPerson($email_username) {
  $query = Drunken_Database::query('SELECT * FROM lawyer_contact_person WHERE username = "'.$email_username.'" OR email = "'.$email_username.'"');
		if(mysqli_num_rows($query) > '0') { return true; }
  }
  
  public static function setLawyerContactPersonActive($lid, $active) {
	  $sql = 'UPDATE lawyer_contact_person SET active = ' . $active . ' WHERE id = ' . $lid;
	  if(Drunken_Database::query($sql)) {
	    
	    $lawyer = Drunken_Lawyer_ContactPerson::getContactPersonById($lid);
	    
      $mailer = new Drunken_Mailer();
  		$mailer->subject = 'Reaktivierung Ihres Accounts';
  		$mailer->from_name = 'Standortfabrik';
  		$mailer->addresses = array($lawyer->email);
  		$mailer->message = 'Hallo '.$lawyer->first_name.' '.$lawyer->last_name.', <br /><br />';
  		$mailer->message .= 'Ihr Account wurde reaktiviert.<br>';
		
  		if($mailer->sendMail()) {
  		  
  		}
	    
	    return true;
	  } else {
	    return false;
	  }
	}
	
  public static function setLawyerContactPersonInactive($lid, $active) {
	  $sql = 'UPDATE lawyer_contact_person SET active = ' . $active . ' WHERE id = ' . $lid;
	  
    if(Drunken_Database::query($sql)) {
      
      $lawyer = Drunken_Lawyer_ContactPerson::getContactPersonById($lid);
	    
      $mailer = new Drunken_Mailer();
  		$mailer->subject = 'Deaktivierung Ihres Accounts';
  		$mailer->from_name = 'Standortfabrik';
  		$mailer->addresses = array($lawyer->email);
  		$mailer->message = 'Hallo '.$lawyer->first_name.' '.$lawyer->last_name.', <br /><br />';
  		$mailer->message .= 'Ihr Account wurde bis auf weiteres deaktiviert.<br>';
		
  		if($mailer->sendMail()) {
  		  
  		}
      
	    return true;
	  } else {
	    return false;
	  }
	}
	
  public function getContactPersonsById($id) {
	  $sql = 'SELECT * FROM lawyer_contact_person WHERE id = "'.$id.'" LIMIT 1';
	  $query = Drunken_Database::query($sql);
	  
	  return Drunken_Database::fetchObject($query);
	}
	
	public static function getContactPersonsByLawyerId($lid) {
	  $sql = 'SELECT * FROM lawyer_contact_person WHERE lawyer_id = "'.$lid.'"';
	  $query = Drunken_Database::query($sql);
	  
	  $lawyer_contacts = array();
	  
	  while($row = Drunken_Database::fetchObject($query)) {
	    array_push($lawyer_contacts, $row);
	  }
	  
	  return $lawyer_contacts;
	}
	
	public static function getContactPersonById($lcpid) {
	  return Drunken_Database::fetchObject(Drunken_Database::query('SELECT * FROM lawyer_contact_person WHERE id = "'.$lcpid.'" LIMIT 1'));
	}
}
?>