<?php
extract($data);
$this->set('title_for_layout', $User['id']);
?>
<h3>display</h3>
<div class="odd clearfix">
	<div class="field athird">
		<div class="name"><?php __d('field_names', 'Web Id') ?></div>
		<div class="value"><?php echo $User['web_id']; ?></div>
	</div>
	<div class="field athird">
		<div class="name"><?php __d('field_names', 'Verificación del email') ?></div>
		<div class="value"><?php echo $User['email_verified']; ?></div>
	</div>
</div>
<h3>half</h3>
<div class="odd clearfix">
	<div class="field half">
		<div class="name"><?php __d('field_names', 'Identificador') ?></div>
		<div class="value"><?php echo $User['id']; ?></div>
	</div>
	<div class="field half">
		<div class="name"><?php __d('field_names', 'Nombre de usuario') ?></div>
		<div class="value"><?php echo $User['username']; ?></div>
	</div>
</div>
<div class="even clearfix">
	<div class="field half">
		<div class="name"><?php __d('field_names', 'Grupo') ?></div>
		<div class="value"><?php echo $enum->display('User.group', $User['group']); ?></div>
	</div>
</div>
<h3>default</h3>
<div class="odd clearfix">
	<div class="field">
		<div class="name"><?php __d('field_names', 'Email') ?></div>
		<div class="value"><?php echo $User['email']; ?></div>
	</div>
</div>
<div class="even clearfix">
	<div class="field">
		<div class="name"><?php __d('field_names', 'Nombre') ?></div>
		<div class="value"><?php echo $User['first_name']; ?></div>
	</div>
</div>
<div class="odd clearfix">
	<div class="field">
		<div class="name"><?php __d('field_names', 'Apellidos') ?></div>
		<div class="value"><?php echo $User['last_name']; ?></div>
	</div>
</div>
<?php
$menu->settings(__('Este usuario', true));
$menu->add(array(
	array('title' => __('Editar', true), 'url' => array('action' => 'edit', $User['id'])),
	array('title' => __('Eliminar', true), 'url' => array('action' => 'delete', $User['id']))
));
