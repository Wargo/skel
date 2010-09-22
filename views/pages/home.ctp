<?php
/**
 * Prevent showing cake's home page contents if not in debug mode
 */
if (!Configure::read()) {
	return;
}
$coreViews = array_pop(App::path('views'));
require $coreViews . 'pages/home.ctp';