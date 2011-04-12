<?php
/**
 * If your login and password fields are not called username and password remember to change the field
 * names here AND change the auth component config (see the book) so that it correctly hashes the password
 */
?>
<?php echo $this->set('title_for_layout', __('Recuperar contraseña 3/3', true)); ?>
<div class="container form">
<?php
echo $form->create();
$inputs = array(
	'legend' => __('Por favor, introduce tu nueva contraseña', true),
	'token' => array('type' => 'hidden'),
	'email' => array('type' => 'hidden'),
);

// Uncomment if Auth uses the username field
//$inputs['username'] = array('type' => 'hidden', 'value' => 'x');
if ($fields['confirmation']) {
	$inputs[] = $fields['confirmation'];
}
$inputs = am($inputs, array(
	'password',
	'confirm' => array('type' => 'password'),
	'generate' => array(
		'type' => 'checkbox',
		'label' => __('Generar una contraseña aleatoria (se mostrará en la siguiente pantalla)', true)
	),
));
echo $form->inputs($inputs);
echo $form->end(__('Enviar', true));
?></div>
