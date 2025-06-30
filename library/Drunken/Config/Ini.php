<?php

class Drunken_Config_Ini
{
	public static $configs;
	
	/**
	 * TODO
	 * Enter description here ...
	 * @param unknown_type $file
	 */
	public static function setConfig($file)
	{
		if(file_exists($file))
		{
			$array = parse_ini_file($file, true);
			$array = self::recursive_parse(self::parse_ini_advanced($array));
			self::$configs = json_decode(json_encode($array), FALSE);
		}
	}
	
	/**
	 * TODO
	 * Enter description here ...
	 * @param unknown_type $config
	 */
	public static function getConfig($env = APPLICATION_ENV)
	{
		return self::$configs->$env;
	}
	
	/**
	 * TODO	
	 * Enter description here ...
	 * @param unknown_type $array
	 */
	private static function parse_ini_advanced($array) {
	    $returnArray = array();
	    if (is_array($array))
	    {
	        foreach ($array as $key => $value)
	        {
	            $e = explode(':', $key);
	            if (!empty($e[1]))
	            {
	                $x = array();
	                foreach ($e as $tk => $tv)
	                {
	                    $x[$tk] = trim($tv);
	                }
	                $x = array_reverse($x, true);
	                foreach ($x as $k => $v)
	                {
	                    $c = $x[0];
	                    if (empty($returnArray[$c]))
	                    {
	                        $returnArray[$c] = array();
	                    }
	                    if (isset($returnArray[$x[1]]))
	                    {
	                        $returnArray[$c] = array_merge($returnArray[$c], $returnArray[$x[1]]);
	                    }
	                    if ($k === 0)
	                    {
	                        $returnArray[$c] = array_merge($returnArray[$c], $array[$key]);
	                    }
	                }
	            }
	            else
	            {
	                $returnArray[$key] = $array[$key];
	            }
	        }
	    }
	    return $returnArray;
	}
	
	/**
	 * TODO
	 * Enter description here ...
	 * @param unknown_type $array
	 */
	private static function recursive_parse($array)
	{
	    $returnArray = array();
	    if (is_array($array))
	    {
	        foreach ($array as $key => $value)
	        {
	            if (is_array($value))
	            {
	                $array[$key] = self::recursive_parse($value);
	            }
	            $x = explode('.', $key);
	            if (!empty($x[1]))
	            {
	                $x = array_reverse($x, true);
	                if (isset($returnArray[$key]))
	                {
	                    unset($returnArray[$key]);
	                }
	                if (!isset($returnArray[$x[0]]))
	                {
	                    $returnArray[$x[0]] = array();
	                }
	                $first = true;
	                foreach ($x as $k => $v)
	                {
	                    if ($first === true)
	                    {
	                        $b = $array[$key];
	                        $first = false;
	                    }
	                    $b = array($v => $b);
	                }
	                $returnArray[$x[0]] = array_merge_recursive($returnArray[$x[0]], $b[$x[0]]);
	            }
	            else
	            {
	                $returnArray[$key] = $array[$key];
	            }
	        }
	    }
	    return $returnArray;
	}
}

?>