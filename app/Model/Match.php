<?php
App::uses('AppModel', 'Model');
/**
 * Match Model
 *
 * @property Tournament $Tournament
 * @property Player1 $Player1
 * @property Player2 $Player2
 */
class Match extends AppModel {

	public $actAs = array("Tree");	

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'tournament_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'player1_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'player2_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'result' => array(
			'alphaNumeric' => array(
				'rule' => array('alphaNumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'completed' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => false,
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
		'Tournament' => array(
			'className' => 'Tournament',
			'foreignKey' => 'tournament_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Player1' => array(
			'className' => 'User',
			'foreignKey' => 'player1_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Player2' => array(
			'className' => 'User',
			'foreignKey' => 'player2_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Various functions
 */

	public function moveToLosers ($tournament_id, $order, $matchInfo, $playerId) {
	
		if ($matchInfo['round'] = $order) {
			$nextMatch['Match']['type'] = 'LV'	;
			$nextMatch['Match']['round'] = $order - 1;
			if ($matchInfo['column'] % 2 == 1) {
				$nextMatch['Match']['column'] = ($matchInfo['column']+1)/2;
				$nextMatch['Match']['player1_id'] = $playerId;
			} else {
				$nextMatch['Match']['column'] = $matchInfo['column']/2;
				$nextMatch['Match']['player2_id'] = $playerId;
			}
		} else {
			$nextMatch['Match']['type'] = 'LD'	;
			$nextMatch['Match']['round'] = $matchInfo['round'];
			$nextMatch['Match']['column'] = $matchInfo['column'];
			$nextMatch['Match']['player2_id'] = $playerId;
		}
		$nextMatch['Match']['tournament_id'] = $tournament_id;
#		$nextMatch['Match']['completed'] = date('Y-m-d h:i:s');
				
		$test = $this->find('first', array(
			'conditions' => array(
				'Match.tournament_id' => $nextMatch['Match']['tournament_id'],
				'Match.round' => $nextMatch['Match']['round'],
				'Match.type' => $nextMatch['Match']['type'],
				'Match.column' => $nextMatch['Match']['column']
			)));
			
		if ($test) {
			$record = $nextMatch + $test;
			$this->save($record);
			return $record;
		} else {
			$this->save($nextMatch);
			return $nextMatch;
		}
	}

/*
Gonna rewrite all these functions so that they can be passed matches directly and figure out what to do with them.
The ideal solution is to get a match from the view, feed it to whatever functions need to handle the results, and
then make a call to activeMatches() to see if anything new is ready. That makes concurrency a snap, which will 
help with larger tournaments.
*/

 

	public function promoteWinner ($tournament_id, $matchInfo, $playerId) {
		if ( $matchInfo['round'] = 1 ) {
			$nextMatch['Match']['type'] = 'GF';
		} else {
			$nextMatch['Match']['type'] = 'WI';
		}
		$nextMatch['Match']['round'] = $matchInfo['round'] - 1;
		if ($matchInfo['column'] % 2 == 1) {
			$nextMatch['Match']['column'] = ($matchInfo['column']+1)/2;
			$nextMatch['Match']['player1_id'] = $playerId;
		} else {
			$nextMatch['Match']['column'] = $matchInfo['column']/2;
			$nextMatch['Match']['player2_id'] = $playerId;
		}
		$nextMatch['Match']['tournament_id'] = $tournament_id;
		
		$test = $this->find('first', array(
			'conditions' => array(
				'Match.tournament_id' => $nextMatch['Match']['tournament_id'],
				'Match.round' => $nextMatch['Match']['round'],
				'Match.type' => $nextMatch['Match']['type'],
				'Match.column' => $nextMatch['Match']['column']
			)));
			
		if ($test) {
			$record = $nextMatch + $test;
			$this->save($record);
			return $record;
		} else {
			$this->save($nextMatch);
			return $nextMatch;
		}
	}
	
	public function promoteLoser ($tournament_id, $order, $matchInfo, $playerId) {
		$nextMatch['Match']['tournament_id'] = $tournament_id;
		if ( $matchInfo['round'] == 1 && $matchInfo['type'] = 'LD') {
			$nextMatch['Match']['type'] = 'GF';
			$nextMatch['Match']['round'] = 0;
			$nextMatch['Match']['column'] = 1;
			$nextMatch['Match']['player2_id'] = $playerId;
		} elseif ($matchInfo['type'] == 'LD') {
			$nextMatch['Match']['type'] = 'LV';
			$nextMatch['Match']['round'] = $matchInfo['round'] - 1;
			if ($matchInfo['column'] % 2 == 1) {
				$nextMatch['Match']['column'] = ($matchInfo['column']+1)/2;
				$nextMatch['Match']['player1_id'] = $playerId;
			} else {
				$nextMatch['Match']['column'] = $matchInfo['column']/2;
				$nextMatch['Match']['player2_id'] = $playerId;
			}
		} else {
			$nextMatch['type'] = 'LD';
			$nextMatch['round'] = $matchInfo['round'];
			$nextMatch['column'] = $matchInfo['column'];
			$nextMatch['player1_id'] = $playerId;
		}
		
		$nextMatch['Match']['tournament_id'] = $tournament_id;
		
		$test = $this->find('first', array(
			'conditions' => array(
				'Match.tournament_id' => $nextMatch['Match']['tournament_id'],
				'Match.round' => $nextMatch['Match']['round'],
				'Match.type' => $nextMatch['Match']['type'],
				'Match.column' => $nextMatch['Match']['column']
			)));
			
		if ($test) {
			$record = $nextMatch + $test;
			$this->save($record);
			return $record;
		} else {
			$this->save($nextMatch);
			return $nextMatch;
		}
	}
	
	public function getActiveMatches ($tournament_id) {
		$result = $this->find('all', array(
			'Match.player1_id IS NOT NULL',
			'Match.player2_id IS NOT NULL',
			'Match.result IS NULL'
			));
		return $result;
	}
			
}
