<?php 
echo $this->Html->script('bracket-5'); 
echo $this->Html->css('bracket-5'); 
?>

<h3><?php echo ($tname['Tournament']['game']) ?>

<div id='brackets'>
<script type="text/javascript" >
var bracketData = <?php echo $this->Js->object($bData); ?>

$j(function() {
    $j('#brackets').bracket({
      init: bracketData /* data to initialize the bracket with */ })
  })

</script>


</div>

<div class="related">
	<h3><?php echo __('Active Matches'); ?></h3>
	<table cellpadding='0' cellspacing="0">
		<tr>
			<th><?php echo __('Player 1'); ?></th>
			<th><?php echo __('Player 2'); ?></th>
		</tr>
		<?php
			foreach ($currentMatches as $cMatch): 
			echo $this->Form->create('Match', array( 'url' => array('controller' => 'tournaments', 'action' => 'run', $cMatch['Match']['tournament_id']), 'type' => 'post'));
			echo $this->Form->hidden('id', array('value' => $cMatch['Match']['id'])); ?>
			<tr>
				<td><?php echo $this->Form->submit($cMatch['Player1']['name'], array('name' => 'P1')); ?></td>
				<td><?php echo $this->Form->submit($cMatch['Player2']['name'], array('name' => 'P2')); ?></td>
			</tr>
			<?php echo $this->Form->end();
			endforeach; ?>
	</table>
</div>
