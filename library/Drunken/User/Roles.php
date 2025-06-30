<?php

class Drunken_User_Roles
{
	/**
	 * 
	 * @desc User-Role id
	 * @var integer
	 */
	public $id;
	
	/**
	 * 
	 * @desc User-Role name
	 * @var string varchar(255)
	 */
	public $name;
	
	/**
	 * 
	 * @desc User-Role slug
	 * @var string varchar(255)
	 */
	public $slug;
	
	/**
	 * 
	 * @desc User-Role description
	 * @var string text
	 */
	public $description;
	
	/**
	 * 
	 * @desc Role error array
	 * @var array
	 */
	public $error = array();
	
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
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function setRole() {
		if(isset($this->name) && $this->name) {
			$sql = 'SELECT * FROM user_roles WHERE name = '.$this->name.' || slug = "'.Drunken_Slug::getSlug($this->name).'"';
			$query = Drunken_Database::query($sql);
			if(mysqli_affected_rows() <= '0') {
				$sql = 'INSERT INTO user_roles (name,
												slug,
												description)
													VALUES ("'.$this->name.'",
															"'.Drunken_Slug::getSlug($this->name).'",
															"'.$this->description.'")';
				$query = Drunken_Database::query($sql);
				if(mysqli_affected_rows() > '0') {
					$this->error['success'] = true;
					$this->error['msg'][] = 'Roles successfully created.';
					return true;
				} else {
					$this->error['msg'][] = 'Role could´t be saved. Please contact support.';
				}
			} else {
				$this->error['msg'][] = 'This role already exists.';
			}
		} else {
			$this->error['msg'][] = 'Please enter a role name.';
		}
	}
	
	/**
	 * 
	 * @desc Update User-Role
	 */
	public function updateRole() {
		if(isset($this->id) && self::roleExist($this->id)) {
			$sql = 'UPDATE user_roles SET 	name = "'.$this->name.'",
											slug = "'.Drunken_Slug::getSlug($this->name).'",
											description = "'.$this->description.'"
											WHERE id = "'.$this->id.'"';
			$query = Drunken_Database::query($sql);
			if(mysqli_affected_rows() > '0') {
				$this->error['success'] = true;
				$this->error['msg'][] = 'User-Role successfully updated.';
			} else {
				$this->error['msg'][] = 'User-Role can´t be updated. Please contact support';
			}
		} else {
			$this->error['msg'][] = 'Role with given id does not exist.';
		}
	}
	
	/**
	 * 
	 * @desc Delete User-Role
	 * @param integer uid
	 */
	public function deleteRole($uid) {
		if(self::roleExist($uid)) {
			$sql = 'DELETE FROM user_roles WHERE id = "'.$uid.'"';
			$query = Drunken_Database::query($sql);
			if(mysqli_affected_rows() > '0') {
				$this->error['msg'][] = 'User-Role successfully deleted.';
			} else {
				$this->error['msg'][] = 'User-Role could´t be deleted. Please contact support.';
			}
		} else {
			$this->error['msg'][] = 'Role with given id does not exist.';
		}
	}
	
	/**
	 * 
	 * @desc Check if role exists
	 * @param mixed $uid
	 * @return boolean
	 */
	public static function roleExist($search) {
		$sql = 'SELECT * FROM user_roles WHERE id = "'.$search.'" OR name = "'.$search.'"';
		$query = Drunken_Database::query($sql);
		if(mysqli_affected_rows() > '0') {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * @desc Get all existing user roles
	 * @return array $roles
	 */
	public static function getUserRoles() {
		$sql = 'SELECT * FROM user_roles';
		$query = Drunken_Database::query($sql);
		$roles = array();
		while($role = Drunken_Database::fetchObject($query)) {
			$roles[] = $role;
		}
		return $roles;
	}
	
	/**
	 * 
	 * @desc Get all user roles from db
	 * @return array $roles
	 */
	public static function getRoles($rid = '') {
		$sql = 'SELECT * FROM user_roles';
		
		if(isset($rid) && $rid != '' && is_numeric($rid)) {
			$sql .= ' WHERE id = ' . $rid;
		}
		
		$query = Drunken_Database::query($sql);
		$roles = array();
		while($role = Drunken_Database::fetchObject($query)) {
			$roles[] = $role;
		}
		return $roles;
	}
	
	/**
	 * 
	 * @desc Get all user roles with user counter
	 * @return array $roles
	 * 
	 * $roles['integer'] -> [id] = integer
	 *                      [role] = string
	 *                      [slug] = string
	 *                      [description] = text
	 *                      ([user_counter] = integer)
	 */
	public static function getUsedUserRoles($rid = '') {
		$roles = self::getRoles($rid);
		$users = Drunken_User::getUsers();
		
		foreach($users as $user) {
			if(isset($rid) && $rid != '') {
				if($rid == $user->user_roles_id) {
					foreach($roles as $key => $role) {
						if($role->id == $rid) {
							if(!isset($roles[$key]->user_count)) {
								$roles[$key]->user_count = '0';
							}
							$roles[$key]->user_count = $roles[$key]->user_count + '1';
						}
					}
				}
			} else {
				foreach($roles as $key => $role) {
					if($role->id == $user->user_roles_id) {
						if(!isset($roles[$key]->user_count)) {
							$roles[$key]->user_count = '0';
						}
						$roles[$key]->user_count = $roles[$key]->user_count + '1';
					}
				}
			}
		}
		return $roles;
	}
	
	/**
	 * 
	 * @desc Get a role name by given role id
	 * @param integer $id
	 */
	public static function getRoleNameById($id) {
		$sql = 'SELECT * FROM user_roles WHERE id = "'.$id.'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		if(mysqli_num_rows($query) > '0') {
			return Drunken_Database::fetchObject($query)->name;
		}
	}
	
	/**
	 * 
	 * @desc Get a role by given name
	 * @param string $rname#
	 * @return object Drunken_User_Roles
	 */
	public static function getRoleByName($rname) {
		$sql = 'SELECT * FROM user_roles WHERE name = "'.$rname.'" OR slug = "'.Drunken_Slug::getSlug($rname).'" LIMIT 1';
		$query = Drunken_Database::query($sql);
		if(mysqli_num_rows($query) > '0') {
			return Drunken_Database::fetchObject($query);
		}
	}
	
	public static function translateRoleId($rid) {
	  $sql = 'SELECT * FROM user_roles WHERE id = "'.$rid.'"';
	  $query = Drunken_Database::query($sql);
	  
	  return Drunken_Database::fetchObject($query);
	}
}

?>