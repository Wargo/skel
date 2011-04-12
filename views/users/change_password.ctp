<?php
/**
 * If your login and password fields are not called username and password remember to change the field
 * names here AND change the auth component config (see the book) so that it correctly hashes the password
 */
?>
<div class="container form">
<?php
echo $form->create();
echo $form->inputs(array(
	'legend' => __('Cambia tu contraseña', true),
	'username' => array('type' => 'hidden'),
	'current_password' => array('type' => 'password'),
	'password',
	'confirm' => array('type' => 'password'),
	'generate' => array(
		'type' => 'checkbox',
		'label' => __('Genera una contraseña aleatoria (se mostrará en la siguiente pantalla)', true)
	),
));
echo $form->end(__('Enviar', true));
$menu->settings(__('Opciones', true));
$menu->add(array(
	array('title' => __('Edita tu perfil', true), 'url' => array('action' => 'edit')),
));
?></div>
