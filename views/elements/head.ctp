<head>
	<?php echo $html->charset(); ?>
	<title><?php echo htmlspecialchars($title_for_layout); ?></title>
	<?php
	echo $html->meta('icon');
	echo $html->meta('description', '');
	echo $html->meta('author', '');
	$stripNamed = array(
		'page' => false,
		'fields' => false,
		'order' => false,
		'limit' => false,
		'recursive' => false,
		'sort' => false,
		'direction' => false,
		'step' => false,
	);
	echo $html->meta('canonical', am($this->passedArgs, $stripNamed));
	if (isset ($asset)) {
		echo $asset->css(array(
			'boilerplate',
			'cake.generic',
			'default',
			'/js/theme/jquery.ui',
			'/js/gritter/jquery.gritter',
		));
		echo $asset->out('css');
		$asset->js(array(
			'jquery',
			'gritter/jquery.gritter',
			'jquery.blockUI',
			'jquery.mi.dialogs',
			'default',
		));
		$locale = I18n::getInstance()->l10n->locale;
		if ($locale !== DEFAULT_LANGUAGE && file_exists(APP . 'locale' . DS . $locale)) {
			echo $asset->js('i18n.' . $locale, 'localization');
		}
	}
	echo $html->meta('rss',
		'#',
		array('title' => __('Recent Updates', true))
	);
	echo $scripts_for_layout;

	// All JavaScript is at the end of the page, except for Modernizr which enables HTML5 elements & feature detects
	// And the global SKEL (rename to name of app) object which dynamic scripts can write to, and static files can read from
	?>
	<script src="<?php echo $this->Html->url('/js/modernizr.js') ?>"></script>
	<script type="text/javascript">
		SKEL = {
		};
	</script>
</head>