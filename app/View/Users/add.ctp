<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('username');
		echo $this->Form->input('pwd', array('type'=>'password', 'value'=>'', 'label'=>'Password'));
		echo $this->Form->input('pwd_repeat', array('type'=>'password', 'value'=>'', 'label'=>'Confirm Password'));
		echo $this->Form->input('email');
		echo $this->Form->select('role', array(
			'player' => 'Player',
			'tourno' => 'Tournament Organizer',
			'admin' => 'Administrator'
		));
		echo $this->Form->input('bio');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
