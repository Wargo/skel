<head>
	<?php echo $html->charset(); ?>
	<title><?php echo htmlspecialchars($title_for_layout); ?></title>
	<?php
	echo $html->meta('icon');
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
			'cake.generic',
			'default',
			'/js/theme/jquery.ui',
		));
		echo $asset->out('css');
		$asset->js(array(
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
	?>
	<!--[if IE 6]>
	<?php echo $html->css('ie/6.css'); ?>
	<![endif]-->

	<!--[if IE 7]>
	<?php echo $html->css('ie/7.css'); ?>
	<![endif]-->
</head>