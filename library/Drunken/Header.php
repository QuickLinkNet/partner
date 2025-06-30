<?php 

/**
 * @desc Create new header object with css, js and advanced js
 * @author Manuel Kramm
 * @version 1.0
 * @license Manuel Kramm
 */

class Drunken_Header
{
	/**
	 * 
	 * @desc Head-Array
	 * @var array $head
	 */
	public static $head = Array();
	
	/**
	 * 
	 * @desc Head-Title
	 * @var string $title
	 */
	public static $title = '';
	
	/**
	 * 
	 * @desc head-Js-Data
	 * @var string $js
	 */
	public static $js = '';
	
	/**
	 * 
	 * @desc Head-CSS-Data
	 * @var string $css
	 */
	public static $css = '';
	
	/**
	 * 
	 * @desc Set body seperate, for custom method -> Body
	 * @var string $body
	 */
	public static $body = '<body>';
	
	/**
	 * 
	 * @desc Set Head-Title
	 * @param string $title
	 */
	public static function setTitle($title)
	{
		self::$title = $title;
	}
	
	/**
	 * 
	 * @desc Set Head-CSS-Data by Array
	 * @param array $array
	 */
	public static function setCss($array)
	{
		if(count($array) > 0)
		{
			foreach($array as $css)
			{
				self::$css .= '<link rel="stylesheet" type="text/css" href="'.$css.'">' . "\n";
			}
		}
	}
	
	/**
	 * 
	 * @desc Set Head-JS-Data by Array
	 * @param array $array
	 */
	public static function setJs($array)
	{
		if(count($array) > 0)
		{
			foreach($array as $js)
			{
				self::$js .= '<script type="text/javascript" src="'.$js.'"></script>' . "\n";
			}
		}
	}
	
	/**
	 * 
	 * @desc Set Advanced-Head-JS-Data by String
	 * @param string $js
	 */
	public static function setAdvancedJs($js)
	{
		self::$js .= '<script type="text/javascript">' . $js . '</script>';
	}
	
	/**
	 * 
	 * @desc Set a Document Ready Statement
	 * @param unknown_type $js
	 */
	public static function setDocumentReady($js)
	{
		self::$js .= '<script type="text/javascript">$(document).ready(function (){ ' . $js . ' });</script>';
	}
	
	/**
	 * 
	 * @desc Set Custom-Body (onload.....)
	 * @param string $body
	 */
	public static function setCustomBody($body)
	{
		self::$body = $body;
	}
	
	/**
	 * 
	 * @desc Get Header out
	 */
	public static function getHeader()
	{
	  
		$return = array();
		
		$config = Drunken_Config_Ini::getConfig();
		
		self::$head[] .= '<!DOCTYPE html>';
		self::$head[] .= '<html>';
		self::$head[] .= '  <head>';
		self::$head[] .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
		self::$head[] .= '      <title>' . self::$title . '</title>';
		self::$head[] .= '      <link rel="stylesheet" type="text/css" href="'.$config->resources->css->path.'template.css">';
		self::$head[] .= '      <link rel="stylesheet" type="text/css" href="'.$config->resources->css->path.'icons.css">';
		self::$head[] .= '      <script type="text/javascript" src="'.$config->resources->js->path.'jquery_1.8.3.js"></script>';
		self::$head[] .= '      <script type="text/javascript" src="'.$config->resources->js->path.'functions.js"></script>';
		self::$head[] .= '      <script type="text/javascript" src="'.$config->resources->js->path.'ajaxRequest.js"></script>';
		self::$head[] .= '      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">';
//		self::$head[] .= '      <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAYQG3uf05dSLGW-IDZuPHmhSoUTvS18k6FdIkBWM2SbRQadOdGRTkXN2rJVO1CDElAdSdytPZUHIaBg" type="text/javascript"></script>';
		self::$css != '' ? self::$head[] .= '		' . self::$css : "";
		self::$js != '' ? self::$head[] .= '		' . self::$js : "";
		self::$head[] .= '  </head>';
		self::$head[] .= '  ' . self::$body;
		
		foreach(self::$head as $line) {
			$return[] = $line;
		}
		
		return $return;
	}
	
	/**
	 * 
	 * @desc Set Chart-Data-Holder to Head
	 * @param string $chart
	 * @param array $data
	 * @return string $chart
	 */
	public static function setChartDataHolder($chart, $data)
	{
		foreach($data as $key => $value)
		{
			$chart = str_replace($key, $value, $chart);
		}
		return($chart);
	}
}


?>