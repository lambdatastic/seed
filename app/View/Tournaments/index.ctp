<div class="tournaments index">
	<h2><?php echo __('Tournaments'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('event_id'); ?></th>
			<th><?php echo $this->Paginator->sort('game'); ?></th>
	</tr>
	<?php
	foreach ($tournaments as $tournament): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($tournament['Event']['name'], array('controller' => 'events', 'action' => 'view', $tournament['Event']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($tournament['Tournament']['game'], array('action' => 'view', $tournament['Tournament']['id'])); ?>
		</td>
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
