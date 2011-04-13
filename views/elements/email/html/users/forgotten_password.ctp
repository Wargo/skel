<?php
extract ($data['User']) ?>
<p><?php echo __('Hola', true) . ' ' . trim($first_name); ?>,</p>

<p><?php echo __('Tenemos una petición para restablecer tu contraseña', true); ?></p>
<br />
<p><?php echo __('Para obtener una nueva contraseña, por favor accede a la siguiente dirección:', true); ?></p>
<p><?php echo $html->link($html->url(array('admin' => false, 'controller' => 'users', 'action' => 'reset_password', $token), true)) ?></p>
<br />
<p><?php echo __('Donde tendrás acceso a una nueva contraseña. Si el enlace no funciona correctamente, tu código es:', true); ?></p>
<p><?php echo $token ?></p>
<br />
<p><?php echo __('Si no has solicitado cambiar tu contraseña, puedes ignorar tranquilamente este email. Tu contraseña no será cambiada.', true); ?></p>
