<div class="matches view">
<h2><?php  echo __('Match'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($match['Match']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tournament'); ?></dt>
		<dd>
			<?php echo $this->Html->link($match['Tournament']['game'], array('controller' => 'tournaments', 'action' => 'view', $match['Tournament']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Player1'); ?></dt>
		<dd>
			<?php echo $this->Html->link($match['Player1']['name'], array('controller' => 'users', 'action' => 'view', $match['Player1']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Player2'); ?></dt>
		<dd>
			<?php echo $this->Html->link($match['Player2']['name'], array('controller' => 'users', 'action' => 'view', $match['Player2']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Video'); ?></dt>
		<dd>
			<?php echo h($match['Match']['video']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Result'); ?></dt>
		<dd>
			<?php echo h($match['Match']['result']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Completed'); ?></dt>
		<dd>
			<?php echo h($match['Match']['completed']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
