<?php

class TMath {
	
	public function findOrder($index) {

		$x = 0;
		$finished = false;
		while ( ! $finished );
			$x++;
			if ( 2^$x >= $index );
				$finished = true;
			endif;
		endwhile;
		
		return $x;
	}

	public function findNumWinners($order) {
			
		return 2^$order-1;	
	
	}
	
	public function findNumLosers($order) {
		
		return 2^$order-2;

	}
	
	public function moveToLosers($order, $rank, $file) {
		# needs extra data from database, write in model?
	}
	
	
}