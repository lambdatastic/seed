<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit Pin'); ?></legend>
	<?php
		echo $this->Form->input('pin', array('type'=>'password', 'value'=>'', 'label'=>'Pin'));
		echo $this->Form->input('pin_check', array('type'=>'password', 'value'=>'', 'label'=>'Confirm Pin'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
