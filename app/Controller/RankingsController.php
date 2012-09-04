<?php
App::uses('AppController', 'Controller');
/**
 * Rankings Controller
 *
 * @property Ranking $Ranking
 */
class RankingsController extends AppController {

	public $paginate = array(
		'order' => array(
			'Ranking.rating' => 'desc'
		)
	);


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('leaderboard');
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Ranking->recursive = 0;
		$this->set('rankings', $this->paginate());

		$glist = $this->Ranking->find('list', array('fields' => array('Ranking.game')));
		$games = array_unique($glist);
		$this->set(compact('games'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Ranking->id = $id;
		if (!$this->Ranking->exists()) {
			throw new NotFoundException(__('Invalid ranking'));
		}
		$this->set('ranking', $this->Ranking->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ranking->create();
			if ($this->Ranking->save($this->request->data)) {
				$this->Session->setFlash(__('The ranking has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ranking could not be saved. Please, try again.'));
			}
		}
		$users = $this->Ranking->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Ranking->id = $id;
		if (!$this->Ranking->exists()) {
			throw new NotFoundException(__('Invalid ranking'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ranking->save($this->request->data)) {
				$this->Session->setFlash(__('The ranking has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ranking could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Ranking->read(null, $id);
		}
		$users = $this->Ranking->User->find('list');
		$this->set(compact('users'));
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
		$this->Ranking->id = $id;
		if (!$this->Ranking->exists()) {
			throw new NotFoundException(__('Invalid ranking'));
		}
		if ($this->Ranking->delete()) {
			$this->Session->setFlash(__('Ranking deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ranking was not deleted'));
		$this->redirect(array('action' => 'index'));
	}


	public function leaderboard($game = null) {
		if ($this->request->query['game']) {
			$leaders = $this->paginate('Ranking', array('Ranking.game =' => $this->request->query['game']));
			$this->set('leaders', $leaders);
		} else {
			$this->redirect(array('action' => 'index'));
		};
	}
	
	public function test ($id = null) {
			
		$options['joins'] = array(
		array( 'table' => 'matches',
			'alias' => 'Match',
			'type' => 'INNER',
			'conditions' => array(
				//'Match.completed >' => date('Y-m-d h:i:s', strtotime('-1 week')),
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
