<?php

/*
 *  Copyright (c) Justin Michael Cruz <Digikid13@gmail.com> 2012. All Rights Reserved.
 *
 *
 */

class rating {
	
	// Rating Info Array
	protected $ratinginfo = array(
		// j is the number of matches 1,2,3,4,etc
		"j" => array(),
		// r is an array of all of the opponent ratings
		"r" => array(),
		// RD is an array of matching opponent RDs
		"RD" => array(),
		// gRD is an array of all the stored gRD values for eatch match
		"gRD" => array(),
		// EsrrRD is an array of all the stored EsrrRD values for eatch match
		"EsrrRD" => array(),
		// s is an array of the outcome of all matches where 1 = win and 0 = lose
		"s" => array()
	);
	
	protected $playerrating;
	
	protected $playerRD;
	
	public $c = 34;
	
	public $t = 1;
	
	public $q = 0.00575646273248511421004497863671;
	
	/* Rating Info Array Construction
	   Input should be an array with the following:
	   
	   array(
	         "rating" => array(),
			 "RD" => array(),
			 "outcome" => array()
	  )
	*/
	public function __construct($r, $rd, array $ratingdata) {
		$this->playerrating = $r;
		$this->playerRD = $rd;
		$i = 0;
		
		while (array_key_exists($i, $ratingdata["rating"])) {
			$this->ratinginfo["j"][$i] = $i + 1;
			$this->ratinginfo["r"][$i] = $ratingdata["rating"][$i];
			$this->ratinginfo["RD"][$i] = $ratingdata["RD"][$i];
			$this->ratinginfo["s"][$i] = $ratingdata["outcome"][$i];
			$i++;
		}
		
		$this->updateArray();
	}
	
	public function newRating() {
		$q = $this->q;
		$rnew = $this->playerrating;
		$RD = $this->playerRD;
		$ratinginfo = $this->ratinginfo;
		$e = 0;
		$summation = 0;
		foreach ($ratinginfo["j"] as $e) {
			$e = $e - 1;
			$summation += $ratinginfo["gRD"][$e] * ($ratinginfo["s"][$e] - $ratinginfo["EsrrRD"][$e]);
		}
		
		$rnew += ($q / ((1 / pow($RD , 2)) + (1 / $this->d2($RD, $ratinginfo)))) * $summation;
		
		return $rnew;
	}
	
	public function newRD() {
		$c = $this->c;
		$t = $this->t;
		$RD = $this->updateRD();
		return sqrt(($RD*$RD)+($c*$c*$t));
	}
	
	protected function gRD($RD) {
		$q = $this->q;
		return (1 / (sqrt(1 + 3 * ($q * $q) * ($RD * $RD) / (pi() * pi()))));
	}
	
	protected function EsrrRD($rating, $RDj, $enmR) {
		$q = $this->q;
		return (1 / (1 + pow(10, -$this->gRD($RDj)*($rating-$enmR)/400)));
	}
	
	protected function d2($RD, array $ratinginfo) {
		$q = $this->q;
		$i = 0;
		$summation = 0;
		foreach ($ratinginfo["j"] as $i) {
			$i = $i - 1;
			$summation += (pow($ratinginfo["gRD"][$i], 2) * $ratinginfo["EsrrRD"][$i] * (1 - $ratinginfo["EsrrRD"][$i]));
			$i++;
		}
		
		$d2 = pow((pow($q, 2) * $summation), -1);
		
		return $d2;
	}
	
	protected function updateRD() {
		$q = $this->q;
		$RD = $this->playerRD;
		$ratinginfo = $this->ratinginfo;
		return sqrt(pow(((1/($RD*$RD)) + (1/$this->d2($RD, $ratinginfo))), -1));
	}
	
	protected function updateArray() {
		$i = 0;
		
		while (array_key_exists($i, $this->ratinginfo["j"])) {
			$this->ratinginfo["gRD"][$i] = $this->gRD($this->ratinginfo["RD"][$i]);
			$this->ratinginfo["EsrrRD"][$i] = $this->EsrrRD($this->playerrating, $this->ratinginfo["RD"][$i], $this->ratinginfo["r"][$i]);
			$i++;
		}
	}	
	
	public function getArray() {
        return $this->ratinginfo;
    }
}
?>