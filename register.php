<?php 
require_once 'core/init.php';


if (Input::exists()) {

	if(Token::check(Input::get('token'))){



		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'usuarios'
			),
			'password' => array(
				'required' => true,
				'min' => 6
			),
			'password_again' => array(
				'required' => true,
				'matches' => 'password'

			),
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50

			),

		));
		if ($validation->passed()) {
			$user = new User();

			$salt = Hash::salt(32);


			try{

				$user->create(array(
					'username' => Input::get('username'),
					'contrasena' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'nombre' => Input::get('name'),
					'joined' => date('Y-m-d H:i:s'),
					'grupo' => 1
				));

				Session::flash('home', 'Usuario registrado ahora puede logearse en el sitema!');	
				Redirect::to('index.php');	

			}catch(Exception $e){
				die($e->getMessage());
			}
		}else{
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}	
}

 ?>



<form action="" method="POST">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php  echo escape(Input::get('username')); ?>" autocomplete="off">
	</div>
	<div class="field">
		<label for="password">Escoja una contrasena</label>
		<input type="password" name="password" id="password">
	</div>
	<div class="field">
		<label for="password">Ingrese su contrasena otra vez</label>
		<input type="password" name="password_again" id="password_again">
	</div>
	<div class="field">
		<label for="name">Nombre</label>
		<input type="text" name="name" id="name" value="<?php  echo escape(Input::get('name')); ?>">
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Registrar">
	
</form>