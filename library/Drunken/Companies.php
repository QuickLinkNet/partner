<?php

/**
 * @desc Companies
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class Drunken_Companies
{
    public static function getCompanies() {
        $sql = 'SELECT * FROM companies';
        $query = Drunken_Database::query($sql);
        
        $companies = array();
        
        while($company = Drunken_Database::fetchObject($query)) {
            array_push($companies, $company);
        }
        
        return $companies;
    }
    
    public static function translateCompanyId($id) {
      $sql = 'SELECT * FROM companies WHERE id = "'.$id.'"';
      $query = Drunken_Database::query($sql);
      
      $res = Drunken_Database::fetchObject($query);
      
      return $res->name;
    }
}
?>