<?php
Router::parseExtensions('rss', 'xml', 'ajax', 'json');

Router::connect('/', array('controller' => 'forced', 'action' => 'error'));
Router::connect('/admin', array('admin' => true, 'controller' => 'users', 'action' => 'index'));

/**
 * Store lookup results in a path that gets cleared
 */
App::import('Core', 'Security');
$random = Security::hash('just so public users cant guess', 'sha1', true);
Router::connect('/cache/' . $random . '/lookup/:controller/*',
	array('admin' => true, 'action' => 'lookup')
);
Router::connect('/cache/' . $random . '/lookup/:controller/*',
	array('action' => 'lookup')
);

/**
 * If the code reaches here, there  is no cached or vendor-served css/js/etc file.
 * Serve images and files that look like app-generated requests via the media controller
 */
/**
 * Forward missing media requests to the media serve funciton
 */
Router::connect(
	'/:mediaType/*',
	array('plugin' => 'media', 'controller' => 'media', 'action' => 'serve'),
	array('mediaType' => '(aud|doc|gen|ico|img|txt|vid)')
);

/**
 * Forward css and js requests to the asset serve funciton
 */
Router::connect(
	'/:mediaType/*',
	array('plugin' => 'mi_asset', 'controller' => 'asset', 'action' => 'serve'),
	array('mediaType' => '(css|js)')
);