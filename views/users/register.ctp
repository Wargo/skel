<?php
/**
 * If your login and password fields are not called username and password remember to change the field
 * names here AND change the auth component config (see the book) so that it correctly hashes the password
 */
?>
<div class="container form">
<?php
echo $this->Form->create();
echo $this->Form->inputs(array(
	'fieldset' => false,
	'username' => array(
		'label' => __('Nombre de usuario', true),
	),
	'first_name' => array(
		'label' => __('Nombre', true),
	),
	'last_name' => array(
		'label' => __('Apellidos', true),
	),
	'email' => array(
		'label' => __('Email', true),
	),
	'password' => array(
		'label' => __('Contraseña', true),
	),
	'confirm' => array(
		'label' => __('Confirma la contraseña', true),
	),
	'generate' => array(
		'type' => 'checkbox',
		'label' => __('Generar una contraseña aleatoria (se mostrará en la siguiente pantalla)', true),
	),
	'tos' => array(
		'type' => 'checkbox',
		'label' => sprintf(__('Estoy de acuerdo con los %1$s', true), $html->link(__('términos de uso', true), '/tos', array('class' => 'popup modal noResize noDrag'))),
	),
));
echo $form->submit(__('Regístrame', true));
echo $form->end();
?>
</div>
