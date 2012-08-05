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
			$this->Registration->create();

			$game = $this->Registration->Tournament->field('game', array('id' => $this->request->data['Registration']['tournament_id'] ));

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
				$this->Ranking->save($newRank);
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
			
			if ($this->Registration->save($this->request->data)) {
				$this->Session->setFlash(__('The registration has been saved'));
#				$this->redirect(array('controller' => 'events', 'action' => 'view', $this->request->query['event']));
			} else {
				$this->Session->setFlash(__('The registration could not be saved. Please, try again.'));
			}
		}
		$users = $this->Registration->User->find('list', array(
			'order' => 'User.name ASC'
		));
		if($this->request->query['event']) {	
			$tournaments	= $this->Registration->Tournament->find('list', array(
				'conditions' => array('Tournament.event_id' => $this->request->query['event'])
			));
		} else {
			$this->Session->setFlash(__('No event set, please navigate to from an event sidebar.'));
			$this->redirect(array('controller' => 'events', 'action' => 'index'));
		}
		$this->set(compact('users', 'tournaments'));
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
		if ($this->Registration->delete()) {
			$this->Session->setFlash(__('Registration deleted'));
			$this->redirect(array('action' => 'index'));
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
