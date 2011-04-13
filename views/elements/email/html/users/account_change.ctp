<?php
extract($data);
extract ($data['User']) ?>
<p><?php echo __('Hola', true) . ' ' . trim($first_name); ?>,</p>

<p><?php echo __('Este email es para confirmar que tu', true) . ' ' . $change . ' ' __('ha cambiado', true); ?></p>
<?php if ($oldValue) : ?>
	<p><?php echo __('Tu anterior', true) . ' ' . $change ?> (<?php echo $oldValue ?>), <?php echo __('ya no se podrá usar en tu cuenta.', true); ?></p>
<?php endif; ?>
<br />
<p><?php
echo __('Si no has cambiado tu', true) . ' ' . $change . ', ' . __('por favor', true) . ' ' . $html->link(__('contacta con nosotros', true), array(
	'controller' => 'contact',
	'action' => 'us',
	'category' => '!',
	'subject' => 'My ' . $change . ' has changed and I didn\'t request it',
	'from' => $email
)) . ' ' . __('tan pronto como sea posible', true);
?></p>
