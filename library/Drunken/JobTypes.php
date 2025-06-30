<?php

/**
 * @desc Aquisitions
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class Drunken_JobTypes
{
    public static function getJobTypes() {
        $sql = 'SELECT * FROM job_types';
        $query = Drunken_Database::query($sql);
        
        $job_types = array();
    
    	  while($job_type = Drunken_Database::fetchObject($query)) {
    	      $job_types[$job_type->id] = $job_type->name;
    	  }
    	  
    	  return $job_types;
    }
    
    public static function translateJobTypeId($jtid) {
        $sql = 'SELECT * FROM job_types WHERE id = "'.$jtid.'"';
        $query = Drunken_Database::query($sql);
        $res = Drunken_Database::fetchObject($query);
        return  $res->name;
    }
}
?>