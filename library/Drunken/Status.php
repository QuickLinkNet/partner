<?php

/**
 * 
 * @desc Status
 * @author Manuel Kramm
 * @version 1.0
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 */

class Drunken_Status
{
    /**
     * @desc Get all status for quality management
     * @return array of objects
     */
    public static function getStatusForQM() {
        
        $sql = 'SELECT * FROM status WHERE user_roles_id = 3';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
            $status[$stat->id] = $stat;
        }
        
        return $status;
    }
    
    public static function getStatus() {
    	$sql = 'SELECT * FROM status ORDER BY name';
      $query = Drunken_Database::query($sql);
      
      $status = array();
      
      while($stat = Drunken_Database::fetchObject($query)) {
        $status[] = $stat;
      }
      
      return $status;
    }
    
    public static function setStatusFilter($sid, $before, $last) {
    	
    	$b = (array) json_decode($before);
    	$l = (array) json_decode($last);
    	
    	$sql = 'UPDATE status SET before_filter = "'.mysqli_escape_string(Drunken_Database::getConnection(), $before).'", last_filter = "'.mysqli_escape_string(Drunken_Database::getConnection(), $last).'" WHERE id = "'.$sid.'"';
    	return Drunken_Database::query($sql);
    }
    
    public static function getStatusAll($aid) {
      $sql = 'SELECT * FROM status WHERE visible = true ORDER BY name';
      $query = Drunken_Database::query($sql);
      
      /**
       * 3 = Qualitätsmanagement
       * 4 = Telefonie
       * 5 = Vertragsbetreuung
       * 6 = BOA
       * 7 = Fotomontage
       * 8 = Akquisition
       * 9 = Rechtsanwalt
       */
      
      $status = array();
      $status['Qualitätsmanagement'] = array();
      $status['Telefonie'] = array();
      $status['Vertragsbetreuung'] = array();
      $status['BOA'] = array();
      $status['Fotomontage'] = array();
      $status['Akquisition'] = array();
      $status['Rechtsanwalt'] = array();
      
      while($stat = Drunken_Database::fetchObject($query)) {
      	
      	if($aid != '') {
      		
      		$stat->active = true;
      		
	      	$before = (array) json_decode($stat->before_filter);
	      	$last = (array) json_decode($stat->last_filter);
	      	
	      	if(count($before) > 0) {
	      		foreach($before as $key => $sid) {
	      			if(!Drunken_StatusCourse::checkCourseOfId($aid, $sid)) {
	      				$stat->active = false;
	      				break;
	      			}
	      		}
	      	}
	      	
	      	if($stat->active != false) {
		      	if(count($last) > 0) {
		      		foreach($last as $key => $sid) {
		      			if(!Drunken_StatusCourse::checkLastStatus($aid, $sid)) {
		      				$stat->active = false;
		      				break;
		      			}
		      		}
		      	}
	      	}
      	}
      	
        if($stat->user_roles_id == 3) {
          $status['Qualitätsmanagement'][$stat->name] = $stat;
        } else if($stat->user_roles_id == 4) {
          $status['Telefonie'][$stat->name] = $stat;
        } else if($stat->user_roles_id == 5) {
          $status['Vertragsbetreuung'][$stat->name] = $stat;
        } else if($stat->user_roles_id == 6) {
          $status['BOA'][$stat->name] = $stat;
        } else if($stat->user_roles_id == 7) {
          $status['Fotomontage'][$stat->name] = $stat;
        } else if($stat->user_roles_id == 8) {
          $status['Akquisition'][$stat->name] = $stat;
        } else if($stat->user_roles_id == 9) {
          $status['Rechtsanwalt'][$stat->name] = $stat;
        }
      }
      
      return $status;
    }
    
    
    public static function getStatusAllWithoutDepartments() {
    	$sql = 'SELECT * FROM status';
    	$query = Drunken_Database::query($sql);
    	
    	$status = array();
    	
    	if(mysqli_num_rows($query) > 0) {
    		while($row = Drunken_Database::fetchObject($query)) {
    			$status[$row->id] = $row->name;
    		}
    	}
    	
    	return $status;
    }
    
		/**
     * @desc Get all status for telephony
     * @return array of objects
     */
    public static function getStatusForTelephony($aid) {
        
        $sql = 'SELECT * FROM status WHERE (user_roles_id = 4 OR id = 22) AND visible = true';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
        	
	        if($aid != '') {
	      		
	      		$stat->active = true;
	      		
		      	$before = (array) json_decode($stat->before_filter);
		      	$last = (array) json_decode($stat->last_filter);
		      	
		      	if(count($before) > 0) {
		      		foreach($before as $key => $sid) {
		      			if(!Drunken_StatusCourse::checkCourseOfId($aid, $sid)) {
		      				$stat->active = false;
		      				break;
		      			}
		      		}
		      	}
		      	
		      	if($stat->active != false) {
			      	if(count($last) > 0) {
			      		foreach($last as $key => $sid) {
			      			if(!Drunken_StatusCourse::checkLastStatus($aid, $sid)) {
			      				$stat->active = false;
			      				break;
			      			}
			      		}
			      	}
		      	}
	      	}
        	
          $status['Telefonie'][$stat->id] = $stat;
        }
        
        return $status;
    }
    
		/**
     * @desc Get all status for telephony
     * @return array of objects
     */
    public static function getStatusForPhotographie() {
        
        $sql = 'SELECT * FROM status WHERE user_roles_id = 7';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
            $status[$stat->id] = $stat;
        }
        
        return $status;
    }
    
		/**
     * @desc Get all status for archive
     * @return array of objects
     */
    public static function getStatusArchive() {
        
        $sql = 'SELECT * FROM status WHERE id IN("4", "8", "12", "24", "34")';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
            $status[$stat->id] = $stat;
        }
        
        return $status;
    }
    
		/**
     * @desc Get all status for archive
     * @return array of objects
     */
    public static function getStatusContract($aid) {
        
        $sql = 'SELECT * FROM status WHERE user_roles_id = 5 AND visible = true';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        $status['Vertragsbetreuung'] = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
        	
        	if($aid != '') {
	      		
	      		$stat->active = true;
	      		
		      	$before = (array) json_decode($stat->before_filter);
		      	$last = (array) json_decode($stat->last_filter);
		      	
		      	if(count($before) > 0) {
		      		foreach($before as $key => $sid) {
		      			if(!Drunken_StatusCourse::checkCourseOfId($aid, $sid)) {
		      				$stat->active = false;
		      				break;
		      			}
		      		}
		      	}
		      	
		      	if($stat->active != false) {
			      	if(count($last) > 0) {
			      		foreach($last as $key => $sid) {
			      			if(!Drunken_StatusCourse::checkLastStatus($aid, $sid)) {
			      				$stat->active = false;
			      				break;
			      			}
			      		}
			      	}
		      	}
	      	}
        	
          $status['Vertragsbetreuung'][$stat->id] = $stat;
        }
        
        return $status;
    }
    
		/**
     * @desc Get all status for archive
     * @return array of objects
     */
    public static function getStatusBoa() {
        
        $sql = 'SELECT * FROM status WHERE user_roles_id = 6';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
            $status[$stat->id] = $stat;
        }
        
        return $status;
    }
    
		/**
     * @desc Get all status for telephony
     * @return array of objects
     */
    public static function getStatusForBoa($aid = '') {
        
        $sql = 'SELECT * FROM status WHERE user_roles_id = 6 AND visible = true';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
        	
        	if($aid != '') {
	      		
	      		$stat->active = true;
	      		
		      	$before = (array) json_decode($stat->before_filter);
		      	$last = (array) json_decode($stat->last_filter);
		      	
		      	if(count($before) > 0) {
		      		foreach($before as $key => $sid) {
		      			if(!Drunken_StatusCourse::checkCourseOfId($aid, $sid)) {
		      				$stat->active = false;
		      				break;
		      			}
		      		}
		      	}
		      	
		      	if($stat->active != false) {
			      	if(count($last) > 0) {
			      		foreach($last as $key => $sid) {
			      			if(!Drunken_StatusCourse::checkLastStatus($aid, $sid)) {
			      				$stat->active = false;
			      				break;
			      			}
			      		}
			      	}
		      	}
	      	}
        	
          $status[$stat->id] = $stat;
        }
        
        return $status;
    }
    
		/**
     * @desc Get all status for telephony
     * @return array of objects
     */
    public static function getStatusForRa($aid = '') {
        
        $sql = 'SELECT * FROM status WHERE user_roles_id = 9';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
        	
        	if($aid != '') {
	      		
	      		$stat->active = true;
	      		
		      	$before = (array) json_decode($stat->before_filter);
		      	$last = (array) json_decode($stat->last_filter);
		      	
		      	if(count($before) > 0) {
		      		foreach($before as $key => $sid) {
		      			if(!Drunken_StatusCourse::checkCourseOfId($aid, $sid)) {
		      				$stat->active = false;
		      				break;
		      			}
		      		}
		      	}
		      	
		      	if($stat->active != false) {
			      	if(count($last) > 0) {
			      		foreach($last as $key => $sid) {
			      			if(!Drunken_StatusCourse::checkLastStatus($aid, $sid)) {
			      				$stat->active = false;
			      				break;
			      			}
			      		}
			      	}
		      	}
	      	}
        	
          $status[$stat->id] = $stat;
        }
        
        return $status;
    }
    
		/**
     * @desc Get all status for contracting services
     * @return array of objects
     */
    public static function getStatusForContractingServices() {
        
        $sql = 'SELECT * FROM status WHERE user_roles_id = 5';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
            $status[$stat->id] = $stat;
        }
        
        return $status;
    }
    
		/**
     * @desc Get all status for contracting services
     * @return array of objects
     */
    public static function getStatusForPhotoMontage() {
        
        $sql = 'SELECT * FROM status WHERE user_roles_id = 7';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
            $status[$stat->id] = $stat;
        }
        
        return $status;
    }
    
    /**
     * @desc Get status by id
     * @param object $id
     */
    public static function getStatusById($id) {
        $sql = 'SELECT * FROM status WHERE id = "'.$id.'"';
        $query = Drunken_Database::query($sql);
        
        $res = Drunken_Database::fetchObject($query);
        
        return $res->name;
    }
    
		/**
     * @desc Get status by id
     * @param object $id
     */
    public static function getFullStatusById($id) {
        $sql = 'SELECT * FROM status WHERE id = "'.$id.'"';
        $query = Drunken_Database::query($sql);
        
        $res = Drunken_Database::fetchObject($query);
        
        return $res;
    }
    
    /**
     * @desc Translate status id
     * @param string $sid
     */
    public static function translateStatusId($sid) {
        $sql = 'SELECT * FROM status WHERE id = "'.$sid.'"';
        $query = Drunken_Database::query($sql);
        $res = Drunken_Database::fetchObject($query);
        return $res->name;
    }
    
    public static function getStatusForCalendar($status_id) {
      $sql = 'SELECT * FROM status WHERE user_roles_id = (SELECT user_roles_id FROM status WHERE id = '.$status_id.')';
      $query = Drunken_Database::query($sql);
      
      $status = array();
      
      while($s = Drunken_Database::fetchObject($query)) {
        
        if(!isset($status[Drunken_User_Roles::translateRoleId($s->user_roles_id)->name])) {
          $status[Drunken_User_Roles::translateRoleId($s->user_roles_id)->name] = array();
        }
        
        array_push($status[Drunken_User_Roles::translateRoleId($s->user_roles_id)->name], $s);
        
      }
      
      return $status;
    }
    
		/**
     * @desc Get all status for contracting services
     * @return array of objects
     */
    public static function getStatusForLawyer() {
        
        $sql = 'SELECT * FROM status WHERE user_roles_id = 9';
        $query = Drunken_Database::query($sql);
        
        $status = array();
        
        while($stat = Drunken_Database::fetchObject($query)) {
            $status[$stat->id] = $stat;
        }
        
        return $status;
    }
    
    public static function getSetStatuses($params) {
      
      $return = array('data' => array(), 'count' => 0);
      
      $sql = 'SELECT aq.*, (SELECT name FROM status WHERE id = sc.status_id) as status_name, (SELECT CONCAT(first_name, " ", last_name) FROM user WHERE id = sc.user_id) as username, sc.datetime as status_datetime FROM status_course as sc';
			$sql .= ' LEFT JOIN acquisition as aq ON sc.acquisition_id = aq.id';
      
      $where = ' WHERE ';
      
      if(isset($params['uid']) && $params['uid'] != '') {
        $sql .= $where . ' sc.user_id = ' . $params['uid'];
        $where = ' AND ';
      }
      
      if(isset($params['status']) && $params['status'] != '') {
        $sql .= $where . ' status_id = ' . $params['status'];
        $where = ' AND ';
      }
      
      if(isset($params['from']) && $params['from'] != '') {
        $sql .= $where . ' sc.datetime > "' . $params['from'] . '"';
        $where = ' AND ';
      }
      
      if(isset($params['until']) && $params['until'] != '') {
        $sql .= $where . ' sc.datetime < "' . $params['until'] . '"';
        $where = ' AND ';
      }
      
      if($params['sort']) {
        
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
          case 'status':
            $order = 'status_name';
            break;
          case 'user':
            $order = 'sc.user_id';
            break;
        }
        
        $sql .= ' ORDER BY '.$order.' ' . $params['sort'];
      }
      
      $return['count'] = mysqli_num_rows(Drunken_Database::query($sql));
      
      if(isset($params['max']) && $params['max'] != '' && isset($params['site']) && $params['site'] != '') {
        
        $offset = ($params['site'] * $params['max']) - $params['max'];
        
        $sql .= ' LIMIT ' . $params['max'] . ' OFFSET ' . $offset;
      }
      
      $query = Drunken_Database::query($sql);
      
      while($row = Drunken_Database::fetchObject($query)) {
        $return['data'][] = $row;
      }
      
      return $return;
    }
    
  public static function getSetStatusesForLineBasic($params) {
  	
  	$return = array('data' => array(), 'count' => 0);
  	
  	/**
  	 * PARAMS
  	 * 
  	 * From date				2016-01-01 00:00:00
  	 * Until date				2016-01-01 00:00:00
  	 * 
  	 * Display					Year / Month / Period
  	 * 
  	 * display_status		all_individually / all_together / id
  	 * display_user			x / id
  	 */
  	
  	
  	$head = array();
  	
  	if(isset($params['display_status']) && $params['display_status'] == 'all_individually') {
	  	$sql = 'SELECT * FROM status';
	    $query = Drunken_Database::query($sql);
	    
	    while($row = Drunken_Database::fetchObject($query)) {
	    	$head[$row->id] = $row->name;
	    	$return['data'][$row->id] = Array();
	    	$return['data'][$row->id]['data'] = Array();
	    	$return['data'][$row->id]['name'] = $row->name;
	    }
  	} else if(isset($params['display_status']) && $params['display_status'] == 'all_together') {
  		$head['Alle Stati'] = 'Alle Stati';
  		$return['data']['Alle Stati'] = Array();
  		$return['data']['Alle Stati']['data'] = Array();
  		$return['data']['Alle Stati']['name'] = 'Alle Stati';
  	} else if(is_numeric($params['display_status'])) {
  		$name = Drunken_Status::getStatusById($params['display_status']);
  		$head[$name] = $name;
  		$return['data'][$name] = Array();
  		$return['data'][$name]['data'] = Array();
  		$return['data'][$name]['name'] = $name;
  	}
  	
  	
  	$months = Array(1 => 'Januar',2 => 'Februar',3 => 'März',4 => 'April',5 => 'Mai',6 => 'Juni',
  									7 => 'Juli',8 => 'August',9 => 'September',10=> 'Oktober',11 => 'November',12 => 'Dezember');
  	
    $sql = 'SELECT * FROM status_course as sc';
    
    $where = ' WHERE ';
    
    if(isset($params['display_user']) && $params['display_user'] != '' && $params['display_user'] != 'all') {
      $sql .= $where . ' sc.user_id = ' . $params['display_user'];
      $where = ' AND ';
    }
    
    if(isset($params['status']) && $params['status'] != '') {
      $sql .= $where . ' status_id = ' . $params['status'];
      $where = ' AND ';
    }
    
    /**
     * Month
     */
    if(isset($params['display']) && $params['display'] == 'month' && isset($params['display_year']) && $params['display_year'] != ''
    	&& isset($params['display_month']) && $params['display_month'] != '') {
    	$sql .= $where . ' sc.datetime like "%'.$params['display_year'].'-'.($params['display_month'] < 10 ? '0'.$params['display_month'] : $params['display_month']).'%"';
    	$where = ' AND ';
    	
    	$days_in_month = cal_days_in_month(CAL_GREGORIAN, $params['display_month'], $params['display_year']); // 31
    	
    	foreach($head as $key => $value) {
	    	for($i = 1; $i <= $days_in_month; $i++) {
	    		$return['data'][$key]['data'][($i < 10 ? '0'.$i : $i) . '.' . ($params['display_month'] < 10 ? '0'.$params['display_month'] : $params['display_month'])] = 0;
	    	}
      }
    	
    /**
     * Period
     */
    } else if(isset($params['display']) && $params['display'] == 'period' && isset($params['period_from']) && $params['period_from'] != ''
    	&& isset($params['period_until']) && $params['period_until'] != '') {
    	
    	$from = substr($params['period_from'], 6, 4) . '-' . substr($params['period_from'], 3, 2) . '-' . substr($params['period_from'], 0, 2) . ' 00:00:00';
    	
    	$until = substr($params['period_until'], 6, 4) . '-' . substr($params['period_until'], 3, 2) . '-' . substr($params['period_until'], 0, 2) . ' 23:59:59';
    	
    	$sql .= $where . 'sc.datetime > "'.$from.'" AND sc.datetime < "'.$until.'"';
    	$where = ' AND ';
    	
    	$from_date = $params['period_from'];
    	$from_date = new DateTime(substr($from_date, 6, 4) . '-' . substr($from_date, 3, 2) . '-' . substr($from_date, 0, 2));
    	
    	$until_date = $params['period_until'];
    	$until_date = new DateTime(substr($until_date, 6, 4) . '-' . substr($until_date, 3, 2) . '-' . substr($until_date, 0, 2));
    	
    	foreach($head as $key => $value) {
	    	while($from_date <= $until_date) {
	    		$m = $from_date->format('m');
	    		$d = $from_date->format('d');
	    		$return['data'][$key]['data'][$d . '.' . $m] = 0;
	    		date_add($from_date, date_interval_create_from_date_string('1 days'));
	    	}
    	}
    	
    /**
     * Year
     */
    } else {
			$from_month = '0';
    	$sql .= $where . ' sc.datetime > "' . $params['display_year'] . '-01-01 00:00:00' . '"';
      $where = ' AND ';

			if(date('Y') == $params['display_year']) {
				$until_month = date('m');
				$date = new DateTime();
    		$sql .= $where . ' sc.datetime < "' . $date->format('Y-m-d H:i:s') . '"';
			} else {
				$until_month = 12;
				$sql .= $where . ' sc.datetime < "'.$params['display_year'].'-12-31 23:59:59"';
			}
    	
      $where = ' AND ';
      
      foreach($head as $key => $value) {
	      for($i = ($from_month + 1); $i <= $until_month; $i++) {
	    		$return['data'][$key]['data'][$months[$i]] = 0;
	    	}
      }
    }
    
    
    
    if(is_numeric($params['display_status'])) {
    	$sql .= $where . ' sc.status_id = ' . $params['display_status'];
    	$where = ' AND ';
    }
    
    $query = Drunken_Database::query($sql);
    
    while($row = Drunken_Database::fetchObject($query)) {
    	
    	$return['count'] = mysqli_num_rows($query);
    	
	    /**
	     * Month
	     */
	    if(isset($params['display']) && $params['display'] == 'month' && isset($params['display_year']) && $params['display_year'] != ''
	    	&& isset($params['display_month']) && $params['display_month'] != '') {
	    	$d = substr($row->datetime, 8, 2);
	    	$m = substr($row->datetime, 5, 2);
	    	
	    	foreach($head as $key => $value) {
		    	if(isset($params['display_status']) && $params['display_status'] == 'all_individually') {
		    		if(!isset($return['data'][$row->status_id]['data'][$d.'.'.$m])) {
			    		$return['data'][$row->status_id]['data'][$d.'.'.$m] = 0;
			    	}
			    	
			    	$return['data'][$row->status_id]['data'][$d.'.'.$m]++;
		    	} else if(isset($params['display_status']) && $params['display_status'] == 'all_together') {
			    	if(isset($return['data'][$value]['data'][$d.'.'.$m])) {
			    		$return['data'][$value]['data'][$d.'.'.$m]++;
			    	}
		    	} else {
		    		if(isset($return['data'][$value]['data'][$d.'.'.$m])) {
			    		$return['data'][$value]['data'][$d.'.'.$m]++;
			    	}
		    	}
	      }
	    	
	    /**
	     * Period
	     */
	    } else if(isset($params['display']) && $params['display'] == 'period') {
	    	$d = substr($row->datetime, 8, 2);
	    	$m = substr($row->datetime, 5, 2);
	    	
	    foreach($head as $key => $value) {
		    	if(isset($params['display_status']) && $params['display_status'] == 'all_individually') {
		    		if(!isset($return['data'][$row->status_id]['data'][$d.'.'.$m])) {
			    		$return['data'][$row->status_id]['data'][$d.'.'.$m] = 0;
			    	}
			    	
			    	$return['data'][$row->status_id]['data'][$d.'.'.$m]++;
		    	} else if(isset($params['display_status']) && $params['display_status'] == 'all_together') {
			    	if(isset($return['data'][$value]['data'][$d.'.'.$m])) {
			    		$return['data'][$value]['data'][$d.'.'.$m]++;
			    	}
		    	} else {
		    		if(isset($return['data'][$value]['data'][$d.'.'.$m])) {
			    		$return['data'][$value]['data'][$d.'.'.$m]++;
			    	}
		    	}
	      }
	    	
	    /**
	     * Year
	     */
	    } else {
		    $m = number_format(substr($row->datetime, 5, 2));
	    	
		    foreach($head as $key => $value) {
		    	if(isset($params['display_status']) && $params['display_status'] == 'all_individually') {
		    		if(!isset($return['data'][$row->status_id]['data'][$months[$m]])) {
			    		$return['data'][$row->status_id]['data'][$months[$m]] = 0;
			    	}
			    	
			    	$return['data'][$row->status_id]['data'][$months[$m]]++;
		    	} else if(isset($params['display_status']) && $params['display_status'] == 'all_together') {
			    	if(isset($return['data'][$value]['data'][$months[$m]])) {
			    		$return['data'][$value]['data'][$months[$m]]++;
			    	}
		    	} else {
		    		if(isset($return['data'][$value]['data'][$months[$m]])) {
			    		$return['data'][$value]['data'][$months[$m]]++;
			    	}
		    	}
	      }
	    }
    }
      
    return $return;
  }
    
  public static function statusBoa($sid) {
    $sql = 'SELECT * FROM status WHERE user_roles_id = 6 && id = "'.$sid.'"';
    $query = Drunken_Database::query($sql);
    if(mysqli_num_rows($query) > 0) {
      return true;
    }
  }
  
  public static function statusContractService($sid) {
    $sql = 'SELECT * FROM status WHERE user_roles_id = 5 && id = "'.$sid.'"';
    $query = Drunken_Database::query($sql);
    if(mysqli_num_rows($query) > 0) {
      return true;
    }
  }
    
  public static function statusTelephony($sid) {
    $sql = 'SELECT * FROM status WHERE user_roles_id = 4 && id = "'.$sid.'"';
    $query = Drunken_Database::query($sql);
    if(mysqli_num_rows($query) > 0) {
      return true;
    }
  }
    
  public static function statusQM($sid) {
    $sql = 'SELECT * FROM status WHERE user_roles_id = 3 && id = "'.$sid.'"';
    $query = Drunken_Database::query($sql);
    if(mysqli_num_rows($query) > 0) {
      return true;
    }
  }
  
  public static function getStatusBoaAndRa($aid = '') {
  	
  	$status = Array();
  	
  	$sql = 'SELECT * FROM status WHERE user_roles_id = "6" AND visible = true';
  	$query = Drunken_Database::query($sql);
  	
  	$status['BAW'] = Array();
  	$status['Rechtsanwalt'] = Array();
  	
  	while($stat = Drunken_Database::fetchObject($query)) {
  		
  		if($aid != '') {
      	$stat->active = true;
      		
      	$before = (array) json_decode($stat->before_filter);
      	$last = (array) json_decode($stat->last_filter);
	      	
      	if(count($before) > 0) {
      		foreach($before as $key => $sid) {
      			if(!Drunken_StatusCourse::checkCourseOfId($aid, $sid)) {
      				$stat->active = false;
      				break;
      			}
      		}
      	}
	      	
      	if($stat->active != false) {
	      	if(count($last) > 0) {
	      		foreach($last as $key => $sid) {
	      			if(!Drunken_StatusCourse::checkLastStatus($aid, $sid)) {
	      				$stat->active = false;
	      				break;
	      			}
	      		}
	      	}
      	}
      }
  		
  		$status['BAW'][] = $stat;
  	}
  	
  	
  	$sql = 'SELECT * FROM status WHERE user_roles_id = "9" AND visible = true';
  	$query = Drunken_Database::query($sql);
  	
  	while($stat = Drunken_Database::fetchObject($query)) {
  		
  		if($aid != '') {
      	$stat->active = true;
      		
      	$before = (array) json_decode($stat->before_filter);
      	$last = (array) json_decode($stat->last_filter);
	      	
      	if(count($before) > 0) {
      		foreach($before as $key => $sid) {
      			if(!Drunken_StatusCourse::checkCourseOfId($aid, $sid)) {
      				$stat->active = false;
      				break;
      			}
      		}
      	}
	      	
      	if($stat->active != false) {
	      	if(count($last) > 0) {
	      		foreach($last as $key => $sid) {
	      			if(!Drunken_StatusCourse::checkLastStatus($aid, $sid)) {
	      				$stat->active = false;
	      				break;
	      			}
	      		}
	      	}
      	}
      }
  		
  		$status['Rechtsanwalt'][] = $stat;
  	}
  	
  	return $status;
  }
  
  public static function getStatuses() {
  	$sql = 'SELECT * FROM status';
  	$query = Drunken_Database::query($sql);
  	
  	$status = array();
  	
  	while($row = Drunken_Database::fetchObject($query)) {
  		$status[] = $row;
  	}
  	
  	return $status;
  }
  
  public static function getStatusByListSlug($list) {
  	$sql = 'SELECT * FROM lists WHERE slug = "'.$list.'" LIMIT 1';
  	$query = Drunken_Database::query($sql);
  	$list = Drunken_Database::fetchObject($query);
  	$status = implode('","', (array) json_decode($list->status));
  	
  	$sql = 'SELECT * FROM status WHERE id IN ("'.$status.'") ORDER BY name asc';
  	$query = Drunken_Database::query($sql);
  	
  	$status = array();
  	
  	while($s = Drunken_Database::fetchObject($query)) {
  		$status[] = $s;
  	}
  	
  	return $status;
  }
}

?>