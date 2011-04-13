<?php
extract ($data['User']) ?>
<?php echo __('Hola', true) . ' ' . trim($first_name); ?>,

<?php echo __('Gracias por registrarte', true) . ' ' . $username . '!'; ?>

<?php
echo __('Para verificar tu email y darte acceso total a tu cuenta, por favor', true) . ' ';
echo $html->link(__('confirma tu cuenta', true), $html->url(array('admin' => false, 'controller' => 'users', 'action' => 'confirm', $token), true)) . ' ' . __('en las siguientes 24 horas', true);
echo $html->url(array('admin' => false, 'controller' => 'users', 'action' => 'confirm', $token), true) ?>


<?php echo __('Si el enlace de arriba no funcionar correctamente, tu código es:', true); ?>
<?php echo $token ?>


<?php echo __('Si no has creado una cuenta con nosotros, por favor, ignora este email', true); ?>
