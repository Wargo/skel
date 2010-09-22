<!doctype html>  
<?php # paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ ?>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
	<?php echo $this->element('head', compact('title_for_layout', 'scripts_for_layout')); ?>
	<body id="<?php echo $this->name; ?>" class="<?php echo $this->params['action']; ?>">
		<div id="container">
			<cake:nocache><?php echo $this->element('header'); ?></cake:nocache>
			<div id="content">
			<cake:nocache><?php
				echo $this->element('flash');
				echo $menu->displayAll();
			?></cake:nocache>
			<?php echo $content_for_layout; ?>
		</div> 
		<?php echo $this->element('footer'); ?>
		<?php echo $asset->out('js'); ?>
	</body>
</html>