<div class="matches index">
	<h2><?php echo __('Matches'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('tournament_id'); ?></th>
			<th><?php echo $this->Paginator->sort('player1_id'); ?></th>
			<th><?php echo $this->Paginator->sort('player2_id'); ?></th>
			<th><?php echo $this->Paginator->sort('video'); ?></th>
			<th><?php echo $this->Paginator->sort('result'); ?></th>
			<th><?php echo $this->Paginator->sort('completed'); ?></th>
	</tr>
	<?php
	foreach ($matches as $match): ?>
	<tr>
		<td><?php echo h($match['Match']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($match['Tournament']['id'], array('controller' => 'tournaments', 'action' => 'view', $match['Tournament']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($match['Player1']['name'], array('controller' => 'users', 'action' => 'view', $match['Player1']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($match['Player2']['name'], array('controller' => 'users', 'action' => 'view', $match['Player2']['id'])); ?>
		</td>
		<td><?php echo h($match['Match']['video']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['result']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['completed']); ?>&nbsp;</td>
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
