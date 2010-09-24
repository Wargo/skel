<?php
echo $form->create(null, array('action' => 'multi_process'));
?>
<table class="stickyHeader">
<?php
$this->set('title_for_layout', __('Users', true));
$th = array(
	$form->checkbox('Mark.allUsers', array('class' => 'markAll')),
	$paginator->sort('username'),
	$paginator->sort('email'),
	$paginator->sort('group'),
	$paginator->sort('email_verified'),
	$paginator->sort('first_name'),
	$paginator->sort('last_name'),
	__('actions', true)
);
echo $html->tableHeaders($th);
foreach ($data as $i => $row) {
	extract($row);

	$actions = array(
		$html->link(' ', array('action' => 'edit', $User['id']),
			array('class' => 'mini-icon mini-pencil', 'title' => __('Edit', true))),
		$html->link(' ', array('action' => 'delete',  $User['id']),
			array('class' => 'mini-icon mini-close', 'title' => __('Delete', true)))
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
	'deleteAll' => __('Delete', true),
	'editAll' => __('Edit', true),
	//'clipAll' => __('Add to clipboard', true),
	'emailVerifiedAll' => __('Mark Email Verified', true),
	'unEmailVerifiedAll' => __('Mark Not Email Verified', true),
);
echo $form->input('App.multiAction', array('options' => $options, 'empty' => __('--choose--', true), 'label' => __('For the selected Users:', true)));
echo $form->submit(__('Apply', true));
echo $form->end();
?>
</div>
<?php
echo $this->element('mi_panel/paging');
$menu->settings(__('Options', true), array());
$menu->add(array(
	array('title' => __('New User', true), 'url' => array('action' => 'add')),
	array('title' => __('Add Users', true), 'url' => array('action' => 'multi_add')),
	//array('title' => __('Edit These Users', true), 'url' => am($this->passedArgs, array('action' => 'multi_edit')))
));