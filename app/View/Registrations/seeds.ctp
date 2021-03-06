<div class="registrations index">
	<h2><?php echo __('Registrations'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('rating'); ?></th>
			<th><?php echo $this->Paginator->sort('rd'); ?></th>
	</tr>
	<?php
	foreach ($registrations as $registration): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($registration['User']['name'], array('controller' => 'users', 'action' => 'view', $registration['User']['id'])); ?>
		</td>
		<td><?php echo h($registration['Registration']['rating']); ?>&nbsp;</td>
		<td><?php echo h($registration['Registration']['rd']); ?>&nbsp;</td>
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