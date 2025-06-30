<?php

/**
 * 
 * @desc TODO
 * @author Manuel Kramm
 * @license Manuel Kramm
 * @copyright Manuel Kramm
 * @version 1.0
 */
class LogoutController
{
	
	/**
	 * 
	 * @desc TODO
	 * @param object $application
	 */
    public function init($application) {
      
    }
	
    /**
     * 
     * @desc TODO
     * @param object $application
     */
    public function indexAction($application) {
    	
    	//	Get new Viewer Set the File-Path
      $view = new Drunken_View();
      $view->config = $application->config;
      $view_path = $view->config->resources->view->path;
      
      $user = new Drunken_User();
      $user->logoutUser();
			header('Location: ' . $view->domain . $view->config->sites->login);
      
			//	Get new Viewer Set the File-Path
			$view->setHeader($view->config->components->path . 'header.php');
      $view->setNavigation($view->config->components->path . 'navigation.php');
		  $view->setContent($view_path . $application->params->controller . '/' . 'index.phtml');
      $view->setHtmlHead(Drunken_Header::getHeader());
      $view->render();
    }
}

?>