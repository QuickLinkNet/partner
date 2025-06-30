<?php

class Drunken_Bootstrapper
{
	/**
	 * TODO
	 * Enter description here ...
	 * @var unknown_type
	 */
	private $bootstrap_class = '';
	
	/**
	 * TODO
	 * Enter description here ...
	 * @var unknown_type
	 */
	private $bootstrap_methods = array();
	
	/**
	 * TODO
	 * Enter description here ...
	 */
	public function bootstrap()
	{
		require_once Drunken_Config_Ini::getConfig()->bootstrap->path;
		
		$classes = get_declared_classes();
		$this->bootstrap_class = end($classes);
		
		$methods = get_class_methods($this->bootstrap_class);
		
		foreach($methods as $method)
		{
			array_push($this->bootstrap_methods, $method);
		}
	}
	
	/**
	 * TODO
	 * Enter description here ...
	 */
	public function run()
	{
		$bootstrap = new $this->bootstrap_class;
		
		foreach($this->bootstrap_methods as $method)
		{
			$bootstrap->$method();
		}
	}
}

?>