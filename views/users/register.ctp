<?php
/**
 * If your login and password fields are not called username and password remember to change the field
 * names here AND change the auth component config (see the book) so that it correctly hashes the password
 */
?>
<div class="container form">
<?php
echo $form->create();
$out = $form->input('username');

$firstName = $form->input('first_name', array('fieldset' => false, 'div' => 'floater'));
$lastName = $form->input('last_name', array('fieldset' => false, 'div' => 'floater floaterLast'));
$out .= $html->tag('div', $firstName . $lastName, array('class' => 'input clearFix'));

$out .= $form->input('email');
$password = $form->input('password', array('fieldset' => false, 'div' => 'floater', 'error' => false));
$confirm = $form->input('confirm', array('fieldset' => false, 'div' => 'floater floaterLast', 'type' => 'password'));
$pwError = $form->error('password');
$out .= $html->tag('div', $password . $confirm . $pwError, array('class' => 'input clearFix'));

$out .= $form->input('generate', array('fieldset' => false, 'type' => 'checkbox',
	'label' => __('Generar una contraseña aleatoria (se mostrará en la siguiente pantalla)', true)));
$out .= $form->input('tos', array('fieldset' => false, 'type' => 'checkbox',
	'label' => sprintf(__('Estoy de acuerdo con los %1$s', true), $html->link(__('términos de uso', true), '/tos', array('class' => 'popup modal noResize noDrag')))
));

echo sprintf($html->tags['fieldset'], '', sprintf($html->tags['legend'], __('Registro', true)) . $out);
echo $form->end(__('Regístrame', true));
?>
</div>
