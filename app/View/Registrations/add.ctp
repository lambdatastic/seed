<div class="registrations form">
<?php echo $this->Form->create('Registration'); ?>
	<fieldset>
		<legend><?php echo __('Add Registration'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('tournament_id');
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
