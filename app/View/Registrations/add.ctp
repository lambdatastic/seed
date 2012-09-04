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
