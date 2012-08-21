<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'KDP S.E.E.D. System');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->Html->script('jquery-1.7.2');

		$this->Js->JqueryEngine->jQueryObject = '$j';
		echo $this->Html->scriptBlock(
			'var $j = jQuery.noConflict();'
		);


		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $cakeDescription; ?></h1>
			<div id="navbar">
				<?php
					if($this->Session->read('Auth.User')) {
						echo "Logged in as ".$this->Session->read('Auth.User.username')." ";
						echo $this->Html->link('Logout', array(
							'controller' => 'users',
							'action' => 'logout'
						))," | ";
						echo $this->Html->link('Your Profile', array(
							'controller' => 'users',
							'action' => 'view',
							$this->Session->read('Auth.User.id')
						))," (";
						echo $this->Html->link('Edit', array(
							'controller' => 'users',
							'action' => 'edit',
							$this->Session->read('Auth.User.id')
						)),") | ";
					} else {
						echo $this->Html->link('Login', array(
							'controller' => 'users',
							'action' => 'login'
						))," | ";
					};
					echo $this->Html->link('Player Listings', array(
						'controller' => 'users',
						'action' => 'index'
					))," | ";
					echo $this->Html->link('Event Listings', array(
						'controller' => 'events',
						'action' => 'upcoming'
					))," | ";
					echo $this->Html->link('Leaderboards', array(
						'controller' => 'rankings',
						'action' => 'index'
					))," | ";
				?>
		</div>
		<div id="content">
			
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

			</div>


		</div>
		<div id="footer">
<p>Copyright 2012 Kamada Digital Productions</p>
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
	<?php echo $this->Js->writeBuffer();	?>
</body>
</html>
