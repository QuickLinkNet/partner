<?php

class Drunken_User_Login
{
	/**
	 * 
	 * @desc Username
	 * @var string varchar(255)
	 */
	public $email_username;
	
	/**
	 * 
	 * @desc password
	 * @var string varchar(255)
	 */
	public $password;
	
	/**
	 * 
	 * @desc Cookie
	 * @var boolean
	 */
	public $cookie;
	
	/**
	 * 
	 * @desc Return array
	 * @var array
	 */
	public $return = array('login' => false, 'msg' => array());
	
	/**
	 * 
	 * @desc Set an Drunken_UserRole property
	 * @param mixed $property
	 */
	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}
	
	/**
	 * 
	 * @desc Get an Drunken_UserRole property
	 * @param mixed $property
	 */
	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}
	}
	
	public function loginUser() {
	  
	  isset($this->email_username) && $this->email_username != '' ? '' : $this->return['msg'][] = 'Bitte geben Sie eine E-Mail Adresse oder Usernamen an.';
	  isset($this->password) && $this->password != '' ? '' : $this->return['msg'][] = 'Bitte geben Sie ein Passwort an.';
	  
	  if(count($this->return['msg']) <= 0) {
	    if(Drunken_Validator::validateEmailAdress($this->email_username) || Drunken_User::checkUser($this->email_username) || Drunken_Partner_ContactPerson::checkContactPerson($this->email_username) || Drunken_Lawyer_ContactPerson::checkContactPerson($this->email_username)) {
				if($application->user->loginUser($_POST['email_username'], $_POST['pass'], $cookie)) {
					header('Location: ' . $view->config->sites->index);
				} else {
					$this->error['msg'][] = '<b>Error:</b> Wrong e-mail or password.';
				}
			} else {
				$this->return['msg'][] = 'E-Mail Adresse ist nich korrekt oder username existiert nicht.';
			}
	  }
	  
	  return $this->return;
	  
	}
	
}

?>