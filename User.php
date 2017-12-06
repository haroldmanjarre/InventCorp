<?php
class User{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;

	public function __construct($user = null){
		$this->_db = DB::getInstance();

		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');

		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				}else{
					// hacer logout
				}
			}
		}else{
			$this->find($user);
		}

	}

	public function update($fields = array(), $id = null){

		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if ($this->_db->update('usuarios', $id, $fields)) {
			throw new Exception('Hubo un problema a la hora de actualizar.');
			
		}
	}

	public function create($fields = array()){
		if (!$this->_db->insert('usuarios', $fields)) {
			throw new Exception("Hubo un problema creando la cuenta.");
			
		}
	}

	public function find($user = null){
		if ($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('usuarios', array($field, '=', $user));

			if ($data->count()) {
				$this->_data = $data->first();

				return true;
			}
		}
		return false;
	}

	public function login($username = null, $password = null, $remember = false){

		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		}else{
		
			$user = $this->find($username);

			if ($user) {
				if ($this->data()->contrasena === Hash::make($password, $this->data()->salt)) {
					Session::put($this->_sessionName, $this->data()->id);

					if ($remember) {//esto solo se ejecuta si usuario ecoge ser recordado, se guardara en la bd con esto le damos la habilidad al usuario de mantenerse logeado
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

						if (!$hashCheck->count()) {//si es la primera vez que escoge ser recordado
							$this->_db->insert('users_session', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						}else{//si ya ha ecogido ser recordado
							$hash = $hashCheck->first()->hash;
						}

						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));


					}

					return true;
				}
			}
		}

		return false;
	}

	public function hasPermission($key){//mirar que tipo de permisos tiene admin o ninguno
		$group = $this->_db->get('groups', array('id', '=', $this->data()->grupo));

		if ($group->count()) {
			$permissions = json_decode($group->first()->permissions, true);//se introduce un json objeto investigar mas..
			
			if ($permissions[$key] == true) {
							return true;
			}			

		}	
		return false;	

	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}

	public function logout(){

		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}


	public function data(){
		return $this->_data;
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}
}