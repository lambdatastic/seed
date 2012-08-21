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
	public function beforeSave($options) {
		if(empty($this->data['Match']['completed']) && !empty($this->data['Match']['result'])) {
			$this->data['Match']['completed'] = date('Y-m-d H:i:s');
		}
	}

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
		)
/*		'result' => array(
			'alphaNumeric' => array(
				'rule' => array('alphaNumeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'completed' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
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
 
 	public function convertToFlat($matchInfo) {
 		
 		$convert['tournament_id'] = $matchInfo['Match']['tournament_id'];
 		$convert['type'] = $matchInfo['Match']['type'];
 		$convert['round'] = $matchInfo['Match']['round'];
 		$convert['column'] = $matchInfo['Match']['column'];
 		$convert['player1_id'] = $matchInfo['Match']['player1_id'];
 		$convert['player2_id'] = $matchInfo['Match']['player2_id'];
 		$convert['result'] = $matchInfo['Match']['result'];
 		$convert['completed'] = $matchInfo['Match']['completed'];

		return $convert;
 		
 	}

	public function moveToLosers ($matchInfo, $order) {
		
		if ($matchInfo['result'] == 'P1') {
			$playerId = $matchInfo['player2_id'];
		} else {
			$playerId = $matchInfo['player1_id'];
		}
		
		if ($matchInfo['round'] == $order) {
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
		$nextMatch['Match']['tournament_id'] = $matchInfo['tournament_id'];
#		$nextMatch['Match']['completed'] = date('Y-m-d h:i:s');
				
		$test = $this->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'Match.tournament_id' => $nextMatch['Match']['tournament_id'],
				'Match.round' => $nextMatch['Match']['round'],
				'Match.type' => $nextMatch['Match']['type'],
				'Match.column' => $nextMatch['Match']['column']
			)));
		#debug($test);
		
			
		if ($test) {
			$record['Match'] = array_merge($test['Match'], $nextMatch['Match']);
			#debug($record);
			$this->id =$record['Match']['id'];
			$this->save($record);
			return $record;
		} else {
			$this->create();			
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

 

	public function promoteWinner ($matchInfo) {
		if ($matchInfo['result'] == 'P1') {
			$playerId = $matchInfo['player1_id'];
		} else {
			$playerId = $matchInfo['player2_id'];
		}
		
		if ( $matchInfo['round'] == 1 ) {
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
		$nextMatch['Match']['tournament_id'] = $matchInfo['tournament_id'];
		
		$test = $this->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'Match.tournament_id' => $nextMatch['Match']['tournament_id'],
				'Match.round' => $nextMatch['Match']['round'],
				'Match.type' => $nextMatch['Match']['type'],
				'Match.column' => $nextMatch['Match']['column']
			)));
		#debug($test);	
			
		if ($test) {
			$record['Match'] = array_merge($test['Match'], $nextMatch['Match']);
			#debug($record);
			$this->id =$record['Match']['id'];
			$this->save($record);
			return $record;
		} else {
			$this->create();			
			$this->save($nextMatch);
			return $nextMatch;
		}
	}
	
	public function promoteLoser ($matchInfo) {
		
		if ($matchInfo['result'] == 'P1') {
			$playerId = $matchInfo['player1_id'];
		} else {
			$playerId = $matchInfo['player2_id'];
		}

		if ( $matchInfo['round'] == 1 && $matchInfo['type'] == 'LD') {
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
			$nextMatch['Match']['type'] = 'LD';
			$nextMatch['Match']['round'] = $matchInfo['round'];
			$nextMatch['Match']['column'] = $matchInfo['column'];
			$nextMatch['Match']['player1_id'] = $playerId;
		}
		
		$nextMatch['Match']['tournament_id'] = $matchInfo['tournament_id'];
		
		$test = $this->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'Match.tournament_id' => $nextMatch['Match']['tournament_id'],
				'Match.round' => $nextMatch['Match']['round'],
				'Match.type' => $nextMatch['Match']['type'],
				'Match.column' => $nextMatch['Match']['column']
			)));
			
		if ($test) {
			$record['Match'] = array_merge($test['Match'], $nextMatch['Match']);
			#debug($record);
			$this->id =$record['Match']['id'];
			$this->save($record);
			return $record;
		} else {
			$this->create();
			$this->save($nextMatch);
			return $nextMatch;
		}
	}
	
	public function getActiveMatches ($tournament_id) {
		$result = $this->find('all', array(
			'recursive' => 0,
			'conditions' => array(
				'Match.tournament_id' => $tournament_id,
				'Match.result IS NULL',
				'Match.player1_id >' => 0,
				'Match.player2_id >' => 0
			)
		));
		return $result;
	}
			
}
