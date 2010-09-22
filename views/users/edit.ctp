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
echo $form->end(__('Submit', true));

$menu->settings(__('Options', true));
$menu->add(array(
	array('title' => __('Change your password', true), 'url' => array('action' => 'change_password')),
));
?></div>