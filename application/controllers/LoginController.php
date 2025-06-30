<?php

/**
 * 
 * Enter description here ...
 * @author Manuel Kramm
 *
 */
class LoginController {
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $application
	 */
    public function init($application) {
    	if(isset($_POST['get_password_email'])) {
    		$sql = 'SELECT * FROM user WHERE email = "'.$_POST['get_password_email'].'"';
    		$query = Drunken_Database::query($sql);
    		if(mysql_num_rows($query) > '0') {

    			$user = Drunken_Database::fetchObject($query);
        		$hash = base64_encode($user->password);
        		
        		$mailer = new Drunken_Mailer();
        		$mailer->subject = 'Your new generated password';
        		$mailer->from_name = 'JimBuy';
        		$mailer->addresses = array($user->email);
        		$mailer->message = 'Hello '.$user->username.', <br /><br />';
        		$mailer->message .= 'please follow the below link to reset your password.';
        		$mailer->message .= 'Link-URL: '. $application->config->domain . '/Login/forgotPassword/uid/'.$user->id.'/hash/'.$hash;
        		$mailer->message .= '<br /><br /><br />Sincerely yours<br />JimBuy';
        		
        		if($mailer->sendMail()) {
        			echo '<b>Success:</b> There was an e-mail sending to your address.';
        		} else {
        			echo '<b>Error:</b> Please contact the administrator.';
        		}
    		} else {
    			echo '<b>Error:</b> Email can not be found.';
    		}
    	}

    	if(isset($_POST['set_password']) && $_POST['set_password'] != '') {
    		$return = array();
    		if(isset($_POST['uid']) && $_POST['uid'] != '') {
    			if(Drunken_User::userIdExist($_POST['uid'])) {
    				$sql = 'UPDATE user SET password = "'.md5($_POST['set_password']).'" WHERE id = "'.$_POST['uid'].'"';
    				if(Drunken_Database::query($sql)) {
    					$return['boolean'] = true;
    					$return['msg'] =  '<b>Success:</b> Your password has been changed.';
    				} else {
    					$return['boolean'] = false;
    					$return['msg'] =  '<b>Error:</b> Your password cannot be changed. Please contact support.';
    				}
    			} else {
    				$return['boolean'] = false;
    				echo '<b>Error:</b> User cannot be found.';
    			}
    		} else {
    			$return['boolean'] = false;
    			$return['msg'] =  '<b>Error:</b> Password cannot be changed. Please contact support.';
    		}
    		echo json_encode($return);
    		die();
    	}
    }

    /**
     * 
     * Enter description here ...
     * @param object $application
     */
    public function indexAction($application) {
    	
      Drunken_Header::setJs(Array('/js/login/index.js'));

      $view = new Drunken_View();
      $view->config = $application->config;
      $view_path = $view->config->resources->view->path;
      
	    $view->login_error = '';
	    $view->recovery_error = '';
	    
	    if(isset($_POST['recovery_send'])) {
	      $view->login = 'none';
	      $view->recovery = 'block';
	    } else {
	      $view->login = 'block';
	      $view->recovery = 'none';
	    }

//    	if(isset($application->user) && $application->user->checkLogin()) { header('Location: ' . Drunken_Config_Ini::getConfig()->sites->index); }
		
    	$view->email_username = isset($_POST['email_username']) ? $_POST['email_username'] : "";
    	$view->pass = isset($_POST['pass']) ? $_POST['pass'] : "";
		  $cookie = isset($_POST['cookie']) ? true : false;
		  
	    if(isset($_POST['login_send'])) {
	    	if(isset($_POST['email_username']) && $_POST['email_username'] != '') {
	    		if(isset($_POST['pass']) && $_POST['pass'] != '') {
	    			if(Drunken_Validator::validateEmailAdress($_POST['email_username']) || Drunken_User::checkUser($_POST['email_username']) || Drunken_Partner_ContactPerson::checkContactPerson($_POST['email_username'])) {
  						if($application->user->loginUser($_POST['email_username'], $_POST['pass'], $cookie)) {
  							header('Location: ' . $view->config->sites->index);
  						} else {
  							$view->login_error = '<b>Error:</b> Falsche E-Mail Adresse oder Passwort.';
  						}
	    			} else {
	    				$view->login_error = '<b>Error:</b> Bitte tragen Sie ein korrekte E-Mail Adresse oder einen Usernamen ein.';
	    			}
	    		} else {
	    			$view->login_error = '<b>Error:</b> No password given.';
	    		}
	    	} else {
	    		$view->login_error = '<b>Error:</b> Bitte tragen Sie eine E-Mail Adresse oder einen Usernamen ein.';
	    	}
		  } else if(isset($_POST['recovery_send'])) {
		    if(Drunken_User::checkUser($_POST['email_username'])) {
		      if(Drunken_User::resetPassword($_POST['email_username'])) {
		        $view->recovery_error = 'Dein Password wurde zurückgesetzt. Bitte überprüfe deine Emails.';
		      } else {
		        $view->recovery_error = 'Leider ist ein Fehler aufgetreten, bitte kontaktiere den Support.';
		      }
		    } else if(Drunken_Partner_ContactPerson::checkContactPerson($_POST['email_username'])) {
		      echo '2';
		    } else if(Drunken_Lawyer_ContactPerson::checkContactPerson($_POST['email_username'])) {
		      echo '3';
		    } else {
		      $view->recovery_error = 'Diese E-Mail Adresse oder Username ist leider nicht verfügbar.';
		    }
		  }
		//	Get new Viewer Set the File-Path

			$view->setContent($view_path . $application->params->controller . '/index.phtml');
			$view->setHtmlHead(Drunken_Header::getHeader());
			$view->render();
    }

    /**
     * 
     * Funtion to regenerate the password and send this to a valid user-mail-address
     * @param object $application
     */
    public function forgotPassword($application) {
    	$view = new Drunken_View();
        $view->config = $application->config;
        $vars = $application->params->vars;
        $view_path = $view->config->resources->view->path;
        
        $view->alert = array();
        Drunken_StringGen::$length = '15';
        Drunken_StringGen::$special_signs = '';
       	$domain = $view->config->domain;
       	$view->form_reset_pw = false;
       	$view->uid = $vars['uid'];
      
        /*
         * If open the link in the sending email
         */
       	if(isset($vars['uid']) && $vars['uid'] != '' && Drunken_User::userIdExist($vars['uid'])
       	&& mysql_num_rows(Drunken_Database::query('SELECT * FROM user WHERE id = "'.$vars['uid'].'" AND password = "'.base64_decode($vars['hash']).'"')) > '0') {
       		$view->auth = true;
       	} else  {
       		$view->auth = false;
       	}

		$view->setContent($view_path . $application->params->controller . '/pw_forget.phtml');
        $view->setHtmlHead(Drunken_Header::getHeader());
        $view->render();
    }
}

?>