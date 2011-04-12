<?php
/**
 * If your login and password fields are not called username and password remember to change the field
 * names here AND change the auth component config (see the book) so that it correctly hashes the password
 */
?>
<div class="container form">
<?php
if (empty($this->params['isAjax'])) {
	$legend = __('Login', true);
} else {
	$legend = false;
}
echo $form->create();
$after = '<p>' . $html->link(__('Recuperar contraseña', true), array('action' => 'forgotten_password')) .
	' ' . $html->link(__('Registro', true), array('action' => 'register')) .
	'</p>';

echo $form->inputs(array(
	'legend' => $legend,
	'username',
	'password' => array('value' => '', 'after' => $after),
	'remember_me' => array('label' => __('Recuérdame', true), 'type' => 'checkbox')
));
echo $form->end(__('Login', true));
?>
</div>
