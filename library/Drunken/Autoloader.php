<?php

/**
 * @desc PHP Autoloader
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @version 1.5;
 */


class autoloader
{
	/**
     * @desc Class-Instance
     * @var object $instance
     */ 
	private static $instance;
    
    /**
     * @desc Exclude file Formats 
     * @var array $file_formats
     */ 
    public static $file_formats = array('.jpeg', '.jpg', '.png', '.html', '.php', '.js', '.css', '.', '..');
	
    /**
     * @desc Self-Constructor
     */ 
    private final function __construct() {}
    
    /**
     * @desc Get Self-Instance
     * @final
     */ 
    public static final function getInstance() {
        if(is_object(self::$instance) === false) {
            self::$instance = new autoloader();
        }
        return (self::$instance);
    }
    
    /**
     * @desc Scan Dirs and Autoload Classes
     * @final
     */ 
	public static function autoload($class_name) {
	    foreach(explode(PATH_SEPARATOR, get_include_path()) as $dir) {
	    	
	        $paths = explode('_', $class_name);
	        
	        $file = $dir;
	        
	        for($i = 0; $i < (count($paths) - 1); $i++) {
	        	$file .= $paths[$i] . '/';
	        }
	        
	        $file .= $paths[$i] . '.php';
	        
	        if(file_exists($file)) {
	        	require_once $file;
	        }
	    }
	}
}
?>