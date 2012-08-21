<div class="tournaments view">
<h2><?php  echo __('Tournament'); ?></h2>
	<dl>
		<dt><?php echo __('Event'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tournament['Event']['name'], array('controller' => 'events', 'action' => 'view', $tournament['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Game'); ?></dt>
		<dd>
			<?php echo h($tournament['Tournament']['game']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('View Registrations'), array(
			'controller' => 'registrations',
			'action' => 'seeds', 
			'?' => array('event' => $tournament['Tournament']['id']
		))); ?></li>
		<li><?php echo $this->Html->link(__('Start/Run This Tournament'), array(
			'action' => 'start', 
			$tournament['Tournament']['id']
		)); ?></li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Matches In This Tournament'); ?></h3>
	<?php if (!empty($tournament['Match'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Player 1'); ?></th>
		<th><?php echo __('Player 2'); ?></th>
		<th><?php echo __('Video'); ?></th>
		<th><?php echo __('Result'); ?></th>
		<th><?php echo __('Completed'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tournament['Match'] as $match): ?>
		<tr>
			<td><?php echo $match['Player1']['name']; ?></td>
			<td><?php echo $match['Player2']['name']; ?></td>
			<td><?php echo $match['video']; ?></td>
			<td><?php echo $match['result']; ?></td>
			<td><?php echo $this->Html->link($match['completed'], array('controller' => 'matches', 'action' => 'view', $match['id'])); ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>