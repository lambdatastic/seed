<div class="events view">
<h2><?php  echo __('Event'); ?></h2>
	<dl>
		<dt><?php echo __('Primary TO'); ?></dt>
		<dd>
			<?php echo $this->Html->link($event['User']['name'], array('controller' => 'users', 'action' => 'view', $event['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($event['Event']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Venue'); ?></dt>
		<dd>
			<?php echo h($event['Event']['venue']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Starts At'); ?></dt>
		<dd>
			<?php echo h($event['Event']['starttime']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ends At'); ?></dt>
		<dd>
			<?php echo h($event['Event']['endtime']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php if(AuthComponent::user('role') == 'admin' || AuthComponent::user('role') == 'tourno') { ?>
		<li><?php echo $this->Html->link(__('Edit Event'), array('controller' => 'events', 'action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Add A Tournament'), array(
			'controller' => 'tournaments', 
			'action' => 'add',
			'?' => array('event' => $event['Event']['id']
		))); ?> </li>
		<li><?php echo $this->Html->link(__('Register a player'), array(
			'controller' => 'registrations', 
			'action' => 'add',
			'?' => array('event' => $event['Event']['id']
		))); ?> </li>
		<?php }; ?>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Games for this event'); ?></h3>
	<?php if (!empty($event['Tournament'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Game'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($event['Tournament'] as $tournament): ?>
		<tr>
			<td><?php echo $this->Html->link($tournament['game'], array('controller' => 'tournaments', 'action' => 'view', $tournament['id'])); ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>