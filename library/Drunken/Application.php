<?php

class Drunken_Application
{
	
	/**
	 * 
	 * Application -> Site-Controller
	 * @var object
	 */
	public $application;
	
	/**
	 * 
	 * BootstrapObject -> Bootstrap->Method
	 * @var object
	 */
	protected $bootstrap;
	
	/**
	 * TODO
	 * Enter description here ...
	 * @var unknown_type
	 */
	public $user;
	
	/**
	 * 
	 * @desc Application config-data
	 * @var array
	 */
	public $config;
	
	/**
	 * 
	 * @desc Application params
	 * @var object Drunken_Params
	 */
	public $params;
	
	/**
	 * 
	 * www.drunken.de/controller/action/Key/Value/key/value
	 */
	public function __construct()
	{
		$this->bootstrap()->run();
		$this->db = new Drunken_Database();
		$this->user = new Drunken_User();
		$this->user = $this->user->getUser();
		$this->params = new Drunken_Parameter();
		self::loadController();
	}
	
	/**
	 * @desc 	TODO
	 */
	public function loadController()
	{
		#	Configs
		$this->config = Drunken_Config_Ini::getConfig();
		
		#	Error-Reporting
		if($this->config->phpSettings->display_errors == '1') {
			error_reporting(-1);
			ini_set("display_errors", 1);
		} else {
			error_reporting(0);
			ini_set("display_errors", 0);
		}
		
		$sites = $this->config->sites;
		$resources = $this->config->resources;
		
		#	Paths
		$cpath = $resources->controller->path;
		$vpath = $resources->view->path;
		
		/* * Controller * */
		isset($this->params->controller) ? $application = $this->params->controller : $application = 'index';
	 	
		$config = Drunken_Config_Ini::getConfig();
		
		$application = ucfirst($application);
		
		if(file_exists($cpath .  '/' . $application . 'Controller.php')) {
			if($this->config->options->login == true) {
			  /**
			   * API
			   */
				if(isset($this->params->controller) && strtolower($this->params->controller) == 'api') {
					require_once $cpath .  '/' . $application . 'Controller.php';
					
					$class = new Drunken_Api();
					if(method_exists($class, $this->params->action)) {
              $return = $class->{$this->params->action}($this->params->vars);
			        echo $return;
					} else {
					    echo 'API-FAIL';
					}
				} else if(!Drunken_User::checkLogin() && $this->config->sites->login != $application) {
					header('Location: ' . $config->domain . $config->sites->login);
				} else {
					require_once $cpath .  '/' . $application . 'Controller.php';
				}
			}
		} else if(file_exists($cpath .  '/' . ucfirst($application) . 'Controller.php')) {
			if($this->config->options->login == true) {
				if(!Drunken_User::checkLogin() && $this->config->sites->login != $application) {
					$config = Drunken_Config_Ini::getConfig();
					header('Location: ' . $config->domain . $config->sites->login);
				} else {
					require_once $cpath .  '/' . ucfirst($application) . 'Controller.php'; }
				}
			}
		else if($this->user->checkLogin() == false) {
			header('Location: ' . $this->config->domain . 'Login'); }
		else {
			header('Location: ' . $this->config->domain . 'Error'); }
		
		$class = $application . 'Controller';
		
		/* * Controller Methods * */
		
		$this->application = new $class;
		
		$methods = get_class_methods($this->application);
		$methods = Drunken_Slug::getSlug($methods);
		
		if(in_array('init', $methods)) { $this->application->init($this); }
		
		$action = $this->params->action;
		
		if(in_array(strtolower($this->params->action), $methods))
		{
			$this->application->$action($this);
		}
		else if(in_array('indexaction', $methods))
		{
			$this->application->indexaction($this);
		}
		else if(count($methods) > 0)
		{
			$this->application->$methods['0']($this);
		}
		else
		{
			header('Location: ' . $config->domain . '/Error');
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $resource
	 */
	public function bootstrap($resource = null) {
    $this->getBootstrap()->bootstrap($resource);
    return $this;
  }
    
  /**
   * TODO
   * Enter description here ...
   */
	public function getBootstrap() {
    if (null === $this->bootstrap)
    {
        $this->bootstrap = new Drunken_Bootstrapper($this);
    }
    return $this->bootstrap;
  }
    
    /**
     * TODO
     * Enter description here ...
     */
	public function run() {
    $this->getBootstrap()->run();
  }
    
  public function __destruct() {
  }
}

?>