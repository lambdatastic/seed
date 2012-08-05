<div class="players view">
<h2><?php echo h($player['Player']['name']); ?> (<?php echo h($player['Player']['city']); ?>, <?php echo h($player['Player']['state']); ?>)</h2>
<h3><?php echo __('Bio'); ?></h3>
<?php echo h($player['Player']['bio']); ?>
</div>
<div class="related">
	<h3><?php echo __('Rankings'); ?></h3>
	<?php if (!empty($player['Ranking'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Game'); ?></th>
		<th><?php echo __('Rating'); ?></th>
		<th><?php echo __('Rd'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($player['Ranking'] as $ranking): ?>
		<tr>
			<td><?php echo $ranking['game']; ?></td>
			<td><?php echo $ranking['rating']; ?></td>
			<td><?php echo $ranking['rd']; ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

