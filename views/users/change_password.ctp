<div class="container form">
<?php
echo $form->create();
echo $form->inputs(array(
	'legend' => __('Change your password', true),
	'username' => array('type' => 'hidden'),
	'current_password' => array('type' => 'password'),
	'password',
	'confirm' => array('type' => 'password'),
	'generate' => array(
		'type' => 'checkbox',
		'label' => __('Generate me a random password (shown on the next screen)', true)
	),
));
echo $form->end(__('Submit', true));
$menu->settings(__('Options', true));
$menu->add(array(
	array('title' => __('Edit your profile', true), 'url' => array('action' => 'edit')),
));
?></div>