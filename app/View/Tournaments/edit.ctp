<div class="tournaments form">
<?php echo $this->Form->create('Tournament'); ?>
	<fieldset>
		<legend><?php echo __('Edit Tournament'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('event_id');
		echo $this->Form->select('game',  array(
				'Guilty Gear Accent Core Plus' => 'Guilty Gear Accent Core Plus',
				'BlazBlue Continuum Shift Extend' => 'BlazBlue Continuum Shift Extend',
				'Ultimate Marvel vs Capcom 3' => 'Ultimate Marvel vs Capcom 3',
				'King of Fighters XIII' => 'King of Fighters XIII',
				'Super Street Fighter 4 Arcade Ed Ver 2012' => 'Super Street Fighter 4 Arcade Ed Ver 2012',
				'Street Fighter x Tekken' => 'Street Fighter x Tekken',
				'Melty Blood Actress Again Current Code' => 'Melty Blood Actress Again Current Code',
				'SkullGirls' => 'SkullGirls',
				'Persona 4 Arena' => 'Persona 4 Arena',
				'3rd Strike' => '3rd Strike',
				'Tekken 6' => 'Tekken 6',
				'Mortal Kombat' => 'Mortal Kombat',
				'Virtua Fighter 5' => 'Virtua Fighter 5',
				'JoJos HD' => 'JoJos HD',
				'Dead or Alive 4' => 'Dead or Alive 4'
			)
		);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Tournament.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Tournament.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tournaments'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Matches'), array('controller' => 'matches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Match'), array('controller' => 'matches', 'action' => 'add')); ?> </li>
	</ul>
</div>
