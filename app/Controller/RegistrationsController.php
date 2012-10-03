<?php
App::uses('AppController', 'Controller');
/**
 * Registrations Controller
 *
 * @property Registration $Registration
 */
class RegistrationsController extends AppController {
	 
/*
	public function isAuthorized($user) {

		if (in_array($this->action, array('add'))) {
			$this->loadModel('Event');	
			if ($user['id'] === $this->Event->field('user_id', array('id' => $this->request->params['event'] ))) {
				return true;
			}
		};	
		
		return parent::isAuthorized($user);
	}
*/

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Registration->recursive = 0;
		$this->set('registrations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Registration->id = $id;
		if (!$this->Registration->exists()) {
			throw new NotFoundException(__('Invalid registration'));
		}
		$this->set('registration', $this->Registration->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			#debug($this->request);
			
			if ($this->request->data['Registration']['user_link']) {
				$pattern = '/[0-9]+$/';
				preg_match($pattern, $this->request->data['Registration']['user_link'], $uid);
				$upin = $this->Registration->User->field('pin', array('id' => $uid[0]));
				$pc = AuthComponent::password($this->request->data['Registration']['user_pin']);
				if ($pc == $upin) {
					$this->request->data['Registration']['user_id'] = $uid[0];
					debug($uid[0]);
					debug($this->request->data['Registration']['user_id']);
				}
			}

			$user = $this->Registration->User->field('name', array('id' => $this->request->data['Registration']['user_id']));

			foreach ($this->request->data['Registration']['tournament_id'] as $tournament_id) {

			$game = $this->Registration->Tournament->field('game', array('id' => $tournament_id ));
			$this->Registration->create();
			$this->loadModel('Ranking');
			if(!$this->Ranking->field('rating', array(
				'game' => $game,
				'user_id' =>  $this->request->data['Registration']['user_id']
			))) {
				$newRank = null;
				$newRank['Ranking']['user_id'] = $this->request->data['Registration']['user_id'];
				$newRank['Ranking']['rating'] = 1500;
				$newRank['Ranking']['rd'] = 350;
				$newRank['Ranking']['game'] = $game;
				$this->request->data['Registration']['rating'] = $newRank['Ranking']['rating'];
				$this->request->data['Registration']['rd'] = $newRank['Ranking']['rd'];
				$this->Ranking->create();
				$this->Ranking->save($newRank);
				#debug($this->Ranking->validationErrors);
			} else {			
				$this->request->data['Registration']['rating'] = $this->Ranking->field('rating', array(
					'game' => $game,
					'user_id' =>  $this->request->data['Registration']['user_id']
				));
				$this->request->data['Registration']['rd'] = $this->Ranking->field('rd', array(
					'game' => $game,
					'user_id' =>  $this->request->data['Registration']['user_id']
				));
			}
			
			$newReg['Registration'] = $this->request->data['Registration'];
			$newReg['Registration']['tournament_id'] = $tournament_id;

			if ($this->Registration->save($newReg)) {
				$this->Session->setFlash(__($user . ' has been registered.'));
				#$this->redirect(array('action' => 'add', '?' => array(
				#	'event' => $this->request->query['event']
				# )));
			} else {
				$this->Session->setFlash(__('The registration could not be saved. Please, try again.'));
			}
			}
		}
		$users = $this->Registration->User->find('list', array(
			'order' => 'User.name ASC'
		));
		if($this->request->query['event']) {	
			$tournaments	= $this->Registration->Tournament->find('list', array(
				'conditions' => array('Tournament.event_id' => $this->request->query['event'])
			));
			$tlist = $this->Registration->Tournament->find('all', array(
				'conditions' => array('Tournament.event_id' => $this->request->query['event']),
				'recursive' => -1
			));
			$registrations = array();
			foreach ($tlist as $t):
				$regs = $this->Registration->find('all', array(
					'conditions' => array('Registration.tournament_id' => $t['Tournament']['id']),
					'contain' => 'User.name'
				));
				array_push($registrations, $regs);
			endforeach;
		} else {
			$this->Session->setFlash(__('No event set, please navigate to from an event sidebar.'));
			$this->redirect(array('controller' => 'events', 'action' => 'index'));
		}
		debug($tlist);
		$this->set(compact('users', 'tournaments', 'registrations', 'tlist'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Registration->id = $id;
		if (!$this->Registration->exists()) {
			throw new NotFoundException(__('Invalid registration'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Registration->save($this->request->data)) {
				$this->Session->setFlash(__('The registration has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The registration could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Registration->read(null, $id);
		}
		$users = $this->Registration->User->find('list');
		$tournaments = $this->Registration->Tournament->find('list');
		$this->set(compact('users', 'tournaments'));
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
		$this->Registration->id = $id;
		if (!$this->Registration->exists()) {
			throw new NotFoundException(__('Invalid registration'));
		}
		/* $t = $this->Registration->field('tournament_id'); */
		$e = $this->Registration->Tournament->field('event_id', array('id' => $this->Registration->field('tournament_id')));
		if ($this->Registration->delete()) {
			$this->Session->setFlash(__('Registration deleted'));
			$this->redirect(array('action' => 'add', '?' => array('event' => $e)));
		}
		$this->Session->setFlash(__('Registration was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
/*
	public function list() {
		$tournaments = $this->Registration->Tournament->find('list', array(
			'conditions' => array('Tournament.event_id' => $this->request->query['event'])
		));
		for 
		$this->Registration->recursive = 0;
		$this->set('registrations', $this->paginate());
	}
*/

	public function seeds() {
		$tournament = $this->request->query['event'];
		$this->paginate = array(
			'conditions' => array('Registration.tournament_id' => $tournament),
			'order' => 'Registration.rating DESC'
		);
		$registrations = $this->paginate('Registration');
		$this->set('registrations', $registrations);
	}
}
