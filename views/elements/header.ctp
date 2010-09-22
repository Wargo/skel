<header class='clearfix'>
<?php if ($this->params['url']['url'] === '/' || empty($title_for_layout)): ?>
	<h1><?php echo $html->link(APP_DIR, '/'); ?></h1>
<?php else: ?>
	<h1><?php echo $html->link(APP_DIR, '/') . ' - ' . $title_for_layout ?></h1>
<?php endif;
$menu->settings(__('main', true));
if ($session->check('Auth.User') && empty($isEmail)) {
	$menu->add(array(
		array('title' => __('Your Profile', true), 'url' => array('controller' => 'users', 'action' => 'profile')),
		// A deliberate teaser. If the user isn't an admin they can't access it
		array('title' => __('Admin', true), 'url' => '/admin'),
		array('title' => __('Logout', true), 'url' => array('controller' => 'users', 'action' => 'logout')),
	));
} else {
	$menu->add(array(
		array('title' => __('Register', true), 'url' => array('controller' => 'users', 'action' => 'register')),
		array('title' => __('Login', true), 'url' => array('controller' => 'users', 'action' => 'login'), 'htmlAttributes' => array('class' => 'login')),
	));
}
echo $menu->display();
?>
</header>