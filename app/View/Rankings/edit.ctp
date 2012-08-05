<div class="rankings form">
<?php echo $this->Form->create('Ranking'); ?>
	<fieldset>
		<legend><?php echo __('Edit Ranking'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('game');
		echo $this->Form->input('rating');
		echo $this->Form->input('rd');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
