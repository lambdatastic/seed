
	<h2><?php echo __('Players'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
	</tr>
	<?php
	foreach ($players as $player): ?>
	<tr>
		<td><?php echo $this->Html->link(__($player['Player']['name']), array('action' => 'view', $player['Player']['id'])); ?>&nbsp;</td>
		<td><?php echo h($player['Player']['city']); ?>&nbsp;</td>
		<td><?php echo h($player['Player']['state']); ?>&nbsp;</td>
		<td><?php echo h($player['Player']['username']); ?>&nbsp;</td>
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

