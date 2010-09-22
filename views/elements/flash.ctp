<?php
$messages = $session->read('Message');
if (!$messages) {
	return;
}
foreach (array_keys($messages) as $key) {
	echo $session->flash($key);
}