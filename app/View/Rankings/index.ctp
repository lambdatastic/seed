<div class="rankings index" style="width:72%">
<!--	<h2>Filter by Game</h2>
	<?php
/*
		echo $this->Form->create(false, array('action' => 'leaderboard'));
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
		echo $this->Form->end('Filter');
*/
	?>
-->
	<h2><?php echo __('Rankings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('game'); ?></th>
			<th><?php echo $this->Paginator->sort('rating'); ?></th>
			<th><?php echo $this->Paginator->sort('rd'); ?></th>
	</tr>
	<?php
	foreach ($rankings as $ranking): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($ranking['User']['name'], array('controller' => 'users', 'action' => 'view', $ranking['User']['id'])); ?>
		</td>
		<td><?php echo h($ranking['Ranking']['game']); ?>&nbsp;</td>
		<td><?php echo h($ranking['Ranking']['rating']); ?>&nbsp;</td>
		<td><?php echo h($ranking['Ranking']['rd']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions" style="width:20%">
	<h3><?php echo __('Games'); ?></h3>
	<ul>
		<?php foreach ($games as $game): ?>
		<li><?php echo $this->Html->link(__($game), array('action' => 'leaderboard', '?' => array('game' => $game))); ?> </li>
		<?php endforeach; ?>
	</ul>
</div>
