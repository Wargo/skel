
___________________
<?php
$footerText = sprintf(__('Sent from %s', true), APP_DIR);
$footerText .= ' | ' .  sprintf(__('Powered by %s', true), 'http://www.cakephp.org');
echo $footerText;