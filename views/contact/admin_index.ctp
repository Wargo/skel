<?php /* SVN FILE: $Id$ */ ?>
<table>
<?php
$this->set('title_for_layout', __('Web Contact Messsages', true));
$paginator->options(array('url' => $this->passedArgs));
$th = array(
	$paginator->sort('id'),
	$paginator->sort('status'),
	$paginator->sort(__('From', true), 'reply_to'),
	$paginator->sort('subject'),
	$paginator->sort(__('Sent', true), 'created'),
);
echo $html->tableHeaders($th);
foreach ((array)$data as $row) {
	extract($row);
	$status = $MiEmail['status'];
	if ($status == 'spam') {
		$status = '<span title="Matching rules: ' . $MiEmail['data']['junk_rule_matches'] . '">' . $status .
			' (' . $MiEmail['data']['junk_score'] . ')</span>';
	}
	$tr = array(
		$html->link($MiEmail['id'], array('admin' => false, 'plugin' => 'mi_email', 'controller' => 'mi_email', 'action' => 'view', $MiEmail['id'])),
		$status,
		$MiEmail['reply_to'],
		$html->link(str_replace('Web Contact ', '', $MiEmail['subject']), array('plugin' => 'mi_email', 'controller' => 'mi_email', 'action' => 'text_preview', $MiEmail['id']), array('class' => 'popup', 'title' => 'popup preview (text format)')),
		$time->niceShort($MiEmail['created']),
	);
	echo $html->tableCells($tr, array('class' => 'odd'), array('class' => 'even'));
}
?>
</table>
<?php
echo $this->element('paging');
$menu->del(__('Options', true));
$menu->settings(__('Options', true));
$menu->add(array(
	array('title' => __('Spam', true), 'url' => array('MiEmail.status' => 'spam')),
	array('title' => __('Not Spam', true), 'url' => array('MiEmail.status' => 'sent'))
));