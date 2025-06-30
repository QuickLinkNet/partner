<?php

class Drunken_Functions
{
	/**
	 * 
	 * @desc Receive an String, Array or Object and get it out, sorted
	 * @param mixed $var
	 */
	public static function getPre($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
	
	/**
	 * @desc generate a random password
	 * @param $length		number
	 */
  public static function randomPassword($length) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }
	
	/**
	 * 
	 * @desc Clean an array by removing empty cells and rewrite the index
	 * @param array $array
	 */
	public static function clean_array($a)
	{
		$b = array();
		
		foreach($a as $k => $v)
		{
			if($v != '')
			{
				$b[] = $v;
			}
		}
		return $b;
	}
	
	/**
	 * 
	 * Sorting an array by the array-key, which is defined in the second parameter
	 * @param Array $array
	 * @param String $key
	 */
	public static function sortArray ($array, $key) {
	    $sorter = array();
	    $return = array();
	    reset($array);
		
	    foreach ($array as $ii => $va)  {
	        $sorter[$ii]=$va[$key];
	    }
	    
	    arsort($sorter);
	    
	    foreach ($sorter as $ii => $va) {
	        $return[$ii]=$array[$ii];
	    }
	    
	    return $return;
	}
	
	/**
	 * 
	 * @desc Validate an email by Pattern
	 * @param string $email
	 * @return boolean
	 */
	public static function validateEmail($email) { 
		$email =  strtolower($email);
		$pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if (preg_match($pattern, $email)) {
			return true;
		}
	}
	
	/**
	 * 
	 * @desc 1. Search and Replace
	 * 2. Set www. at the front
	 * 3. Check with Pattern
	 * @param string $domain
	 * @return mixed; validation success -> return domain else return false
	 */
	public static function validateDomain($domain, $return = false) {
		$search = array('http://', 'https://', 'www.', '/'); 
		$replace = array('','','','');
		$domain = str_replace($search, $replace, $domain);
		$domain = "www.".$domain;
		
		$pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
		
		if(preg_match($pattern, $domain)) {
			if($return == false) {
				return true;
			} else {
				return $domain;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * @desc String to stars from $length to end
	 * @param string $string
	 * @param numeric $length
	 * @return string (with stars)
	 */
	public static function stringToStars($string, $length)
	{
		return substr($string, 0, $length) . str_repeat('*', (strlen($string) - $length));
	}
	
	/**
	 * 
	 * Format an English Date to German Date
	 * Or Format German Date to English Date
	 * @param string (DateTime) $date
	 * @param string $country
	 */
	public static function formatDate($date, $country = 'en')
	{
		$return = '';
		
		if($country == 'en')
		{
			if(strlen($date) < 11)
			{
				return substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' .  substr($date, 0, 2) . ' 00:00:00';
			}
		}
		else if($country == 'de')
		{
			if(strlen($date) > 16)
			{
				return substr($date, 8, 2) . '.' . substr($date, 5, 2) . '.' .  substr($date, 0, 4);
			}
		}
	}
	
	/**
	 * 
	 * @desc Create an RGB string from Hex-Code
	 * @param mixed $hex
	 * @return mixed $rgb
	 */
	public static function hex2rgb($hex)
	{
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }
	   
	   $rgb = 'rgba(' . $r . ', ' . $g . ', ' . $b . ', 0.5)';
	   return $rgb;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $total
	 * @param unknown_type $form
	 * @param unknown_type $rows
	 */
	public static function getPagination($total, $form, $rows)	{
		$pagination_pages = $total / $rows;
		
		isset($_POST['page']) ? $page = $_POST['page'] : $page = 1;
		
		$content = array();

		if($page != 1)		{
			$content[] = '							<span onclick="javascript:$(\'#page\').val(\''.($page - 1).'\'); $(\'#'.$form.'\').submit();"><</span>';
		}
		
		$pages = ceil($pagination_pages);
		$display = '3';
		$count = '0';
		
		for($i = '1'; $i <= $pages; $i++)		{
			if($i == $page)			{
				$content[] = '							<span style="text-decoration:underline;">'.$i.'</span>';
			} else if($i < $page && $i >= ($page - $display))	{
				if($i >= $page - ceil($display / 2) && $i < $page)
				{
					$content[] = '							<span onclick="javascript:$(\'#page\').val(\''.$i.'\');$(\'#'.$form.'\').submit();">'.$i.'</span>';
				}
				else
				{
					$content[] = '							<span>...</span>';
				}
			} else if($i > $page && $i <= ($page + $display)) {
				if($i > $page && $i <= $page + ceil($display / 2))
				{
					$content[] = '							<span onclick="javascript:$(\'#page\').val(\''.$i.'\');$(\'#'.$form.'\').submit();">'.$i.'</span>';
				} else	{
					$content[] = '							<span>...</span>';					
				}
			}
		}
		
		if($page < $pagination_pages) {
			$content[] = '							<span onclick="javascript:$(\'#page\').val(\''.($page + 1).'\');$(\'#'.$form.'\').submit();">></span>';
		}
		
		$content[] = '					<input type="hidden" name="page" id="page" value="1">';
		return $content;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $arr
	 */
	public static function array2JSON($arr)	{
	    if(function_exists('json_encode')) return json_encode($arr); //Latest versions of PHP already has this functionality.
	    $parts = array();
	    $is_list = false;
	
	    //Find out if the given array is a numerical array
	    $keys = array_keys($arr);
	    $max_length = count($arr)-1;
	    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
	        $is_list = true;
	        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
	            if($i != $keys[$i]) { //A key fails at position check.
	                $is_list = false; //It is an associative array.
	                break;
	            }
	        }
	    }
	
	    foreach($arr as $key=>$value) {
	        if(is_array($value)) { //Custom handling for arrays
	            if($is_list) $parts[] = array2json($value); /* :RECURSION: */
	            else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
	        } else {
	            $str = '';
	            if(!$is_list) $str = '"' . $key . '":';
	
	            //Custom handling for multiple data types
	            if(is_numeric($value)) $str .= $value; //Numbers
	            elseif($value === false) $str .= 'false'; //The booleans
	            elseif($value === true) $str .= 'true';
	            else $str .= '"' . addslashes($value) . '"'; //All other things
	            // :TODO: Is there any more datatype we should be in the lookout for? (Object?)
	
	            $parts[] = $str;
	        }
	    }
	    $json = implode(',',$parts);
	    
	    if($is_list) return '[' . $json . ']';//Return numerical JSON
	    return '{' . $json . '}';//Return associative JSON
	}
	
	 /**
	  * 
	  * Enter description here ...
	  * @param unknown_type $arr
	  */
	public static function getDropDown($arr){
		
		$select = '							<select class="fl"';
		
		if(isset($arr['name']) && $arr['name'] != '')
		{
			$select .= ' name="'.$arr['name'].'"';
		}
		if(isset($arr['id']) && $arr['id'])
		{
			$select .= ' id="'.$arr['id'].'"';
		}
		if(isset($arr['onchange']) && $arr['onchange'] != '')
		{
			$select .= 'onChange="'.$arr['onchange'].'"';
		}
		
		$select .= '>';
		
		$content[] = $select;
		
		if(isset($arr['first']) && $arr['first'] != '')
		{
			$content[] = '								<option value="">'.$arr['first'].'</option>';
		}
		
		if(is_array($arr['sql']))
		{
			foreach($arr['sql'] as $key => $value)
			{
				if(isset($_POST[$arr['name']]) && $_POST[$arr['name']] == $key)
				{
					$content[] = '									<option selected value="'.$key.'">'.$value.'</option>';
				}
				else
				{
					$content[] = '								<option value="'.$key.'">'.$value.'</option>';
				}
			}
		}
		else
		{
			$query = Drunken_Database::query($arr['sql']);
			while($result = Drunken_Database::fetchObject($query))
			{
				if(isset($_POST[$arr['name']]) && $_POST[$arr['name']] == $result->key)
				{
					$content[] = '									<option selected value="'.$result->key.'">'.$result->value.'</option>';
				}
				else
				{
					$content[] = '								<option value="'.$result->key.'">'.$result->value.'</option>';
				}
			}
		}
		
		$content[] = '							</select>';
		
		return $content;
	}
	
	/**
	 * 
	 * @desc return full url
	 */
	public static function getUrl() {
		$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
		return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'];
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $array
	 */
	public static function getArrayValuesAsString($array) {
		$arr_output = array();
		
		if(is_array($array)) {
			foreach($array as $key => $value) {
				$arr_output[$key] = (String)$value;
			}
			
			return $arr_output;
		}
	}
	
	
	/**
	 * 
	 * @desc Get final redirected url
	 * @param string $url
	 */
	public static function getRedirectUrl ($url) {
		
	    stream_context_set_default(array(
	        'http' => array(
	            'method' => 'HEAD'
	        )
	    ));
	    $headers = get_headers($url, 1);
	    
	    if ($headers !== false && isset($headers['Location'])) {
	        return array_pop($headers['Location']);
	    }
	    return false;
	}
  
	public static function calculateDateWithoutWeekend($date, $hours) {
	  
	  $until = date("Y-m-d H:i:s", strtotime($date . '+'.$hours.' hours'));
	  
	  $weekday = date('w', strtotime($until));
	  
  	if($weekday == 6) {
	    $until = date("Y-m-d H:i:s", strtotime($until . '+48 hours'));
	  } else if($weekday == 7) {
	    $until = date("Y-m-d H:i:s", strtotime($until . '+24 hours'));
	  }
	  
	  return $until;
	}



    /**
     * @desc get numerics from string
     * @param $str
     * @return array
     */
    public static function parseNumbers ($str) {
        preg_match_all('/\d+/', $str, $matches);
        return $matches[0];
    }

    /**
     * @desc Get numeric checksum array from array of objects by object attribute
     * @param $a
     * @return array
     */
    public static function getChecksumArrayFromArrayOfObjectsByObjectAttribute($aArray, $sAttribute) {

        $aReturn = array();

        foreach($aArray as $key => $value) {

            $aNumbers = self::parseNumbers($value[$sAttribute]);
            $iChecksum = 0;

            foreach($aNumbers as $i => $j) {
                $iChecksum = $iChecksum + $j;
            }
            array_push($aReturn, $iChecksum);
        }

        return $aReturn;
    }

    /**
     * @desc Sort found checksums array by usort of aArrayOfObjects
     * @param $arrayOfObjects
     * @param $array
     * @return array
     */
    public static function sortArrayByMultipleChecksums($aArrayOfObjects, $aArray) {
        $z = array();
        $aReturnArray = array();

        foreach($aArray as $i => $j) {
            array_push($z, $aArrayOfObjects[$j]);
        }

        /**
         * @desc Little sort helper
         * @param $a
         * @param $b
         * @return int
         */


        usort($z, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        foreach($z as $key => $value) {
            array_push($aReturnArray, array_search($value['name'], array_column($aArrayOfObjects, 'name')));
        }

        return $aReturnArray;
    }


    public static function obiSorting($aArrayOfObjects) {
        $aChecksums = self::getChecksumArrayFromArrayOfObjectsByObjectAttribute($aArrayOfObjects, 'name');

        $aSortedChecksum = array();

        if(is_array($aChecksums) && count($aChecksums) > 0) {
            for($i = 0; $i <= max($aChecksums); $i++) {

                $aFound = array(array_keys($aChecksums, $i))[0];

                /**
                 * Search found records
                 */
                if(count($aFound) > 1) {
                    $aFound = self::sortArrayByMultipleChecksums($aArrayOfObjects, $aFound);
                }

                if(count($aFound) > 0) {
                    foreach($aFound as $ii => $vv) {
                        array_push($aSortedChecksum, $aArrayOfObjects[$vv]);
                    }
                }
            }
        }

        return $aSortedChecksum;
    }
}




