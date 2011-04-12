<div class="form-container">
<?php
echo $form->create();
echo $form->inputs(array(
	'legend' => 'Edit your profile',
	'id',
	'email' => array('div' => 'wide input text'),
	'first_name' => array('div' => 'wide input text'),
	'last_name' => array('div' => 'wide input text'),
));
echo $form->end(__('Enviar', true));

$menu->settings(__('Opciones', true));
$menu->add(array(
	array('title' => __('Cambia tu contraseña', true), 'url' => array('action' => 'change_password')),
));
?></div>
