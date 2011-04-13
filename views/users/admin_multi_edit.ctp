<?php
$this->set('title_for_layout', __('Usuarios', true));
echo $form->create(); ?>
<table>
<?php
$th = array(
	__d('field_names', 'Nombre de usuario', true),
	__d('field_names', 'Nombre', true),
	__d('field_names', 'Apellidos', true),
	__d('field_names', 'Email', true),
	__d('field_names', 'Grupo', true),
	__d('field_names', 'Email verificado', true),
);
echo $html->tableHeaders($th);
foreach ($data as $i => $row) {
	if (!is_array($row) || !isset($row['User'])) {
		continue;
	}
	extract($row);
	$tr = array(
		array(
			$form->input($i . '.User.id', array('type' => 'hidden')) .
			$form->input($i . '.User.username', array('div' => false, 'label' => false)),
			$form->input($i . '.User.first_name', array('div' => false, 'label' => false)),
			$form->input($i . '.User.last_name', array('div' => false, 'label' => false)),
			$form->input($i . '.User.email', array('div' => false, 'label' => false)),
			$form->input($i . '.User.group', array('div' => false, 'label' => false)),
			$form->input($i . '.User.email_verified', array('div' => false, 'label' => false, 'type' => 'checkbox')),
		),
	);
	$class = $i%2?'even':'odd';
	if ($this->action === 'admin_multi_add') {
		$class .= ' clone';
	}
	echo $html->tableCells($tr, compact('class'), compact('class'));
}
?>
</table>
<?php
echo $form->end(__('Guardar', true));
if (isset($paginator) && $this->action !== 'admin_multi_add') {
	echo $this->element('paging');
}
