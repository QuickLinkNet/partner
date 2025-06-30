<?php

/**
 * 
 * Database-Class
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 */
class Drunken_Database
{
	
	/**
	 * 
	 * @desc Connection variable
	 * @var string $connetction
	 */
	private static $connection = NULL;
	
	/**
	 * 
	 * @desc Query Result String
	 * @var string $result
	 */
	private static $result = NULL;
	
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	private static $host = NULL;
	
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	private static $user = NULL;
	
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	private static $pass = NULL;
	
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	private static $schema = NULL;
	
	/**
	 * 
	 * @desc Constructor - Set database config
	 */
	public function __construct($main = true)
	{
		$conf = Drunken_Config_Ini::getConfig(APPLICATION_ENV)->database->resource;
		
		self::$host = $conf->host;
		self::$user = $conf->user;
		self::$pass = $conf->pass;
		self::$schema = $conf->schema;
		
		$this->setConnection();
	}
	
	/**
	 * 
	 * @desc Database - set Connection if not exists
	 */
	public static function setConnection()
	{
		if(!self::$connection) {
				self::$connection = mysqli_connect(self::$host, self::$user, self::$pass) or die('Datenbankfehler 1');
				mysqli_select_db(self::$connection, self::$schema) or die('Datenbankfehler 2');
		}
	}
	
	public static function getConnection() {
	    if(self::$connection) {
	        return self::$connection;
	    }
	}
	
	/**
	 * 
	 * @desc Check if table Exists
	 * @param string $table
	 * @return boolean
	 */
	public static function checkTable($table)
	{
		if(mysqli_num_rows(self::query("SHOW TABLES LIKE '".$table."'"))==1)
		{ 
    		return true;
		}
	}
	
	/**
	 * 
	 * @desc Create Database
	 * @param string $table
	 * @param string $fields
	 */
	public static function createTable($table, $fields, $first_query = NULL)
	{
		if(self::checkTable($table) == false)
		{
			$sql = 'CREATE TABLE ' . $table . '( ' . ' ' . $fields . ' ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;';
			mysqli_query($sql);
			
			if(isset($first_query) && $first_query != '')
			{
				self::query($first_query);
			}
		}
	}
	
	/**
	 * 
	 * @desc Close MySql-Connection
	 */
	public static function disconnect()
	{
		if (is_resource(self::$connection))
		{
			mysqli_close(self::$connection);
		}
	}
	
	/**
	 * 
	 * @desc Query-Method
	 * @param string $sql
	 * @return query query
	 */
	public static function query($sql) {
	  
	  mysqli_query(self::$connection, "SET SQL_BIG_SELECTS=1");
	  
	  if(!self::$connection) {
	      self::$connection = self::setConnection();
	  }
		mysqli_query(self::$connection, "SET NAMES 'utf8'");
		$result = mysqli_query(self::$connection, $sql) or die(mysqli_error(self::$connection));
		return $result;
	}
	
	public static function myquery($sql) {
		mysqli_query("SET NAMES 'utf8'");		
	    $result = mysqli_query($sql, self::$connection) or die(mysqli_error(self::$connection));
		return $result;
	}
	
	
	/**
	 * 
	 * @desc Fetch Object from Query-Result
	 * @param query $query
	 * @return object object
	 */
	public static function fetchObject($query) {
		if ($query === false) return NULL;
		return mysqli_fetch_object($query);
	}
	
	/**
	 * 
	 * @desc Fetch Object from Query-Result
	 * @param query $query
	 * @return object object
	 */
	public static function fetchArray($query) {
		return mysqli_fetch_array($query);
	}
	
	/**
	 * 
	 * @desc TODO
	 * @param string $table
	 */
	public static function getAutoIncrement($table) {
		$sql = 'SELECT auto_increment FROM information_schema.tables WHERE table_name = "'.$table.'" AND table_schema = "'.self::$schema.'"';
		$query = self::query($sql);
		return self::fetchArray($query);
	}
	
	/**
	 * 
	 * Converting to mysql-friendly strings and inserting data into a db-table
	 * @param string $table
	 * @param array $data: for all columns define a numerical array (1 => "value"; for special columns define a associative array ("column" => "value")
	 * @param boolean $convert[true]: optional parameter to deactivate the mysql string escaping and the utf8-decoding; default its on
	 * @return boolean || int: successful sql query returns the affected count of rows, otherwise it returns "false"
	 */
	public static function insert($table, $data, $convert = true)  {
		$sql = '';
		
		foreach($data as $column => $value)  {
			if(is_numeric($column)) {
				$fields = '';
			} else  {
				$fields = array();
				$fields[] = $column;
				if(!is_numeric($value) && is_string($value) && $value != '' && $value != NULL && $convert == true)  {
					$values[] = mysqli_escape_string(utf8_decode($value));
				} else {
					$values[] = $value;
				}
			}
			
			$fields = is_array($fields) ? '('.implode(', ', $fields).')' : $fields;
			$sql = 'INSERT INTO '.$table.' '.$fields.' VALUES('. implode(', ', $values).')';
			
			if(self::query($sql))  {
				return mysqli_affected_rows();
			} else  {
				return false;
			}
		
		}
	}
}

?>