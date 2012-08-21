<div class="rankings form">
<?php echo $this->Form->create('Ranking'); ?>
	<fieldset>
		<legend><?php echo __('Add Ranking'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
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
