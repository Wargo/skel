<div class='paging'>
<?php
echo $paginator->prev('«', array(), null);
echo '&nbsp;' . $paginator->numbers(array('separator' => ' | ')) . '&nbsp;';
echo $paginator->next('»', array(), null);
?>
<br />
<?php echo $paginator->counter(array('format' => 'range')); ?>
</div>