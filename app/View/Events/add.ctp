<div class="events form">
<?php echo $this->Form->create('Event'); ?>
	<fieldset>
		<legend><?php echo __('Add Event'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('venue');
		echo $this->Form->input('starttime');
		echo $this->Form->input('endtime');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
