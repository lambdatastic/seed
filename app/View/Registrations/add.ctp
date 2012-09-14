<div class="registrations form">
<?php echo $this->Form->create('Registration'); ?>
	<fieldset>
		<legend><?php echo __('Add Registration'); ?></legend>
	<?php
		echo $this->Form->input('user_link');
		echo $this->Form->input('user_pin', array('type' => 'password'));
		echo $this->Form->input('user_id', array(
			'empty' => '(Use if card is forgotten)'
		));
		echo $this->Form->select('tournament_id', $tournaments, array(
			'multiple' => 'checkbox'
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h2><?php echo __('Registrations for this event'); ?></h2>
	<?php foreach ($tlist as $t): ?>
		<h3><?php echo $t['Tournament']['game'] ?></h3><?php echo $this->Html->link(__('Start/Run This Tournament'), array(
			'controller' => 'tournaments',
			'action' => 'start', 
			$t['Tournament']['id']
		), array(
			'class' => 'actions',
			'target' => '_blank'
		)); ?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th style="width:20%"><?php echo __('Player'); ?></th>
			<th style="width:20%"><?php echo __('Rating'); ?></th>
			<th style="width:20%"><?php echo __('RD'); ?></th>
			<th style="width:20%"><?php echo __('Actions'); ?></th>
		</tr>
		<?php
		$regs = array_shift($registrations);
		foreach ($regs as $r): ?>
			<tr>
				<td><?php echo $r['User']['name']; ?></td>
				<td><?php echo $r['Registration']['rating']; ?></td>
				<td><?php echo $r['Registration']['rd']; ?></td>
			<td >
				<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $r['Registration']['id']), null, __('Are you sure you want to delete the registration for %s?', $r['User']['name'])); ?>
			</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endforeach; ?>
</div>
