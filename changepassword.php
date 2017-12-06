<?php
require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' =>true,
				'min' => 6
			),
			'password_new' => array(
				'required' => true,
				'min' => 6
			),
			'password_new_again' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'password_new'
			)
		));

		if ($validation->passed()) {
			
			if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->contrasena) {
							echo 'contrasena incorrecta.';
						}else{
							$salt = Hash::salt(32);
							$user->update(array(
								'contrasena'=> Hash::make(Input::get('password_new'), $salt),
								'salt' => $salt
							));

							Session::flash('home', 'Su contrasena ha sido cambiada!');
							Redirect::to('index.php');

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
		<label for="password_current">Contrasena antigua</label>
		<input type="password" name="password_current" id="password_current">
	</div>
	<div class="field">
		<label for="password_new">Nueva contrasena</label>
		<input type="password" name="password_new" id="password_new">
	</div>
	<div class="field">
		<label for="password_new_again">Repita nueva contrasena</label>
		<input type="password" name="password_new_again" id="password_new_again">
	</div>

	<input type="submit" value="Change">
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

</form>