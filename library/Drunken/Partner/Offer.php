<?php

/**
 * @desc PHP Autoloader
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class Drunken_Partner_Offer
{
  private $id = '';
  private $partner_id = '';
  private $acquisition_id = '';
  private $visible = false;
  private $offer = false;
  private $returned = false;
  private $seen = false;
  private $accepted = false;
  private $comment = '';
  private $datetime = '';
  private $updated = '';
	public $error = array('msg' => array(), 'success' => false);
  
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
  
  public function setPartnerOffer() {
    
    $date = new DateTime();
    $date = $date->format('Y-m-d H:i:s');
    
    if($this->partner_id == '') {
      $sql = 'SELECT * FROM partner_offer WHERE acquisition_id = "'.$this->acquisition_id.'" ORDER BY datetime DESC LIMIT 1';
      $query = Drunken_Database::query($sql);
      $res = Drunken_Database::fetchObject($query);
      $this->partner_id = $res->partner_id;
    }
    
    $sql = 'INSERT INTO partner_offer (partner_id,
    																		acquisition_id,
    																		visible,
    																		offer,
    																		returned,
    																		seen,
    																		accepted,
    																		comment,
    																		datetime,
    																		updated) VALUES ("'.$this->partner_id.'",
    																											"'.$this->acquisition_id.'",
    																											"'.$this->visible.'",
    																											"'.$this->offer.'",
    																											"'.$this->returned.'",
    																											"'.$this->seen.'",
    																											"'.$this->accepted.'",
    																											"'.$this->comment.'",
    																											"'.$date.'",
    																											"'.$this->updated.'")';
    
    if(Drunken_Database::query($sql)) {
      
      $this->error['success'] = true;
      
      if($this->offer == 1) {
      $partner_contacts = Drunken_Partner_ContactPerson::getContactPersonsByPartnerId($this->partner_id);
      
      $this->error['msg'][] = $partner_contacts;
      
      $config = Drunken_Config_Ini::getConfig();
      
      foreach($partner_contacts as $key =>  $pc) {
        
        $mail = new Drunken_PhpMailer(true);
    	  $email = new Drunken_PhpMailer();
        $email->From      = 'noreply@crm-standortfabrik.de';
        $email->FromName  = 'Standortfabrik';
        $email->Subject   = 'Neue Freigabe erhalten';
        
        $email->AddAddress($pc->email);
//        $email->AddAddress('register@red-it.org');
        
        $body = '
          <style>
          	body { font-size:14px; font-family:Arial, Verdana, Georgia; }
          </style>
        ';
        
        $body .= '<body>';
        
        if($pc->salutation == 'male') {
          $body .= '<span style="font-size:16px; font-weight:bold;">Sehr geehrter Herr ' . $pc->first_name . ' ' . $pc->last_name . ',</span>';
        } else {
          $body .= '<span style="font-size:16px; font-weight:bold;">Sehr geehrte Frau ' . $pc->first_name . ' ' . $pc->last_name . ',</span>';
        }
        
        $body .= '<br><br>';
        $body .= 'ein Mietvertrag wurde für Sie freigegeben: <a href="'.$config->domain . 'Dashboard/Details/id/'.$this->acquisition_id.'">Standortdetails</a>';
        $body .= '<br><br>';
        $body .= 'Mit freundlichen Grüßen,<br>';
        $body .= 'Ihr Standortfabrik-Team';
        $body .= '</body>';
        
        $email->CharSet = 'UTF-8';
        
        $email->msgHTML($body);
        
        if($email->send()) {
          $this->error['msg'][] = 'Eine E-Mail wurde an folgende Adresse gesendet: ' . $this->email;
        } else {
          $this->error['msg'][] = 'Leider konnte keine E-Mail gesendet werden.';
        }
      }
      }
      
      return $this->error;
    } else {
      return $this->error;
    }
    
  }
  
  public static function getPartnerOffer() {
    
    $return = array('data' => array(), 'count' => 0);
    
    $pid = Drunken_User::getUserId();
    
    $sql = 'SELECT * FROM partner_offer WHERE partner_id = "'.$pid.'"';
    $query = Drunken_Database::query($sql);
    
    $partner_offer = array();
    
    while($offer = Drunken_Database::fetchObject($query)) {
      array_push($partner_offer, $offer);
    }
    
    for($i = 0; $i < count($partner_offer); $i++) {
      $sql = 'SELECT * FROM acquisition WHERE id = "'.$partner_offer[$i]->acquisition_id.'"';
      $query = Drunken_Database::query($sql);
      
      while($aq = Drunken_Database::fetchObject($query)) {
        array_push($return['data'], $aq);
        $return['count']++;
      }
    }
    
    return $return;
  }
  
  public static function getOfferCourse($params) {
    $return = array('data' => array(), 'count' => 0);
    
    $sql_one = 'SELECT aq.id, o.id as owner_id, aq.city, aq.address, (SELECT name FROM status WHERE id = sc.status_id) as status_name, p.company,';
    $sql_one .= ' (SELECT concat(first_name, " ", last_name) FROM user WHERE id = sc.user_id) as status_user, sc.datetime as status_datetime,';
    $sql_one .= ' po.visible, po.offer, po.returned, po.accepted, po.datetime, po.updated, po.comment';
    
    $sql = ' FROM partner_offer as po';
    $sql .= ' LEFT JOIN acquisition as aq ON po.acquisition_id = aq.id';
    $sql .= ' LEFT JOIN owner as o ON aq.owner_id = o.id';
    $sql .= ' LEFT JOIN (SELECT t1.* FROM status_course as t1 WHERE t1.datetime = (SELECT MAX(t2.datetime) FROM status_course t2 WHERE t2.acquisition_id = t1.acquisition_id )) as sc ON sc.acquisition_id = aq.id';
    $sql .= ' LEFT JOIN partner as p ON po.partner_id = p.id';
    
    $where = 'WHERE';
      
    if(trim($params['acquisition_id']) != '') {
      $sql .= ' '.$where.' aq.id = "'.$params['acquisition_id'].'"';
      $where = 'AND';
    }
    
    if(trim($params['acquisition_zip_code']) != '') {
      $sql .= ' '.$where.' aq.zip_code like "%'.$params['acquisition_zip_code'].'%"';
      $where = 'AND';
    }
    
    if(trim($params['acquisition_city']) != '') {
      $sql .= ' '.$where.' aq.city like "%'.$params['acquisition_city'].'%"';
      $where = 'AND';
    }
    
    if(trim($params['acquisition_address']) != '') {
      $sql .= ' '.$where.' aq.address like "%'.$params['acquisition_address'].'%"';
      $where = 'AND';
    }
    
    if(isset($params['partner_id']) && trim($params['partner_id']) != '') {
      $sql .= ' '.$where.' partner_id = "'.$params['partner_id'].'"';
      $where = 'AND';
    }
    
    /**
     * Check total rows
     */
    $res = Drunken_Database::query('SELECT count(*) as total ' . $sql);
    $return['count'] = Drunken_Database::fetchObject($res)->total;
    
    if(isset($params['sort']) && $params['sort'] != '') {
      
      $order = 'datetime';
      
      switch ($params['order']) {
        case 'id':
          $order = 'aq.id';
          break;
        case 'city':
          $order = 'aq.city';
          break;
        case 'address':
          $order = 'aq.address';
          break;
        case 'partner':
          $order = 'p.id';
          break;
      }
      
      $sql .= ' ORDER BY '.$order.' ' . $params['sort'];
    }
    
    if(isset($params['max']) && isset($params['site'])) {
      $sql .= ' LIMIT '.$params['max'].' OFFSET ' . (($params['site'] - 1) * $params['max'] );
    }
    
//    die($sql_one . $sql);
    
    $query = Drunken_Database::query($sql_one . $sql);
    
    while($offer = Drunken_Database::fetchObject($query)) {
      array_push($return['data'], $offer);
    }
    
    return $return;
  }
  
  public static function getAllPartnerOffer() {
    
    $return = array('data' => array(), 'count' => 0);
    
    $sql = 'SELECT * FROM partner_offer';
    $query = Drunken_Database::query($sql);
    
    $partner_offer = array();
    
    while($offer = Drunken_Database::fetchObject($query)) {
      array_push($partner_offer, $offer);
    }
    
    for($i = 0; $i < count($partner_offer); $i++) {
      $sql = 'SELECT * FROM acquisition WHERE id = "'.$partner_offer[$i]->acquisition_id.'"';
      $query = Drunken_Database::query($sql);
      
      while($aq = Drunken_Database::fetchObject($query)) {
        array_push($return['data'], $aq);
        $return['count']++;
      }
    }
    
    return $return;
  }
  
  public static function checkOffer($pid, $aid) {
    
    if($pid == 25 || $pid == 29) {
        $sql = 'SELECT * FROM partner_offer WHERE (partner_id = 25 || partner_id = 29) AND acquisition_id = "'.$aid.'"';
    } else {
        $sql = 'SELECT * FROM partner_offer WHERE partner_id = "'.$pid.'" AND acquisition_id = "'.$aid.'"';
    }

    $sql .= ' ORDER BY datetime DESC LIMIT 1';
    $query = Drunken_Database::query($sql);
    
    if(mysqli_num_rows($query) > 0) {
      return true;
    }
  }

  public static function getPArtnerOfferByAcquisitionId($id) {
    $sql = 'SELECT * FROM partner_offer WHERE acquisition_id = "'.$id.'" ORDER BY datetime ASC';
    $query = Drunken_Database::query($sql);
    
    $partner_offer = array();
    
    while($po = Drunken_Database::fetchObject($query)) {
      array_push($partner_offer, $po);
    }
    
    return $partner_offer;
  }
  
  
  public static function getLastOfferByAcquisitionId($id) {
    $sql = 'SELECT * FROM partner_offer WHERE acquisition_id = "'.$id.'" ORDER BY datetime DESC LIMIT 1';
    $query = Drunken_Database::query($sql);
    
    return Drunken_Database::fetchObject($query);
  }
  
  public static function acceptOffer($id, $comment) {
    
    $date = new DateTime();
    $date = $date->format('Y-m-d H:i:s');
    
    $sql = 'UPDATE partner_offer SET accepted = 1, comment = "'.$comment.'", updated = "'.$date.'" WHERE acquisition_id = "'.$id.'" ORDER BY datetime desc LIMIT 1';
    
    if(Drunken_Database::query($sql)) {
      
//      $partner = Drunken_Partner::getPartnerByAcquisitionId($id);
//      $config = Drunken_Config_Ini::getConfig();
//      $qms = Drunken_User::getUsersByRoleId(array('3'));
//      
//      foreach($qms as $key => $qm) {
//        
//    	  $email = new Drunken_PhpMailer();
//        $email->From      = 'noreply@crm-standortfabrik.de';
//        $email->FromName  = 'Standortfabrik';
//        $email->Subject   = 'Password-Recovery';
//        
//        $email->AddAddress($qm->email);
//        
//        $body = '
//          <style>
//          	body { font-size:14px; font-family:Arial, Verdana, Georgia; }
//          </style>
//        ';
//        
//        
//        
//        $body .= '<body>';
//        $body .= '<span style="font-size:16px; font-weight:bold;">Hallo ' . $qm->first_name . ' ' . $qm->last_name . '!</span>';
//        $body .= '<br><br>';
//        $body .= 'Der Partner: <b>' . $partner->company . '</b> hat den <b><a target="_blank" href="'.$config->domain.'Boa/Einzeln/id/'.$id.'">Standort</a></b> <span style="color:green">angenommen</span>.';
//        $body .= '<br><br>';
//        $body .= 'Mit freundlichen Grüßen,<br>';
//        $body .= 'Ihr Standortfabrik-Team';
//        $body .= '</body>';
//        
//        $email->CharSet = 'UTF-8';
//        
//        $email->msgHTML($body);
//        
//        $email->send();
//      }
      
      return true;
    } else {
      return false;
    }
  }
  
  public static function rejectOffer($id, $comment) {
    
    $date = new DateTime();
    $date = $date->format('Y-m-d H:i:s');
    
    $sql = 'UPDATE partner_offer SET accepted = 2, comment = "'.$comment.'", updated = "'.$date.'" WHERE acquisition_id = "'.$id.'" ORDER BY datetime desc LIMIT 1';
    
    if(Drunken_Database::query($sql)) {
      
//      $partner = Drunken_Partner::getPartnerByAcquisitionId($id);
//      $config = Drunken_Config_Ini::getConfig();
//      $qms = Drunken_User::getUsersByRoleId(array('3'));
//      
//      foreach($qms as $key => $qm) {
//        
//    	  $email = new Drunken_PhpMailer();
//        $email->From      = 'noreply@crm-standortfabrik.de';
//        $email->FromName  = 'Standortfabrik';
//        $email->Subject   = 'Password-Recovery';
//        
//        $email->AddAddress($qm->email);
//        
//        $body = '
//          <style>
//          	body { font-size:14px; font-family:Arial, Verdana, Georgia; }
//          </style>
//        ';
//        
//        
//        
//        $body .= '<body>';
//        $body .= '<span style="font-size:16px; font-weight:bold;">Hallo ' . $qm->first_name . ' ' . $qm->last_name . '!</span>';
//        $body .= '<br><br>';
//        $body .= 'Der Partner: <b>' . $partner->company . '</b> hat den <b><a target="_blank" href="'.$config->domain.'Boa/Einzeln/id/'.$id.'">Standort</a></b> <span style="color:red">abgelehnt</span>.';
//        $body .= '<br><br>';
//        $body .= 'Mit freundlichen Grüßen,<br>';
//        $body .= 'Ihr Standortfabrik-Team';
//        $body .= '</body>';
//        
//        $email->CharSet = 'UTF-8';
//        
//        $email->msgHTML($body);
//        
//        $email->send();
//      }
      
      return true;
    } else {
      return false;
    }
  }
  
  public static function setOfferAs24HoursReturned($id) {
    
    $date = new DateTime();
    $date = $date->format('Y-m-d H:i:s');
    
    $sql = 'UPDATE partner_offer SET returned = 1, updated = "'.$date.'" WHERE acquisition_id = '.$id.' ORDER BY datetime desc LIMIT 1';
    if(Drunken_Database::query($sql)) {
      return true;
    } else {
      return false;
    }
  }
  
  public static function getAdoptedPartnerOfferForReminder() {
    $sql = 'SELECT t1.*, aq.* FROM partner_offer as t1 LEFT JOIN acquisition as aq ON aq.id = t1.acquisition_id WHERE t1.datetime = (SELECT MAX(t2.datetime) FROM partner_offer t2 WHERE t2.acquisition_id = t1.acquisition_id ) AND accepted = 1 AND (seen IS NULL || seen = 0)';
    
    $query = Drunken_Database::query($sql);
    $return = Array();
    while($row = Drunken_Database::fetchObject($query)) {
       $return[] = $row;
    }
    
    return $return;
  }
  
  public static function getRejectedPartnerOfferForReminder() {
    $sql = 'SELECT t1.*, aq.* FROM partner_offer as t1 LEFT JOIN acquisition as aq ON aq.id = t1.acquisition_id WHERE t1.datetime = (SELECT MAX(t2.datetime) FROM partner_offer t2 WHERE t2.acquisition_id = t1.acquisition_id ) AND accepted = 2 AND (seen IS NULL || seen = 0)';
    $query = Drunken_Database::query($sql);
    
    $return = Array();
    
    while($row = Drunken_Database::fetchObject($query)) {
      $return[] = $row;
    }
    
    return $return;
  }
  
  public static function getBackRunnerPartnerOfferForReminder() {
    $sql = 'SELECT t1.*, aq.* FROM partner_offer as t1 LEFT JOIN acquisition as aq ON aq.id = t1.acquisition_id WHERE t1.datetime = (SELECT MAX(t2.datetime) FROM partner_offer t2 WHERE t2.acquisition_id = t1.acquisition_id ) AND returned = 1 AND (seen IS NULL || seen = 0)';
    $query = Drunken_Database::query($sql);
    $return = Array();
    while($row = Drunken_Database::fetchObject($query)) {
      $return[] = $row;
    }
    
    return $return;
  }
  
  public static function setSeen($id) {
    $sql = 'SELECT t1.* FROM partner_offer as t1 WHERE t1.datetime = (SELECT MAX(t2.datetime) FROM partner_offer t2 WHERE t2.acquisition_id = t1.acquisition_id ) AND acquisition_id = "'.$id.'"';
    $query = Drunken_Database::query($sql);
    
    if(mysqli_num_rows($query) > 0) {
      $res = Drunken_Database::fetchObject($query);
      $sql = 'UPDATE partner_offer SET seen = 1 WHERE id = "'.$res->id.'"';
      if(Drunken_Database::query($sql)) {
        return true;
      } else {
        return false;
      }
    }
  }
}



?>