<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('email');
		echo $this->Form->input('bio');
		echo $this->Html->link('Change Pin', array(
			'controller' => 'users',
			'action' => 'changePin',
			$this->Session->read('Auth.User.id')
		));
		echo __('<br>');
		echo $this->Html->link('Change Password', array(
			'controller' => 'users',
			'action' => 'changePassword',
			$this->Session->read('Auth.User.id')
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
