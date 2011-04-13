<?php
echo $form->create(null, array('action' => 'multi_process'));
?>
<table class="stickyHeader">
<?php
$this->set('title_for_layout', __('Usuarios', true));
$th = array(
	$form->checkbox('Mark.allUsers', array('class' => 'markAll')),
	$paginator->sort('username'),
	$paginator->sort('email'),
	$paginator->sort('group'),
	$paginator->sort('email_verified'),
	$paginator->sort('first_name'),
	$paginator->sort('last_name'),
	__('Acciones', true)
);
echo $html->tableHeaders($th);
foreach ((array)$data as $i => $row) {
	extract($row);

	$actions = array(
		$html->link(' ', array('action' => 'edit', $User['id']),
			array('class' => 'mini-icon mini-pencil', 'title' => __('Editar', true))),
		$html->link(' ', array('action' => 'delete',  $User['id']),
			array('class' => 'mini-icon mini-close', 'title' => __('Eliminar', true)))
	);
	$tr = array(
		array(
			$form->checkbox('User.' . $User['id'], array('class' => 'identifyRow')) .
				$html->link($User['id'], array('action' => 'view', $User['id']), array('class' => 'hidden')),
			$User['username'],
			$User['email'],
			$enum->display('User.group', $User['group']),
			$enum->display('User.email_verified', $User['email_verified']),
			$User['first_name'],
			$User['last_name'],
			implode($actions)
		),
	);
	$class = $i%2?'even':'odd';
	echo $html->tableCells($tr, compact('class'), compact('class'));
}
?>
</table>
<div class="buttonChoice">
<?php
$options = array(
	'deleteAll' => __('Eliminar', true),
	'editAll' => __('Editar', true),
	//'clipAll' => __('Añadir al clipboard', true),
	'emailVerifiedAll' => __('Marcar el email como verificado', true),
	'unEmailVerifiedAll' => __('Marcar el email como no verificado', true),
);
echo $form->input('App.multiAction', array('options' => $options, 'empty' => __('--elige--', true), 'label' => __('Para los usuarios seleccionados:', true)));
echo $form->submit(__('Aplicar', true));
echo $form->end();
?>
</div>
<?php
echo $this->element('mi_panel/paging');
$menu->settings(__('Opciones', true), array());
$menu->add(array(
	array('title' => __('Nuevo usuario', true), 'url' => array('action' => 'add')),
	array('title' => __('Añadir usuario', true), 'url' => array('action' => 'multi_add')),
	//array('title' => __('Editar estos usuarios', true), 'url' => am($this->passedArgs, array('action' => 'multi_edit')))
));
