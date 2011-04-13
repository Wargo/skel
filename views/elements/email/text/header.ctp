<?php
if (!isset($emailData['MiEmail']['type']) || !in_array($emailData['MiEmail']['type'], array('normal', 'newsletter_copy'))) {
	return;
}
echo __('Ver este email correctamente aquí', true);
?>

<?php
if ($emailData['MiEmail']['type'] == 'normal') {
	echo $html->url(array('admin' => false, 'full_base' => true, 'controller' => 'mi_email', 'action' => 'view',
		$emailData['MiEmail']['id']));
} else {
	echo $html->url(array('admin' => false, 'full_base' => true, 'controller' => 'mi_email', 'action' => 'newsletter',
		$emailData['MiEmail']['chain_id']));
}
?>

___________________
