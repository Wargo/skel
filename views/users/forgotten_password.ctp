<?php
/**
 * If your login and password fields are not called username and password remember to change the field
 * names here AND change the auth component config (see the book) so that it correctly hashes the password
 */
?>
<?php echo $this->set('title_for_layout', __('Recuperar la contraseña 1/3', true)); ?>
<p>
	<?php echo __('Si has olvidado tu contraseña, puedes reiniciarla enviando este formulario', true); ?>
</p>
<p>
	<?php echo __('Te enviaremos un email que debes leer para continuar, esto confirma que realmente eres tú el que quieres cambiar la contraseña. Todo lo que necesitas es leer el email, seguir el enlace, rellenar algunos datos de verificación y escribir tu nueva contraseña.', true); ?>
</p>
<div class="container form">
<?php
		echo $form->create();
		if ($authFields['username'] == 'email') {
			echo $form->input('email');
		} else {
			echo $form->input('email', array('label' => __('Email o nombre de usuario', true)));
		}
		echo $form->submit(__('Obtener nueva contraseña', true))  ;
		echo $form->end();
		?>
</div>
