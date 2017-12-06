<?php
require_once 'core/init.php';

if (Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}


$user = new User(); 
if ($user->isLoggedIn()) {
?>
<p>Hola <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>

<ul>
	<li><a href="logout.php">Log out</a></li>
	<li><a href="update.php">Actualizar nombre</a></li>
	<li><a href="changepassword.php">Actualizar contrasena</a></li>
</ul>
<?php

	if ($user->hasPermission('admin')) {
		echo '<p>Ud es un Administrador!</p>';
	}

}else{
	echo '<p>Debe estar <a href="login.php">Logeado</a> o <a href="register.php">Registrarse</a></p>';
}
