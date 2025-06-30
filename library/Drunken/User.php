<?php

/**
 *
 * @desc User-Class
 * @author Manuel Kramm
 * @version 1.0
 * @license Manuel Kramm
 */

class Drunken_User
{
	public $id;
	public $first_name;
	public $last_name;
	public $username;
	public $slug;
	public $password;
	public $repassword;
	public $zip_code;
	public $city;
	public $address;
	public $email;
	public $phone;
	public $mobile;
	public $roles;
	public $sid;
	public $active;
	private $options;
	public $return = array('data' => '', 'error_msg' => array(), 'success_msg' => array(), 'success' => false);

	private static $cookie_name = 'sof';
	private static $cookie_expire = 604800; // 7 Days

	public function __construct() {
		$config = Drunken_Config_Ini::getConfig();
		if(!isset($_SESSION)) {
			session_start();
		}
	}

	/**
	 *
	 * @desc Set an Drunken_User property
	 * @param mixed $property
	 */
	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}

	/**
	 *
	 * @desc Get an Drunken_User property
	 * @param mixed $property
	 */
	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}
	}

	/**
	 *
	 * @desc Register User with User-Object
	 * @var
	 */
	public function addUser() {
		 
		$this->username != '' && !Drunken_User::checkUser($this->username) ? '' : $this->return['error_msg'][] = 'Username wurde nicht angegeben oder existiert schon';
		$this->password != '' && $this->repassword != '' && $this->password == $this->repassword ? '' : $this->return['error_msg'][] = 'Passwörter stimmen nicht überein.';
		$this->email!= '' && Drunken_Functions::validateEmail($this->email) && Drunken_User::checkMail($this->email) ? '' : $this->return['error_msg'][] = 'Email ist nicht korrekt oder existiert schon.';
		 
		if(isset($this->return['error_msg']) && count($this->return['error_msg']) > 0) {
			return $this->return;
		}
		 
		$sql = 'INSERT INTO user (first_name,
													  	last_name,
													  	username,
													  	slug,
													  	password,
													  	zip_code,
													  	city,
													  	address,
													  	email,
													  	phone,
													  	mobile,
													  	roles,
													  	register_date,
													  	active) VALUES ("'.$this->first_name.'",
													  									"'.$this->last_name.'",
													  									"'.$this->username.'",
													  									"'.Drunken_Slug::getSlug("'.$this->username.'").'",
												  				  					"'.md5($this->password).'",
												  				  					"'.$this->zip_code.'",
												  				  					"'.$this->city.'",
												  				  					"'.$this->address.'",
												  				  					"'.$this->email.'",
												  				  					"'.$this->phone.'",
												  				  					"'.$this->mobile.'",
												  				  					"{}",
												  				  					"'.date('Y-m-d H:i:s').'",
												  				  					"1")';
		 
		if(Drunken_Database::query($sql)) {

			$email = new Drunken_PhpMailer();
			$email->From      = 'noreply@crm-standortfabrik.de';
			$email->FromName  = 'Standortfabrik';
			$email->Subject   = 'Login-Daten';

			$email->AddAddress($this->email);

			$body = '
        <style>
        	body { font-size:14px; font-family:Arial, Verdana, Georgia; }
        </style>
      ';



			$body .= '<body>';
			$body .= '<span style="font-size:16px; font-weight:bold;">Hallo ' . $this->first_name . ' ' . $this->last_name . '!</span>';
			$body .= '<br><br>';
			$body .= 'Eine Konto mit folgenden Login-Daten wurde für Sie angelegt:';
			$body .= '<br><br>';
			$body .= '<table>';
			$body .= '  <tr>';
			$body .= '    <td style="font-family: Arial, Verdana, Georgia; font-size:18px; font-weight:bold; color:#fff; padding:25px 50px; background-color:#999;">';
			$body .= '      ' . $this->username . '<br>';
			$body .= '      ' . $this->password;
			$body .= '    </td>';
			$body .= '  </tr>';
			$body .= '</table>';
			$body .= '<br><br>';
			$body .= 'Bitte verraten Sie niemandem Ihr Password und löschen Sie diese E-mail umgehend<br>';
			$body .= 'damit keine andere Person Ihr Passwort einsehen und benutzen kann.';
			$body .= '<br><br>';
			$body .= 'Mit freundlichen Grüßen,<br>';
			$body .= 'Ihr Standortfabrik-Team';
			$body .= '</body>';

			$email->CharSet = 'UTF-8';

			$email->msgHTML($body);

			if($email->send()) {
				$this->return['success_msg'][] = 'Eine E-Mail wurde an folgende Adresse gesendet: ' . $this->email;
			} else {
				$this->return['error_msg'][] = 'Leider konnte keine E-Mail gesendet werden.';
			}

			$this->return['success_msg'][] = 'Der Benutzer wurde erfolgreich angelegt.';
			$this->return['success'] = true;
			return $this->return;
		} else{
			$this->return['error_msg'][] = 'leider ist ein Datenbankproblem aufgetreten, bitte wenden Sie sich an den Support.';
			$view->error['success'] = false;
			return $this->return;
		}
	}

	/**
	 *
	 * @desc Login - User
	 * @param string $username
	 * @param string $password
	 * @return boolean
	 */
	public function loginUser($email_username, $password, $cookie = true)
	{
		$date = new DateTime();
		$now = $date->format('Y-m-d H:i:s');
		 
		session_regenerate_id();

		$contact_person = Drunken_Database::query('UPDATE partner_contact_person SET last_login = "'.$now.'", sid = "'.session_id().'" WHERE (email = "'.$email_username.'" || username = "'.$email_username.'") AND password = "'.md5($password).'" AND active = "1"');

		if(mysqli_affected_rows(Drunken_Database::getConnection()) > 0) {
			$_SESSION['email_username'] = md5($email_username);
			$_SESSION['password'] = md5($password);
			$_SESSION['sid'] = session_id();
			$_SESSION['type'] = 'partner';
				
			if($cookie) {
				setcookie(self::$cookie_name, json_encode(Array('username' => md5($email_username), 'password' => md5($password), 'type' => 'partner')) , time() + self::$cookie_expire);
			}
			return true;
		}
	}

	/**
	 *
	 * @desc Logs an user out and destroy the cookie
	 */
	public function logoutUser() {
		setcookie(self::$cookie_name, "", time()-3600);
		unset($_COOKIE[self::$cookie_name]);
		session_regenerate_id();
		session_destroy();

		!isset($_SESSION) ? session_start() : "";
		session_destroy();
	}

	/**
	 *
	 * Enter description here ...
	 */
	public function setUser() {
		 
		$sql = 'SELECT * FROM user WHERE id = "'.$this->id.'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		$u = Drunken_Database::fetchObject($query);
		
		$new_pass = $this->password;
		
		trim($this->username) == '' ? $this->return['error_msg'][] = 'Bitte geben Sie einen usernamen an.' : '';
		//	  Drunken_User::usernameExist($this->username) ? $this->return['error_msg'][] = 'Dieser Username existiert schon.' : '';
		 
		trim($this->email) == '' ? $this->return['error_msg'][] = 'Bitte geben Sie eine E-Mail Adresse an.' : '';
		//	  Drunken_User::emailExist($this->email) ? $this->return['error_msg'][] = 'Diese E-Mail Adresse existiert schon.' : '';
		!Drunken_Functions::validateEmail($this->email) ? $this->return['error_msg'][] = 'Bitte geben Sie eine gültige E-Mail Adresse an.' : '';
		 
		trim($this->password) == '' ? $this->password = $u->password : $this->password = md5($this->password);
		 
		if(isset($this->return['error_msg']) && count($this->return['error_msg']) > 0) {
			$this->return['success'] = false;
			return $this->return;
		}
		 
		if(mysqli_num_rows($query) > 0) {
			 
			/**
			 * E-Mail needed?
			 */
			if($u->username != $this->username || $u->email != $this->email || ($u->password != $this->password && trim($this->password) != '')) {
				 
				$email = new Drunken_PhpMailer();
				$email->From      = 'noreply@crm-standortfabrik.de';
				$email->FromName  = 'Standortfabrik';
				$email->Subject   = 'Login-Daten geändert';

				$email->AddAddress($u->email);

				$body = '
          <style>
          	body { font-size:14px; font-family:Arial, Verdana, Georgia; }
          </style>
        ';



				$body .= '<body>';
				$body .= '<span style="font-size:16px; font-weight:bold;">Hallo ' . $u->first_name . ' ' . $u->last_name . '!</span>';
				$body .= '<br><br>';

				if($u->username != $this->username) {
					$body .= 'Ihr Username wurde geändert:';

					$body .= '<br><br>';
					$body .= '<table>';
					$body .= '  <tr>';
					$body .= '    <td style="font-family: Arial, Verdana, Georgia; font-size:18px; font-weight:bold; color:#fff; padding:25px 50px; background-color:#999;">';
					$body .= '      ' . $this->username;
					$body .= '    </td>';
					$body .= '  </tr>';
					$body .= '</table>';
					$body .= '<br><br>';
				}

				if($u->email != $this->email) {
					$body .= 'Ihre E-Mail Adresse wurde geändert:';

					$body .= '<br><br>';
					$body .= '<table>';
					$body .= '  <tr>';
					$body .= '    <td style="font-family: Arial, Verdana, Georgia; font-size:18px; font-weight:bold; color:#fff; padding:25px 50px; background-color:#999;">';
					$body .= '      ' . $this->email;
					$body .= '    </td>';
					$body .= '  </tr>';
					$body .= '</table>';
					$body .= '<br><br>';
				}

				if($u->password != $this->password && trim($this->password) != '') {
					$body .= 'Ihre Passwort wurde geändert:';

					$body .= '<br><br>';
					$body .= '<table>';
					$body .= '  <tr>';
					$body .= '    <td style="font-family: Arial, Verdana, Georgia; font-size:18px; font-weight:bold; color:#fff; padding:25px 50px; background-color:#999;">';
					$body .= '      ' . $new_pass;
					$body .= '    </td>';
					$body .= '  </tr>';
					$body .= '</table>';
					$body .= '<br><br>';
				}

				$body .= 'Bitte verraten Sie niemandem Ihre Login-Daten und löschen Sie diese E-mail umgehend<br>';
				$body .= 'damit keine andere Person Ihre Login-Daten einsehen und benutzen kann.';
				$body .= '<br><br>';
				$body .= 'Mit freundlichen Grüßen,<br>';
				$body .= 'Ihr Standortfabrik-Team';
				$body .= '</body>';

				$email->CharSet = 'UTF-8';

				$email->msgHTML($body);

				if($email->send()) {
					$this->return['success_msg'][] = 'E-Mail wurde erfolgreich gesendet.';
				} else {
					$this->return['error_msg'][] = 'E-Mail konnte nicht gesendet werden.';
				}
			}
		}
		 
		$sql = 'UPDATE user SET first_name = "'.$this->first_name.'",
	  												last_name = "'.$this->last_name.'",
	  												username = "'.$this->username.'",
	  												password = "'.$this->password.'",
	  												zip_code = "'.$this->zip_code.'",
	  												city = "'.$this->city.'",
	  												address = "'.$this->address.'",
	  												email = "'.$this->email.'",
	  												phone = "'.$this->phone.'",
	  												mobile = "'.$this->mobile.'",
	  												roles = "'.mysqli_escape_string(Drunken_Database::getConnection(), $this->roles).'" WHERE id = '.$this->id.'';
		 
		if(Drunken_Database::query($sql)) {
			$this->return['success_msg'][] = 'Daten wurden erfolgreich geändert.';
			$this->return['success'] = true;
			return $this->return;
		} else {
			$this->return['error_msg'][] = 'Daten konnten nicht geändert werden.';
			$this->return['success'] = false;
			return $this->return;
		}
	}

	/**
	 *
	 * @desc Check if User with given id exists
	 * @param integer $id
	 * @return boolean
	 */
	public static function userIdExist($id) {
		if(mysqli_num_rows(Drunken_Database::query('SELECT id FROM user WHERE id = "'.$id .'"')) > 0) {
			return true;
		} else { return false; }
	}

	/**
	 *
	 * @desc Check if user with given email exists
	 * @param string $email
	 * @return boolean
	 */
	public static function userEmailExist($email) {
		if(mysqli_affected_rows(Drunken_Database::getConnection(), Drunken_Database::query('SELECT * FROM user WHERE email = "'.$email.'" LIMIT 1')) > '0') {
			return true;
		} else { return false; }
	}

	/**
	 *
	 * @desc Check if Logged in
	 * Check role
	 *
	 * 1 = Admin
	 * 2 = User
	 *
	 * @param string $role
	 * @return boolean
	 */
	public static function checkLogin() {

		if(!isset($_SESSION)) { session_start(); }

		$date = new DateTime();
		$now = $date->format('Y-m-d H:i:s');

		#	Check Session
		if(isset($_SESSION['email_username']) && isset($_SESSION['password'])) {
			/**
			 * Check User Login
			 */
			$sql = 'SELECT * FROM user WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1"';
			$result = Drunken_Database::query($sql);
				
			if(mysqli_num_rows($result) > 0) {
					
				/**
				 * Set last activity
				 */
				Drunken_Database::query('UPDATE user SET last_activity = "'.$now.'" WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1"');
					
				/**
				 * Set log
				 */
				if(mysqli_num_rows($result) > 0) {

					$user = Drunken_Database::fetchObject($result);

					$log = new Drunken_User_Log();
					$log->__set('user_id', $user->id);
					$log->__set('datetime', $now);
					$log->addLog();
				}

				return true;
			}
				
				
			/**
			 * Check Partner Login
			 */
			$sql = 'SELECT * FROM partner_contact_person WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1"';
			$result = Drunken_Database::query($sql);
				
			if(mysqli_num_rows($result) > 0) {
					
				/**
				 * Set last activity
				 */
				Drunken_Database::query('UPDATE partner_contact_person SET last_activity = "'.$now.'" WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1"');
					
				/**
				 * Set log
				 */
				if(mysqli_num_rows($result) > 0) {

					$user = Drunken_Database::fetchObject($result);

					$log = new Drunken_Partner_Log();
					$log->__set('partner_contact_person_id', $user->id);
					$log->__set('datetime', $now);
					$log->addLog();
				}
					
				return true;
			}
				
			/**
			 * Check Lawyer Login
			 */
			$sql = 'SELECT * FROM lawyer_contact_person WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1"';
			$result = Drunken_Database::query($sql);
				
			if(mysqli_num_rows($result) > 0) {
					
				/**
				 * Set last activity
				 */
				Drunken_Database::query('UPDATE lawyer_contact_person SET last_activity = "'.$now.'" WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1"');

				/**
				 * Set log
				 */
				if(mysqli_num_rows($result) > 0) {

					$user = Drunken_Database::fetchObject($result);

					$log = new Drunken_Lawyer_Log();
					$log->__set('lawyer_contact_person_id', $user->id);
					$log->__set('datetime', $now);
					$log->addLog();
				}
					
				return true;
			}
		}

		#	Check Cookie
		if(isset($_COOKIE[self::$cookie_name])) {
				
			$c = json_decode($_COOKIE[self::$cookie_name]);
				
			$sql = 'SELECT * FROM user WHERE (md5(email) = "'.$c->username.'" || md5(username) = "'.$c->username.'") AND password = "'.$c->password.'" AND active = "1"';
				
			$result = Drunken_Database::query($sql);
				
			if(mysqli_num_rows($result) > 0) {

				/**
				 * Renew Session
				 */
				$sql = 'UPDATE user SET sid = "'.session_id().'" WHERE (md5(email) = "'.$c->username.'" || md5(username) = "'.$c->username.'") AND password = "'.$c->password.'" AND active = "1"';
				$query = Drunken_Database::query($sql);

				$_SESSION['email_username'] = $c->username;
				$_SESSION['password'] = $c->password;
				return true;
			}
		}
	}

	/**
	 *
	 * @desc Authenticate User
	 * @param string $authcode
	 * @return boolean
	 */
	public static function activateUser($authcode)
	{
		$sql = 'UPDATE user SET active = "1" WHERE authcode = "'.$authcode.'"';
		$query = Drunken_Database::query($sql);

		if(mysqli_affected_rows() > 0)
		{
			return true;
		}
	}

	/**
	 *
	 * @desc Check if Username or Email Exists
	 * @param string $email_username
	 * @return boolean
	 */
	public static function checkUser($email_username) {
		$query = Drunken_Database::query('SELECT * FROM user WHERE username = "'.$email_username.'" OR email = "'.$email_username.'"');
		if(mysqli_num_rows($query) > '0') { return true; }
	}

	/**
	 *
	 * @desc Check if E-mail exists
	 * @param string $email
	 * @return boolean
	 */
	public static function checkMail($email)
	{
		$query = Drunken_Database::query('SELECT * FROM user WHERE email = "'.$email.'"');
		if(mysqli_num_rows($query) <= 0)
		{
			return true;
		}
	}

	/**
	 *
	 * @desc Check if Userrole exist
	 * @param integer $role
	 * @return boolean
	 */
	public static function checkUserRole($role)
	{
		$query = Drunken_Database::query('SELECT * FROM user_roles WHERE id = "'.$role.'"');
		if(mysqli_num_rows($query) >= 0)
		{
			return true;
		}
	}

	/**
	 *
	 * Get an Array With User-Object
	 */
	public static function getUsers() {
		$query = Drunken_Database::query('SELECT * FROM user ORDER BY last_name');
		if(mysqli_num_rows($query) > '0') {
			$users = array();
			while($user = Drunken_Database::fetchObject($query)) {
				$user->options = Drunken_User_Options::getOptions($user->id);
				$users[] = $user;
			}
			return $users;
		}
	}

	/**
	 *
	 * @desc Get current user object
	 * @return object $user
	 */
	public function getUser()
	{
		if(isset($_SESSION['email_username']) && isset($_SESSION['password'])) {
			$sql = 'SELECT * FROM user WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1" LIMIT 1';
			$query = Drunken_Database::query($sql);
				
			if(mysqli_num_rows($query) == '1') {
				$user = Drunken_Database::fetchObject($query);
			}
		}

		if(!isset($user) && isset($_COOKIE[self::$cookie_name])) {
			$c = json_decode($_COOKIE[self::$cookie_name]);
				
			$sql = 'SELECT * FROM user WHERE (md5(email) = "'.$c->username.'" || md5(username) = "'.$c->username.'") AND password = "'.$c->password.'" AND active = "1"';
			$query = Drunken_Database::query($sql);
				
			if(mysqli_num_rows($query) > 0) {
				!isset($_SESSION['email_username']) ? $_SESSION['email_username'] = $c->username : "";
				!isset($_SESSION['password']) ? $_SESSION['password'] = $c->password : "";
				$user = Drunken_Database::fetchObject($query);
			}
		}

		if(isset($user)){
			$this->__set('id', $user->id);
			$this->username = $user->username;
			$this->first_name = $user->first_name;
			$this->last_name = $user->last_name;
			$this->slug = $user->slug;
			$this->password = $user->password;
			$this->email = $user->email;
			$this->sid = $user->sid;
			$this->register_date =  $user->register_date;
			$this->active =  $user->active;
			$this->options = Drunken_User_Options::getOptions($user->id);
		}

		return $this;
	}


	public static function getUserIdByEmail($email) {
		$sql = 'SELECT * FROM user WHERE email = "'.$email.'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		if(mysqli_num_rows($query) > '0') {
			return Drunken_Database::fetchObject($query)->id;
		}
	}

	/**
	 *
	 * @desc Get full user object by id
	 * @param integer $uid
	 * @return object Drunken_User
	 */
	public static function getUserById($uid) {
		$sql = 'SELECT * FROM user WHERE id = "'.$uid.'" LIMIT 1';
		$query = Drunken_Database::query($sql);

		if(mysqli_num_rows($query) > 0) {
			$user = Drunken_Database::fetchObject($query);
			$user->options = Drunken_User_Options::getOptions($user->id);
			return $user;
		}
	}

	public static function changePassword($email, $oldpass, $newpass, $newrepass) {

	}

	public static function getUserId() {
		if(!isset($_SESSION)) { session_start(); }
		
	#	Check Session
		if(isset($_SESSION['email_username']) && isset($_SESSION['password'])) {
			if(isset($_SESSION['type']) && $_SESSION['type'] == 'user') {
				$sql = 'SELECT * FROM user WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1" LIMIT 1';
				$query = Drunken_Database::query($sql);
					
				if(mysqli_num_rows($query) > 0) {
					$tmp = Drunken_Database::fetchObject($query);
					return $tmp->id;
				}
			} else if(isset($_SESSION['type']) && $_SESSION['type'] == 'partner') {
				$sql = 'SELECT * FROM partner_contact_person WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1" LIMIT 1';
				$query = Drunken_Database::query($sql);
					
				if(mysqli_num_rows($query) > 0) {
					$tmp = Drunken_Database::fetchObject($query);
					
					return $tmp->partner_id;
				}
			} else if(isset($_SESSION['type']) && $_SESSION['type'] == 'lawyer') {
				$sql = 'SELECT * FROM lawyer_contact_person WHERE (md5(email) = "'.$_SESSION['email_username'].'" || md5(username) = "'.$_SESSION['email_username'].'") AND password = "'.$_SESSION['password'].'" AND sid = "'.session_id().'" AND active = "1" LIMIT 1';
				$query = Drunken_Database::query($sql);
					
				if(mysqli_num_rows($query) > 0) {
					$tmp = Drunken_Database::fetchObject($query);
					return $tmp->lawyer_id;
				}
			}
		}
	}

	public static function getUserRoleIds() {
		$user = self::getUserById(self::getUserId());
		if($user) {
			$user->roles = json_decode($user->roles);
			$user->roles = get_object_vars($user->roles);
			return $user->roles;
		}
	}

	public static function getUsersByRoleId($ids) {
		 
		$sql = 'SELECT * FROM user ORDER BY last_name';
		$query = Drunken_Database::query($sql);
		 
		$users = array();
		 
		while($user = Drunken_Database::fetchObject($query)) {

			$roles = get_object_vars(json_decode($user->roles));

			if(!is_array($ids)) {
				$ids = array($ids);
			}

			$i = 0;

			foreach($ids as $key => $value) {
				if(in_array($value, $roles)) {
					$users[] = $user;
					break;
				}
				$i++;
			}
		}

		return $users;
	}

	public static function getUserByEmailUsername($email_username) {
		$sql = 'SELECT * FROM user WHERE username = "'.$email_username.'" || email = "'.$email_username.'"';
		$query = Drunken_Database::query($sql);
		return Drunken_Database::fetchObject($query);
	}

	public static function resetPassword($email_username) {
		 
		$pass = Drunken_Functions::randomPassword('8');
		if(Drunken_Database::query('UPDATE partner_contact_person set password = "'.md5($pass).'" WHERE username = "'.$email_username.'" || email = "'.$email_username.'"')) {
			$email = new Drunken_PhpMailer();
			$email->From      = 'noreply@crm-standortfabrik.de';
			$email->FromName  = 'Standortfabrik';
			$email->Subject   = 'Password-Recovery';

			$user = self::getUserByEmailUsername($email_username);

			$email->AddAddress($user->email);

			$body = '
        <style>
        	body { font-size:14px; font-family:Arial, Verdana, Georgia; }
        </style>
      ';



			$body .= '<body>';
			$body .= '<span style="font-size:16px; font-weight:bold;">Hallo ' . $user->first_name . ' ' . $user->last_name . '!</span>';
			$body .= '<br><br>';
			$body .= 'Ihr neues Passwort lautet wie folgt:';
			$body .= '<br><br>';
			$body .= '<table>';
			$body .= '  <tr>';
			$body .= '    <td style="font-family: Arial, Verdana, Georgia; font-size:18px; font-weight:bold; color:#fff; padding:25px 50px; background-color:#999;">';
			$body .= '      ' . $pass;
			$body .= '    </td>';
			$body .= '  </tr>';
			$body .= '</table>';
			$body .= '<br><br>';
			$body .= 'Bitte verraten Sie niemandem Ihr Password und löschen Sie diese E-mail umgehend<br>';
			$body .= 'damit keine andere Person Ihr Passwort einsehen und benutzen kann.';
			$body .= '<br><br>';
			$body .= 'Mit freundlichen Grüßen,<br>';
			$body .= 'Ihr Standortfabrik-Team';
			$body .= '</body>';

			$email->CharSet = 'UTF-8';

			$email->msgHTML($body);

			if($email->send()) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function setUserActive($uid, $active) {
		$sql = 'UPDATE user SET active = ' . $active . ' WHERE id = ' . $uid;
		if(Drunken_Database::query($sql)) {
			 
			$user = Drunken_User::getUserById($uid);

			$mailer = new Drunken_Mailer();
			$mailer->subject = 'Reaktivierung Deines Accounts';
			$mailer->from_name = 'Standortfabrik';
			$mailer->addresses = array($user->email);
			$mailer->message = 'Hallo '.$user->first_name.' '.$user->last_name.', <br /><br />';
			$mailer->message .= 'Dein Account wurde reaktiviert.<br>';

			if($mailer->sendMail()) {

			}
			 
			return true;
		} else {
			return false;
		}
	}

	public static function setUserInactive($uid, $active) {
		$sql = 'UPDATE user SET active = ' . $active . ' WHERE id = ' . $uid;
		 
		if(Drunken_Database::query($sql)) {

			$user = Drunken_User::getUserById($uid);

			$mailer = new Drunken_Mailer();
			$mailer->subject = 'Deaktivierung Deines Accounts';
			$mailer->from_name = 'Standortfabrik';
			$mailer->addresses = array($user->email);
			$mailer->message = 'Hallo '.$user->first_name.' '.$user->last_name.', <br /><br />';
			$mailer->message .= 'Dein Account wurde bis auf weiteres deaktiviert.<br>';

			if($mailer->sendMail()) {

			}

			return true;
		} else {
			return false;
		}
	}

	public static function userOnline() {
		$sql = 'SELECT * FROM user WHERE last_activity > ((now() - INTERVAL 1 MINUTE))';
		$query = Drunken_Database::query($sql);
		 
		$users = Array();
		 
		while($user = Drunken_Database::fetchObject($query)) {
			$users[$user->id] = $user;
		}
		 
		return $users;
	}

	public static function usernameExist($username) {
		$sql = 'SELECT * FROM user where username = "'.$username.'"';
		$query = Drunken_Database::query($sql);
		if(mysqli_num_rows($query) > 0) {
			return true;
		}
	}
	
	public static function getCurrentUser() {
		$sql = 'SELECT * FROM user WHERE id = "'.self::getUserId().'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		
		if(mysqli_num_rows($query)) {
			
			$user = Drunken_Database::fetchObject($query);
			$user->roles = (array) json_decode($user->roles);
			
			return $user;
		}
	}
}








