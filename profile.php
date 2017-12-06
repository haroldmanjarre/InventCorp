<?php
require_once 'core/init.php';
//este codigo es para crear perfiles de usuario hay que mejorarlo su uso es opcional
if (!$username = Input::get('user')) {
	Redirect::to('index.php');
}else{
	$user = new User($username);
	if (!$user->exists()) {
		Redirect::to(404);
	}else{
		$data = $user->data();//el metodo data esta en User.php
	}
	?>

	<h3><?php echo escape($data->username);  ?></h3>
	<p>Nombre completo: <?php echo escape($data->nombre) ?></p>

	<?php
}