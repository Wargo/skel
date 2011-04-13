<?php
extract ($data['User']) ?>
<?php echo __('Hola', true) . ' ' .  trim($first_name); ?>,

<?php echo __('Tenemos una petición para restablecer tu contraseña', true); ?>

<?php echo __('Para obtener una nueva contraseña, por favor accede a la siguiente dirección:', true); ?>
<?php echo $html->url(array('admin' => false, 'controller' => 'users', 'action' => 'reset_password', $token), true) ?>


<?php echo __('Donde tendrás acceso a una nueva contraseña. Si el enlace no funciona correctamente, tu código es:', true); ?>
<?php echo $token ?>


<?php echo __('Si no has solicitado cambiar tu contraseña, puedes ignorar tranquilamente este email. Tu contraseña no será cambiada.', true); ?>
