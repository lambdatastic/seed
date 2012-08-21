<div class="users view">
<h2><?php echo h($user['User']['name']); ?> (<?php echo h($user['User']['city']); ?>, <?php echo h($user['User']['state']); ?>)</h2>
<h3><?php echo __('Bio'); ?></h3>
<?php echo h($user['User']['bio']); ?>
</div>

<div class="related">
	<h3><?php echo __('This user\'s rankings'); ?></h3>
	<?php if (!empty($user['Ranking'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Game'); ?></th>
		<th><?php echo __('Rating'); ?></th>
		<th><?php echo __('Rd'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Ranking'] as $ranking): ?>
		<tr>
			<td><?php echo $ranking['game']; ?></td>
			<td><?php echo $ranking['rating']; ?></td>
			<td><?php echo $ranking['rd']; ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
