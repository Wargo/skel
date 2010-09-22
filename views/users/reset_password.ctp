<?php echo $this->set('title_for_layout', __('forgotten password 3/3', true)); ?>
<div class="container form">
<?php
echo $form->create();
$inputs = array(
	'legend' => __('Please enter a new password', true),
	'token' => array('type' => 'hidden'),
	$fields['email'] => array('type' => 'hidden'),
);
if ($fields['username'] != 'email') {
	$inputs[$fields['username']] = array('type' => 'hidden', 'value' => 'x');
}
if ($fields['confirmation']) {
	$inputs[] = $fields['confirmation'];
}
$inputs = am($inputs, array(
	$fields['password'],
	$fields['password_confirm'] => array('type' => 'password'),
	'generate' => array(
		'type' => 'checkbox',
		'label' => __('Generate me a random password (shown on the next screen)', true)
	),
));
echo $form->inputs($inputs);
echo $form->end(__('Submit', true));
?></div>