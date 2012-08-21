<div class="matches form">
<?php echo $this->Form->create('Match'); ?>
	<fieldset>
		<legend><?php echo __('Add Match'); ?></legend>
	<?php
		echo $this->Form->input('tournament_id');
		echo $this->Form->input('player1_id');
		echo $this->Form->input('player2_id');
		echo $this->Form->input('video');
		echo $this->Form->input('result');
		echo $this->Form->input('completed');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
