<div class="rankings view">
<h2><?php  echo __('Ranking'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ranking['Ranking']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ranking['User']['name'], array('controller' => 'users', 'action' => 'view', $ranking['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Game'); ?></dt>
		<dd>
			<?php echo h($ranking['Ranking']['game']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rating'); ?></dt>
		<dd>
			<?php echo h($ranking['Ranking']['rating']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rd'); ?></dt>
		<dd>
			<?php echo h($ranking['Ranking']['rd']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
