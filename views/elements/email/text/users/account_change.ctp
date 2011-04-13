<?php
extract($data);
extract ($data['User']) ?>
<?php echo __('Hola', true) . ' ' . trim($first_name); ?>,

<?php echo __('Este email es para confirmar que tu', true) . ' ' . $change . ' ' . __('ha cambiado', true); ?>

<?php if (!empty($oldValue)) : ?>
	<?php echo __('Tu anterior', true) . ' ' . $change . ' (' . $oldValue . '), ' . __('ya no se podrá usar en tu cuenta.', true); ?>
<?php endif; ?>

<?php echo __('Si no has cambiado tu', true) . ' ' . $change . ', ' . __('por favor, contacta con nosotros lo antes posible', true); ?>

<?php
echo $html->url(array(
	'controller' => 'contact',
	'action' => 'us',
), true);
