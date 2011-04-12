<?php
extract ($data);
?>
	<h3><?php echo $User['username'] ?></h3>
	<dl>
		<dt>Username</dt>
		<dd><?php echo $User['username']; ?></dd>
		<dt>Name</dt>
		<dd><?php echo $User['first_name'] . ' ' . $User['last_name']; ?></dd>
		<dt>Email</dt>
		<dd><?php echo $User['email']; ?></dd>
	</dl>
<?php
if ($User['id'] !== $this->Session->read('Auth.User.id')) {
	return;
}
$menu->settings(__('Opciones', true));
$menu->add(array(
	array('title' => __('Edita tu perfil', true), 'url' => array('action' => 'edit')),
	array('title' => __('Cambia tu contraseña', true), 'url' => array('action' => 'change_password')),
));
