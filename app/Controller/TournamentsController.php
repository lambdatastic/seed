<?php
App::uses('AppController', 'Controller');
/**
 * Tournaments Controller
 *
 * @property Tournament $Tournament
 */
class TournamentsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tournament->recursive = 0;
		$this->set('tournaments', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Tournament->id = $id;
		if (!$this->Tournament->exists()) {
			throw new NotFoundException(__('Invalid tournament'));
		}
		$this->set('tournament', $this->Tournament->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tournament->create();
			if ($this->Tournament->save($this->request->data)) {
				$this->Session->setFlash(__('This tournament has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tournament could not be saved. Please try again'));
			}
		}
		if($this->request->query['event']) {	
			$events	= $this->Tournament->Event->find('list', array(
				'conditions' => array('Event.id' => $this->request->query['event'])
			));
		} else {
			$events = $this->Tournament->Event->find('list');
		}
		$this->set(compact('events'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Tournament->id = $id;
		if (!$this->Tournament->exists()) {
			throw new NotFoundException(__('Invalid tournament'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tournament->save($this->request->data)) {
				$this->Session->setFlash(__('The tournament has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tournament could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Tournament->read(null, $id);
		}
		$events = $this->Tournament->Event->find('list');
		$this->set(compact('events'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Tournament->id = $id;
		if (!$this->Tournament->exists()) {
			throw new NotFoundException(__('Invalid tournament'));
		}
		if ($this->Tournament->delete()) {
			$this->Session->setFlash(__('Tournament deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tournament was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function start($id = null) {
		$this->Tournament->id = $id;
		
		if ($this->Tournament->Match->find('first', array('conditions' => array('Match.tournament_id' => $this->Tournament->id)))) {
			$this->redirect(array('action' => 'run', $this->Tournament->id));
		}
		# Need something here to check if a tourney has already started, and redirect to run() if yes

		$seeds = $this->Tournament->Registration->find('all', array(
			'recursive' => 0,
			'conditions' => array('Registration.tournament_id' => $this->Tournament->id),
			'order' => array('Registration.rating DESC', 'Registration.rd ASC')
		));
		debug($seeds);
		$torder = $this->Tournament->findOrder(count($seeds));
		
		$initialMatches = $this->Tournament->initMatchesTrue($torder, $seeds);		
		
				
		foreach ($initialMatches as $iMatch) {
			#debug($iMatch);
			if ($iMatch['player2_id'] == null) {
				$this->Tournament->Match->promoteWinner($iMatch);
 				$this->Tournament->Match->moveToLosers($iMatch, $torder);
			}
		}
		
		$nullLosers = $this->Tournament->Match->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'Match.player1_id IS NULL',
				'Match.player2_id IS NULL',
				'Match.result IS NULL',
				'Match.type' => 'LV',
				'Match.tournament_id' => $this->Tournament->id
			)
		));
		
		foreach($nullLosers as $nMatch) {
			$nMatch['Match']['result'] = 'P1';
			$nMatch['Match']['completed'] = date('Y-m-d H:i:s');
			$this->Tournament->Match->save($nMatch);
			$this->Tournament->Match->promoteLoser($this->Tournament->Match->convertToFlat($nMatch));
		}
		
		/* This is the worst type of hack, need to figure out why promoteWinner() will zero out empty slots
			while promoteLoser will make them NULL. Standard is 0 for empty, NULL for a bye FIXED: set 0 default in DB 
		
		$fixMe = $this->Tournament->Match->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'Match.Player1_id IS NULL',
				'Match.Player2_id IS NULL',
				'Match.tournament_id' => $this->Tournament->id,
				'Match.type' => 'LD'
			)
		));
		debug($fixMe);
		foreach ($fixMe as $fMatch) {
			$fMatch['Match']['player1_id'] = (int)'0';
			$this->Tournament->Match->save($nMatch);
		}
		*/
		if ($this->Tournament->Match->saveMany($initialMatches)) {
			$this->Session->setFlash(__('Starting matches saved'));
			$this->setAction('run');
			#$this->redirect(array('action' => 'run'));         #Does not work, though I think it should
		} else {
			$this->Session->setFlash(__('Failed to start'));
			debug($this->Tournament->Match->validationErrors);
		}
	}

	public function run($id = null) {
		$this->Tournament->id = $id;
		#debug($this->request);
		
		if ($this->request->is('post')) {
			$fMatch['Match'] = $this->request->data['Match'];
			if(isset($this->request->data['P1'])) {
				$fMatch['Match']['result'] = 'P1';
			} else {
				$fMatch['Match']['result'] = 'P2';
			}
			$fMatch['Match']['completed'] = date('Y-m-d H:i:s');
			
			if($this->Tournament->Match->save($fMatch)) {
				$this->Session->setFlash(__('Saved match'));
			} else {
				$this->Session->setFlash(__('Failed to save'));
			}
			
			$fMatch = $this->Tournament->Match->read(null, $fMatch['Match']['id']);
			#debug($fMatch);
						
			
			$seeds = $this->Tournament->Registration->find('all', array(
				'recursive' => -1,
				'conditions' => array('Registration.tournament_id' => $this->Tournament->id),
				'order' => array('Registration.rating DESC', 'Registration.rd ASC')
			));
		
			$torder = $this->Tournament->findOrder(count($seeds));
			
			if($fMatch['Match']['type'] == 'WI') {
				$this->Tournament->Match->moveToLosers($fMatch['Match'], $torder);
				$this->Tournament->Match->promoteWinner($fMatch['Match']);
			} elseif($fMatch['Match']['type'] == 'LD' || $fMatch['Match']['type'] == 'LV') {
				$this->Tournament->Match->promoteLoser($fMatch['Match']);
			} else {
				$this->redirect(array('action' => 'end', $this->Tournament->id));
			}
			
			$dMatches = $this->Tournament->Match->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'Match.result' => null,
					'Match.tournament_id' => $this->Tournament->id,
					'OR' => array(
						'AND' => array('Match.player1_id >' => 0, 'Match.player2_id' => null),
						'AND' => array('Match.player1_id' => null, 'Match.player2_id >' => 0)
					)
				)
			));
			
			#debug($dMatches);
			
			foreach ($dMatches as $dMatch) {
				if ($dMatch['Match']['player1_id'] === null) {
					$dMatch['Match']['result'] = 'P2';
				} else {
					$dMatch['Match']['result'] = 'P1';
				}
				$dMatch['Match']['completed'] = date('Y-m-d H:i:s');
				$this->Tournament->Match->save($dMatch);
				$this->Tournament->Match->promoteLoser($dMatch['Match']);
			}
		}
		
		$currentMatches = $this->Tournament->Match->getActiveMatches($this->Tournament->id);
		#debug($currentMatches);
		
		
		$this->set(compact('currentMatches'));
	}
	
	public function test ($id = null) {
		$this->Tournament->id = $id;
		
		$seeds = $this->Tournament->Registration->find('all', array(
			'recursive' => 0,
			'conditions' => array('Registration.tournament_id' => $this->Tournament->id),
			'order' => array('Registration.rating DESC', 'Registration.rd ASC')
		));
		debug($seeds);
		$torder = $this->Tournament->findOrder(count($seeds));
		
		$initialMatches = $this->Tournament->initMatchesTrue($torder, $seeds);
		
		debug($initialMatches);
		
	
		$options['joins'] = array(
		array( 'table' => 'matches',
			'alias' => 'Match',
			'type' => 'INNER',
			'conditions' => array(
				'Match.completed >' => date('Y-m-d h:i:s', strtotime('-1 week')),
				'Match.tournament_id' => 'Tournament.id',
				'Match.player1_id IS NOT NULL',
				'Match.player2_id IS NOT NULL',
				'OR' => array(
					'Match.player1_id' => 'Ranking.user_id',
					'Match.player2_id' => 'Ranking.user_id'
				))
		),
		array( 'table' => 'tournaments',
			'alias' => 'Tournament',
			'type' => 'INNER',
			'conditions' => array(
				'Tournament.game' => 'Ranking.game'
			)
		));
		
		$this->Ranking->recursive = -1;
		$test = $this->Ranking->find('all', $options);
		debug($test);
	}
}
