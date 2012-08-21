<div class="rankings index">
	<h2><?php echo __('Rankings'); ?></h2>
<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('game'); ?></th>
			<th><?php echo $this->Paginator->sort('rating'); ?></th>
			<th><?php echo $this->Paginator->sort('rd'); ?></th>
	</tr>
	<?php
	foreach ($leaders as $ranking): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($ranking['User']['name'], array('controller' => 'users', 'action' => 'view', $ranking['User']['id'])); ?>
		</td>
		<td><?php echo h($ranking['Ranking']['game']); ?>&nbsp;</td>
		<td><?php echo h($ranking['Ranking']['rating']); ?>&nbsp;</td>
		<td><?php echo h($ranking['Ranking']['rd']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
