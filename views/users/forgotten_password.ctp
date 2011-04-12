<?php
/**
 * If your login and password fields are not called username and password remember to change the field
 * names here AND change the auth component config (see the book) so that it correctly hashes the password
 */
?>
<?php echo $this->set('title_for_layout', __('Recuperar la contraseña 1/3', true)); ?>
<p>
	If you've forgotten your password you can reset it by submitting the form below
</p>
<p>
	We'll send you an email that you must read to proceed, this helps to confirm that it's
	really you requesting to change your password. All you need to do is check the mail - click
	the link and enter a new password to regain access to your account.
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
