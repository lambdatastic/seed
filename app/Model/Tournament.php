<?php
App::uses('AppModel', 'Model');
/**
 * Tournament Model
 *
 * @property Event $Event
 * @property Match $Match
 */
class Tournament extends AppModel {

	public $displayField = 'game';
	public $recursive = 2;
	public $cacheQueries = true;
	public $actAs = array("Tree");	
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'event_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Match' => array(
			'className' => 'Match',
			'foreignKey' => 'tournament_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Registration' => array(
			'className' => 'Registration',
			'foreignKey' => 'tournament_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => array('Registration.rating DESC', 'Registration.rd'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * TMath routines to make working with the related trees easier
 *
 * Still not sure if this should be in the Match or Tournament Model, so we'll stick it here for now
 * It can always call the Match model if we need it
 *
 */
 
	public function findOrder($index) {

		$x = 0;
		$finished = false;
		while ( ! $finished ) {
			$x++;
			if ( pow(2, $x) >= $index ) {
				return $x;
			};
		};
		
		
	}

	public function initMatches($order, $seed) {
		$h = pow(2, $order) - 1;
		$i = pow(2, $order) / 2;
		
		for ($j = 0; $j < $i; $j++) {
			$start[$j]['tournament_id'] = (int)$seed[$j]['Registration']['tournament_id'];
			$start[$j]['type'] = 'WI';
			$start[$j]['round'] = $order;
			$start[$j]['column'] = $j + 1;
			$start[$j]['player1_id'] = (int)$seed[$j]['Registration']['user_id'];
			if	(!$seed[$h-$j]) {
				$start[$j]['player2_id'] = null;
				$start[$j]['result'] = 'P1';
				$start[$j]['completed'] = date('Y-m-d h:i:s');
			} else {
				$start[$j]['player2_id'] = (int)$seed[$h-$j]['Registration']['user_id'];
			}
		}
		
		return $start;
		
	}


	public function initMatchesTrue($order, $seed) {
		$seedSort = array(1,2);
		
		for ($j = 2; $j <= $order; $j++) {
			$k = pow(2, $j) / 2;
			for ($l = 0; $l < $k; $l++) {
				$m = array_shift($seedSort);
				array_push($seedSort, $m, pow(2, $j) - $m + 1);
			}
		}
		
		#debug($seedSort);
		
		$i = pow(2, $order) / 2;
		
		for ($j = 0; $j < $i; $j++) {
			$start[$j]['tournament_id'] = (int)$seed[$j]['Registration']['tournament_id'];
			$start[$j]['type'] = 'WI';
			$start[$j]['round'] = $order;
			$start[$j]['column'] = $j + 1;
			$start[$j]['player1_id'] = (int)$seed[$seedSort[$j * 2] - 1]['Registration']['user_id'];
			if	(!$seed[$seedSort[$j * 2 + 1] - 1]) {
				$start[$j]['player2_id'] = null;
				$start[$j]['result'] = 'P1';
				$start[$j]['completed'] = date('Y-m-d H:i:s');
			} else {
				$start[$j]['player2_id'] = (int)$seed[$seedSort[$j * 2 + 1] - 1]['Registration']['user_id'];
			}
		}
		
		return $start;
	}
		
}
