<?php

/**
 * 
 * @desc Parse the URL to get controller and action and get Values of an key if exist
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 */

class Drunken_Parameter
{
	/**
	 * @desc TODO
	 * @var string
	 */
	public $controller;
	
	/**
	 * @desc TODO
	 * @var string
	 */
	public $action;
	
	/**
	 * @desc
	 * @var unknown_type
	 */
	public $vars = array();
	
	/**
	 * @DESC Filtering the GET-parameter; the first 2 parameter defines the controller and the action id and each other a key=>value combination
	 * 
	 */
	public function __construct()
	{
		$u = explode('/', $_SERVER['REQUEST_URI']);
		$u = Drunken_Functions::clean_array($u);
		
		if(isset($u['0'])) {
			$this->controller = ucfirst(Drunken_Slug::getSlug($u['0']));
		} else if(Drunken_User::checkLogin() == false) {
			$this->controller = 'login';
		} else {
			$this->controller = Drunken_Config_Ini::getConfig()->sites->index;
		}
		
		if(isset($u['1'])) {
			$this->action = ucfirst(Drunken_Slug::getSlug($u['1']));
		}

		for($i = 2; $i < count($u); $i++) {			
			if(isset($u[$i]) && isset($u[($i + 1)]))  {
				$this->vars[strtolower($u[$i])] = urldecode($u[($i + 1)]);
				$i++;
			} else  {
				$this->vars[strtolower($u[$i])] = '';
			}
		}
	}
	
	public function test() {
		echo 'test!!!';
	}
}

?>