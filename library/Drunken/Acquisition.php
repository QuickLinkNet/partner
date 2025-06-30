<?php

/**
 * @desc Aquisitions
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class Drunken_Acquisition
{
  private $owner_id = '';
  private $user_id = '';
  private $companies_id = '';
  private $job_types_id = '';
  private $owner_types_id = '';
  private $address = '';
  private $zip_code = '';
  private $city = '';
  private $state = '';
  private $contract_duration = '';
  private $rent_offer = '';
  private $quantity = '';
  private $frequency = '';
  private $created = '';
  private $last_updated = '';
  private $acquisition_description = '';
    
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
    
public static function getAcquisitionsNew($params) {
    
    $return = array('data' => '', 'count' => 0, 'error_msg' => array(), 'success_msg' => array(), 'warnings' => array());
    
    $fields = array('acquisition_id' => 'aq.id as acquisition_id',
                    'acquisition_job_types_name' => '(SELECT name FROM job_types WHERE id = aq.job_types_id) as acquisition_job_types_name',
                    'acquisition_user_first_name' => '(SELECT first_name FROM user WHERE id = aq.user_id) as acquisition_user_first_name',
                    'acquisition_user_last_name' => '(SELECT last_name FROM user WHERE id = aq.user_id) as acquisition_user_last_name',
                    'acquisition_zip_code' => 'okz.zip_code as acquisition_zip_code',
                    'acquisition_okz' => 'okz.okz as acquisition_okz',
                    'acquisition_city' => 'okz.community as acquisition_city',
                    'acquisition_address' => 'aq.address as acquisition_address',
                    'acquisition_state' => 'states.name as acquisition_state',
                    'acquisition_contract_duration' => 'aq.contract_duration as acquisition_contract_duration',
                    'acquisition_rent_offer' => 'aq.rent_offer as acquisition_rent_offer',
                    'acquisition_quantity' => 'aq.quantity as acquisition_quantity',
                    'acquisition_frequency' => 'aq.frequency as acquisition_frequency',
                    'acquisition_created' => 'aq.created as acquisition_created',
                    'acquisition_last_updated' => 'aq.last_updated as acquisition_last_updated',
                    'acquisition_description' => 'aq.acquisition_description as acquisition_description',

										'manufacturer_id' => 'aq.manufacturer_id as manufacturer_id',
										'manufacturer_name' => 'ma.name as manufacturer_name',

                    'acquisition_geo_longitude' => 'aq_geo.longitude as acquisition_geo_longitude',
                    'acquisition_geo_latitude' => 'aq_geo.latitude as acquisition_geo_latitude',
    
                    'status_id' => 'sc.status_id as status_id',
                    'status_datetime' => 'sc.datetime as status_datetime',
                    'status_period' => 'sc.period as status_period',
                    'status_name' => '(SELECT name FROM status WHERE id = sc.status_id) as status_name',
                    'status_user_first_name' => '(SELECT first_name FROM user WHERE id = sc.user_id) as status_user_first_name',
                    'status_user_last_name' => '(SELECT last_name FROM user WHERE id = sc.user_id) as status_user_last_name',
                    'status_description' => 'sc.description as status_description',
    
                    'owner_id' => 'aq.owner_id',
                    'owner_company' => 'o.company as owner_company',
                    'owner_contact_person' => 'contact_person as owner_contact_person',
                    'owner_salutation' => 'o.salutation as owner_salutation',
                    'owner_title' => 'o.title as owner_title',
                    'owner_first_name' => 'o.first_name as owner_first_name',
                    'owner_last_name' => 'o.last_name as owner_last_name',
                    'owner_zip_code' => 'o.zip_code as owner_zip_code',
                    'owner_city' => 'o.city as owner_city',
                    'owner_address' => 'o.address as owner_address',
                    'owner_phone' => 'o.phone as owner_phone',
                    'owner_mobile' => 'o.mobile as owner_mobile',
    
                    'partner_offer_visible' => 'po.visible as partner_offer_visible',
                    'partner_offer_offer' => 'po.offer as partner_offer_offer',
                    'partner_offer_accepted' => 'po.accepted as partner_offer_accepted',
                    'partner_offer_comment' => 'po.comment as partner_offer_comment',
                    'partner_offer_datetime' => 'po.datetime as partner_offer_datetime',
                    
                    'partner_company' => 'p.company as partner_company',
                    'partner_zip_code' => 'p.zip_code as partner_zip_code',
                    'partner_city' => 'p.city as partner_city',
                    'partner_address' => 'p.address as partner_address'
                    
//                    'lawyer_id'
    );
    
    $fields_selected = array();
    
    foreach($params['fields'] as $key => $field_name) {
      if(array_key_exists($field_name, $fields)) {
        array_push($fields_selected, $fields[$field_name]);
      } else {
        $return['error_msg'][] = 'Field not found: ' . $field_name;
      }
    }

    $sql_fields = '';
    $sql = '';
    $sql_big = '';
    $sql_count = '';
    
    
    $sql_big .= 'SELECT ' . implode(', ', $fields_selected) . ' FROM acquisition as aq';
    $sql_count .= 'SELECT COUNT(*) as count FROM acquisition as aq';


    /** MANUFACTURER **/
    $search = array('manufacturer_name');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))) {
        $sql .= ' LEFT JOIN manufacturer as ma on aq.manufacturer_id = ma.id';
    }

  	/** OKZ **/
    $search = array('acquisition_city', 'acquisition_zip_code', 'acquisition_state');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))) {
      $sql .= ' LEFT JOIN okz as okz on aq.okz_id = okz.id';
    }
    
  	/** States **/
    $search = array('acquisition_state');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))) {
      $sql .= ' LEFT JOIN states as states on okz.states_id = states.id';
    }
    
    /** Status_course **/
    $search = array('status_id', 'status_datetime', 'status_name', 'status_user_first_name', 'status_user_last_name', 'status_description', 'list');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))) {
      $sql .= ' LEFT JOIN (SELECT t1.* FROM status_course as t1 WHERE t1.datetime = (SELECT MAX(t2.datetime) FROM status_course t2 WHERE t2.acquisition_id = t1.acquisition_id )) as sc ON sc.acquisition_id = aq.id';
    }
    
    /** User **/
    $search = array('acquisition_user_id', 'acquisition_user_first_name', 'acquisition_user_last_name');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))) {
      $sql .= ' LEFT JOIN user as u ON aq.user_id = u.id';
    }
    
    
    /** Owner **/
    $search = array('owner_company', 'owner_name', 'owner_first_name', 'owner_last_name', 'owner_zip_code', 'owner_city', 'owner_address', 'owner_phone', 'owner_mobile');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))) {
      $sql .= ' LEFT JOIN owner as o ON o.id = aq.owner_id';
    }
    
  	/** Partner Offer **/
    $search = array('partner_id', 'partner_offer_visible', 'partner_offer_offer', 'partner_offer_accepted', 'partner_released', 'partner_view', 'partner_offer', 'partner_all', 'partner_back_runner');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))) {
      $sql .= ' LEFT JOIN (SELECT t1.* FROM partner_offer as t1 WHERE t1.datetime = (SELECT MAX(t2.datetime) FROM partner_offer t2 WHERE t2.acquisition_id = t1.acquisition_id )) as po ON po.acquisition_id = aq.id';
    }
    
    /** Partner **/
    $search = array('partner_id', 'partner_company', 'partner_zip_code', 'partner_city', 'partner_address');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))) {
      $sql .= ' LEFT JOIN partner as p ON p.id = po.partner_id';
    }
    
    /** AQ-Geo **/
    $search = array('acquisition_geo_longitude', 'acquisition_geo_latitude');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))) {
      $sql .= ' LEFT JOIN acquisition_geo as aq_geo ON aq_geo.acquisition_id = aq.id';
    }
    
  	/** Lawyer-Transfer **/
    $search = array('lawyer_id');
    if(count(array_diff($search, $params['fields'])) < count($search) || (isset($params['filter']) && count(array_diff($search, array_keys($params['filter']))) < count($search))
      || (isset($params['extra']['is_lawyer']) || isset($params['extra']['is_not_lawyer']))) {
      $sql .= ' LEFT JOIN lawyer_transfers as lt ON lt.acquisition_id = aq.id';
    }
    
    $filter_fields = array(	'acquisition_id' => 'aq.id = "VAR"',
                           	'acquisition_zip_code' => 'okz.zip_code like "%VAR%"',
                           	'acquisition_city' => 'okz.community like "%VAR%"',
                           	'acquisition_address' => 'aq.address like "%VAR%"',
                           	'acquisition_user_id' => 'aq.user_id = "VAR"',
                           	'acquisition_state' => 'aq.state like "%VAR%"',
                            'acquisition_contract_duration' => 'aq.contract_duration = "VAR"',
                            'acquisition_rent_offer' => 'aq.rent_offer = "VAR"',
                            'acquisition_quantity' => 'aq.quantity = "VAR"',
                            'acquisition_frequency' => 'aq.frequency = "VAR"',
                            'acquisition_job_type_name' => 'aq.job_types_id = "VAR"',
    
                            'lawyer_id' => 'lt.lawyer_id = "VAR"',
    
                            /**
                             * TODO
                             * FROM / UNTIL
                             * DESCRIPTION
                             * ...
                             */
//                            'acquisition_created' => 'aq.created as ',
//                            'acquisition_last_updated' => 'aq.last_updated as acquisition_last_updated',
//                            'acquisition_description' => 'aq.description as acquisition_description',
                            
                            'status_id' => 'sc.status_id = "VAR"',
    
                            /**
                             * TODO
                             * FROM / UNTIL
                             */
                            'status_datetime' => 'sc.datetime as status_datetime',
                            'status' => 'sc.status_id IN("VAR")',
                            'status_not' => 'sc.status_id NOT IN("VAR")',
                            'status_name' => '(SELECT name FROM status WHERE id = sc.status_id) like "%VAR%"',
                            'status_user_first_name' => '(SELECT first_name FROM user WHERE id = sc.user_id) like "%VAR%"',
                            'status_user_last_name' => '(SELECT last_name FROM user WHERE id = sc.user_id) like "%VAR%"',
                            'status_description' => 'sc.description like "%VAR%"',
            
                            'owner_id' => 'aq.owner_id like "%VAR%"',
                            'owner_company' => 'o.company like "%VAR%"',
                            'owner_name' => '(o.first_name like "%VAR%" OR o.last_name like "%VAR%")',
                            'owner_zip_code' => 'o.zip_code like "%VAR%"',
                            'owner_city' => 'o.city like "%VAR%"',
                            'owner_address' => 'o.address like "%VAR%"',
                            'owner_phone' => 'o.phone like "%VAR%"',
                            'owner_mobile' => 'o.mobile like "%VAR%"',
                            'owner_phone_mobile' => '(o.phone like "%VAR%" OR o.mobile like "%VAR%")',
            
                            'partner_offer_visible' => 'po.visible = "VAR"',
                            'partner_offer_offer' => 'po.offer = "VAR"',
                            'partner_offer_accepted' => 'po.accepted = "VAR"',
                            
                            /**
                             * TODO
                             * FROM / UNTIL
                             */
                            'partner_offer_datetime' => 'po.datetime',
                            
                            'partner_id' => 'p.id = "VAR"',
                            'partner_company' => 'p.company like "%VAR%"',
                            'partner_zip_code' => 'p.zip_code like "%VAR%"',
                            'partner_city' => 'p.city like "%VAR%"',
                            'partner_address' => 'p.address like "%VAR%"',
                            
                            'partner_released' => 'offer = 1 && accepted != 2 && accepted != 3 && returned != 1',
                            'partner_view' => 'visible = 1',
                            'partner_offer' => '(visible != 0 || offer != 0) && accepted != 2 && accepted != 3 && returned != 1',
                            'partner_all' => '((visible = 0 && offer = 0 || visible IS NULL && offer IS NULL) || returned = 1 || accepted = 2)',
                            'partner_back_runner' => 'returned = 1'
                            );
    
    $where = ' WHERE';
    
    
    
  	if(isset($params['filter']['list']) && Drunken_Lists::listExist($params['filter']['list']) && !isset($params['filter']['status'])) {
      $list = Drunken_Lists::getListStatus($params['filter']['list']);
      $status = (array) json_decode($list->status);
      
      if(count($status) > 0) {
      	$params['filter']['status'] = $status;
      }
    }
    
    if(isset($params['fields']) && (in_array('acquisition_geo_longitude', $params['fields']) || in_array('acquisition_geo_latitude', $params['fields']))) {
    	$sql .= $where . ' aq_geo.longitude != "" AND aq_geo.latitude != ""';
    	$where = ' AND';
    }
    
    if(isset($params['filter']) && count($params['filter']) > 0) {
      foreach($params['filter'] as $key => $filter) {
        if(isset($filter_fields[$key])) {
          if(is_string($filter) && trim($filter) != '') {
            $sql .= ' ' . $where . ' ' . str_replace('VAR', $filter, $filter_fields[$key]);
            $where = 'AND';
          } else if(is_array($filter) && count($filter) > 0) {
            $sql .= ' ' . $where . ' ' . str_replace('VAR', implode('", "', $filter), $filter_fields[$key]);
            $where = 'AND';
          }
        } else {
          $return['warnings'][] = 'Filterfield: "'.$key.'" not found.';
        }
      }
    }
    
    
    
    
//    if(isset($params['extra']['partner_offer'])) {
//    	$sql .= ' ' . $where . ' (visible != 0 || offer != 0) && accepted != 2 && accepted != 3 && returned != 1 ';
//    }
    
    
    
    /**
     * Check if location has lawyer
     */
    if(isset($params['extra']['is_lawyer']) && $params['extra']['is_lawyer'] == true) {
      $sql .= ' '.$where.' lt.id IS NOT NULL';
    }
    
    if(isset($params['extra']['is_not_lawyer']) && $params['extra']['is_not_lawyer'] == true) {
      $sql .= ' '.$where.' lt.id IS NULL';
    }
    
    
    
  	if(isset($params['extra']['is_telefony_recall']) && $params['extra']['is_telefony_recall'] == true) {
      $sql .= ' AND ((sc.period IS NOT NULL AND NOW() > DATE_SUB(sc.period, INTERVAL 1 MONTH)) OR sc.period IS NULL)';
    }
    
  	if(isset($params['extra']['is_not_telefony_recall']) && $params['extra']['is_not_telefony_recall'] == true) {
      $sql .= ' AND (sc.period IS NOT NULL AND NOW() < DATE_SUB(sc.period, INTERVAL 1 MONTH))';
    }
    
    /**
     * Count rows
     */
    $query = Drunken_Database::query($sql_count . $sql);
    $return['count'] = Drunken_Database::fetchObject($query)->count;
   
    
    if(isset($params['order']['order']) && trim($params['order']['order']) != '') {
      if(in_array($params['order']['order'], $params['fields'])) {
        $order = $params['order']['order'];
      } else {
        $return['warnings'][] = 'Order-Row isn�t selected.';
      }
    }
    
    if(isset($order) && $params['order']['sort']) {
      $sql .= ' ORDER BY '.$order.' ' . $params['order']['sort'];
    }
		
    if(isset($params['order']['max'])) {
    	$sql .= ' LIMIT ' . $params['order']['max'] . ' OFFSET ' . (($params['order']['site'] - 1) * $params['order']['max']);
    }
    
//    die($sql_big . $sql);

    $query = Drunken_Database::query($sql_big . $sql);
    $acquisitions = array();
    
    while($acquisition = Drunken_Database::fetchObject($query)) {
    	
    	/**
    	 * Get rest time if it is set to an partner as an offer (not only visible)
    	 */
    	if(isset($params['filter']['partner_offer'])) {
	      if($acquisition->partner_offer_offer == 1 && $acquisition->partner_offer_accepted == 0) {
	      	
	        $end = Drunken_Functions::calculateDateWithoutWeekend($acquisition->partner_offer_datetime, 24);
	        
	        /**
	         * TODO
	         * 2014-12-31 00:00:00
	         * Only for this year?
	         */
	        
	        if(Drunken_Holidays::isHoliday($end)) {
	          $end = Drunken_Functions::calculateDateWithoutWeekend($end, 24);
	        }
	        
	        $now = new DateTime();
	        $now = date_format($now, 'Y-m-d H:i:s');
	        
	        if($now > $end) {
	          /**
	           * Reset the offer
	           */
	          Drunken_Partner_Offer::setOfferAs24HoursReturned($acquisition->acquisition_id);
	          
	          unset($acquisitions['data'][$key]);
	        } else {
	          $diff = strtotime($end) - strtotime($now);
	          $acquisition->rest_time = $diff;
	        }
	      }
    	}
    	
      /**
       * Get original photo
       */
      if(isset($params['extra']['acquisition_original_photo'])) {
        $acquisition->acquisition_original_photo = self::getOriginalAcquisitionPhotobyId($acquisition->acquisition_id);
      }
      
    	/**
       * Get retouched photo
       */
      if(isset($params['extra']['acquisition_retouched_photo'])) {
        $acquisition->acquisition_retouched_photo = self::getRetouchedAcquisitionPhotobyId($acquisition->acquisition_id);
      }
      
      if(isset($params['extra']['last_photo_fitter_name'])) {
        $acquisition->last_photo_fitter = Drunken_StatusCourse::getLastPhotoFitterByAcquisitionId($acquisition->acquisition_id);
      }
      
      array_push($acquisitions, $acquisition);
    }
    
    $return['data'] = $acquisitions;
    
    return $return;
  }
  
	public static function acquisitionExist($id) {
        $sql = 'SELECT * FROM acquisition WHERE id = "'.$id.'"';
        $query = Drunken_Database::query($sql);
        if(mysqli_num_rows($query) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
  public static function getAcquisitionById($aid) {
      $sql = 'SELECT aq.*, okz.community as city, okz.zip_code as zip_code, states.name as state FROM acquisition as aq';
      $sql .= ' LEFT JOIN okz on okz.id = aq.okz_id';
      $sql .= ' LEFT JOIN states on okz.states_id = states.id';
      $sql .= ' WHERE aq.id = "'.$aid.'"';
      
      $query = Drunken_Database::query($sql);
      
      $aq = Drunken_Database::fetchObject($query);
      
      $aq->owner = Drunken_Owner::getOwnerById($aq->owner_id);
      $aq->current_status = Drunken_StatusCourse::getCurrentStatByAcquisitionId($aq->id);
      $aq->current_status->user = Drunken_User::getUserById($aq->current_status->user_id);
      $aq->original_photo = self::getOriginalAcquisitionPhotobyId($aq->id);
      $aq->retouched_photo = self::getRetouchedAcquisitionPhotobyId($aq->id);
      
      $aq->user = $user = Drunken_User::getUserById($aq->user_id);
      
      return $aq;
  }
  
  public static function getOriginalAcquisitionPhotobyId($aid) {
    $path = './data/acquisition/';
    if(file_exists($path . $aid)) {
      $dirs = scandir($path . $aid);
      foreach($dirs as $key => $file) {
        if(strpos($file, 'original') !== false) {
          return '/data/acquisition/' . $aid . '/' . $file;
        }
      }
    }
    return false;
  }
    
  public static function getRetouchedAcquisitionPhotobyId($aid) {
    $path = './data/acquisition/';
    if(file_exists($path . $aid)) {
      $dirs = scandir($path . $aid);
      foreach($dirs as $key => $file) {
        if(strpos($file, 'retouched') !== false) {
          return '/data/acquisition/' . $aid . '/' . $file;
        }
      }
    }
    return false;
  }
}

?>