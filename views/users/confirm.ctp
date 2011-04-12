<?php echo $this->set('title_for_layout', __('Recuperar la contraseña 2/3', true)); ?>
<div class="container form">
<?php
echo $form->create();
$inputs = array('legend' => __('Por favor introduce tu código de verificación del email', true), $fields['email']);
if ($fields['confirmation']) {
	$inputs[] = $fields['confirmation'];
}
$inputs['token'] = array('legend' => __('Código', true), 'size' => 40, 'default' => $token);
echo $form->inputs($inputs);
echo $form->end(__('Enviar', true));
?></div>
