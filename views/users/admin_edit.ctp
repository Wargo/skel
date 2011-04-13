<div id="tabWrap" class="form-container">
<ul>
		<li><a href="#tab1">Tab 1</a></li>
	</ul>
<?php
if ($this->action === 'admin_add') {
	$this->set('title_for_layout', __('Nuevo usuario', true));
} else {
	$this->set('title_for_layout', __('Editar usuario', true));
}
?>
<div class="form-container">
<?php
echo $form->create(null, array('type' => 'file')); // Default to enable file uploads
echo '<div id="tab1">';
echo $form->inputs(array(
	'legend' => false,
	'id',
	'username',
	'email' => array('div' => 'wide input text'),
	'group',
	'email_verified',
	'first_name' => array('div' => 'wide input text'),
	'last_name' => array('div' => 'wide input text'),
));
echo '</div>';
echo $form->end(__('Guardar', true));
$asset->codeBlock('
	$(document).ready(function() {
		$("#tabWrap").tabs();
	});
');
?></div>
</div>
