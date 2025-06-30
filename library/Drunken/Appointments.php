<?php

/**
 * @desc Appointments
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class Drunken_Appointments
{
  
  private static $return = array('data' => '', 'count' => 0);
  
  public static function getAppointments($params) {
    
    $sql = 'SELECT aq.*, (SELECT name FROM job_types WHERE id = aq.job_types_id) as job_type, sc.status_id as status_id, (SELECT id FROM user_roles WHERE id = (SELECT user_roles_id FROM status WHERE id = sc.status_id)) as status_user_roles_id, sc.period,';
    $sql .= ' sc.description as status_description, (SELECT CONCAT(first_name, " ", last_name)';
    $sql .= ' FROM user WHERE id = aq.user_id) as acquisiteur, (SELECT name FROM status WHERE id = sc.status_id) as status_name,';
    $sql .= '(SELECT concat(first_name, " ", last_name) FROM user WHERE id = sc.user_id) as status_user,';
    $sql .= ' owner.company as owner_company, owner.contact_person as owner_contact_person, owner.salutation as owner_salutation,';
    $sql .= ' owner.first_name as owner_first_name, owner.last_name as owner_last_name, owner.zip_code as owner_zip_code, owner.city as owner_city,';
    $sql .= ' owner.address as owner_address, owner.phone as owner_phone, owner.mobile as owner_mobile, owner.email as owner_email,';
    $sql .= ' owner.notice as owner_notice, (SELECT name FROM companies WHERE id = companies_id) as  company FROM acquisition as aq';
    
    $sql .= ' LEFT JOIN (SELECT t1.* FROM status_course as t1 WHERE t1.datetime = (SELECT MAX(t2.datetime)';
    $sql .= ' FROM status_course t2 WHERE t2.acquisition_id = t1.acquisition_id )) as sc ON sc.acquisition_id = aq.id';
    
    $sql .= ' LEFT JOIN owner as owner ON owner.id = aq.owner_id WHERE sc.period != ""';
    
    if($params['from'] && $params['from'] != '') {
      if($params['view'] && $params['view'] != '') {
        if($params['view'] == 'day') {
          $sql .= ' AND period like "'.$params['from'].'%"';
        } else if($params['view'] == 'month') {
          $sql .= ' AND (period BETWEEN "'.$params['from'].'" AND "'.$params['to'].'")';
        }
      }
    }
    
    if(isset($params['uid']) && trim($params['uid']) != '') {
      $sql .= ' AND aq.user_id = ' . $_POST['uid'];
    }
    
    if(isset($params['owner_type_id']) && trim($params['owner_type_id']) != '') {
      $sql .= ' AND aq.owner_types_id = ' . $_POST['owner_type_id'];
    }
    
    if($params['roles']) {
    	
    	$roles = array();
    	
    	if(in_array('4', $params['roles']) || in_array('5', $params['roles'])) {
    		array_push($roles, '4');
    		array_push($roles, '5');
    	}
    	
    	if(in_array('6', $params['roles'])) {
    		if(count($roles) <= 0) {
    			array_push($roles, '4');
    			array_push($roles, '5');
    		}
    		array_push($roles, '6');
    	}
    	
    	$sql .= ' AND (SELECT user_roles_id FROM status WHERE id = sc.status_id) IN ("'.implode('","', $roles).'")';
//    	die($sql);
    }
    
    $appointments = array();
    
    $query = Drunken_Database::query($sql);
    self::$return['count'] = $query->num_rows;
    
    $now = new DateTime();
    $now = $now->format('Y-m-d H:i:s');
    
    while($appointment = Drunken_Database::fetchObject($query)) {
      if($appointment->period < $now) {
        $appointment->missed = true;
      } else {
        $appointment->missed = false;
      }
      $appointments[] = $appointment;
    }
    
    self::$return['data'] = $appointments;
    
    return self::$return;
  }
  
  public static function getOpenAppointments($params) {
  	$sql = 'SELECT aq.*, (SELECT name FROM job_types WHERE id = aq.job_types_id) as job_type, sc.status_id, sc.period, sc.description as status_description, (SELECT CONCAT(first_name, " ", last_name) FROM user WHERE id = aq.user_id) as acquisiteur, (SELECT name FROM status WHERE id = sc.status_id) as status_name,';
    $sql .= '(SELECT concat(first_name, " ", last_name) FROM user WHERE id = sc.user_id) as status_user, owner.company as owner_company,';
    $sql .= 'owner.contact_person as owner_contact_person, owner.salutation as owner_salutation, owner.first_name as owner_first_name, owner.last_name as owner_last_name, owner.zip_code as owner_zip_code, owner.city as owner_city,';
    $sql .= 'owner.address as owner_address, owner.phone as owner_phone, owner.mobile as owner_mobile, owner.email as owner_email, owner.notice as owner_notice  FROM acquisition as aq LEFT JOIN (SELECT t1.* FROM status_course as t1 WHERE t1.datetime = (SELECT MAX(t2.datetime)';
    $sql .= 'FROM status_course t2 WHERE t2.acquisition_id = t1.acquisition_id )) as sc ON sc.acquisition_id = aq.id LEFT JOIN owner as owner ON owner.id = aq.owner_id WHERE sc.period != ""';
    
    if($params['until'] != '') {
    	$sql .= ' AND period <= "' . $params['until'] . '"';
    }
    
    $sql .= ' ORDER BY period ASC';
    
    $appointments = array();
    
//    die($sql);
    
    $query = Drunken_Database::query($sql);
    self::$return['count'] = $query->num_rows;
    
    while($appointment = Drunken_Database::fetchObject($query)) {
      $appointment->company = Drunken_Companies::translateCompanyId($appointment->companies_id);
      $appointments[] = $appointment;
    }
    
    self::$return['data'] = $appointments;
    
    return self::$return;
  }
}


?>