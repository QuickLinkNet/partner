<?php
ini_set('memory_limit','512M');
ini_set('max_execution_time', 300);

/**
 * Load Autoloader
 */
require_once '../library/Drunken/Autoloader.php';
$autoloader = autoloader::getInstance();
spl_autoload_register(array('Autoloader', 'autoload'));

set_include_path('../library/' . PATH_SEPARATOR . get_include_path());
set_include_path('../library/mpdf60/' . PATH_SEPARATOR . get_include_path());

defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../public/'));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
defined('PUBLIC_CSS_PATH') || define('PUBLIC_CSS_PATH', realpath(dirname(__FILE__) . './css'));
defined('PUBLIC_IMAGE_PATH') || define('PUBLIC_IMAGE_PATH', realpath(dirname(__FILE__) . '/images'));

Drunken_Config_Ini::setConfig(APPLICATION_PATH . '/configs/application.ini');

$application = new Drunken_Application();

?>