<div class="players form">
<?php echo $this->Form->create('Player'); ?>
	<fieldset>
		<legend><?php echo __('Edit Player'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('email');
		echo $this->Form->input('role');
		echo $this->Form->input('bio');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Player.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Player.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Players'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Rankings'), array('controller' => 'rankings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ranking'), array('controller' => 'rankings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Matches'), array('controller' => 'matches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Played As1'), array('controller' => 'matches', 'action' => 'add')); ?> </li>
	</ul>
</div>
