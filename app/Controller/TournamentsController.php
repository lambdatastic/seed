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
				$this->Session->setFlash(__('The tournament has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tournament could not be saved. Please, try again.'));
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
	
	public function start() {


		# Need something here to check if a tourney has already started, and redirect to run() if yes

		debug($this->request);
		$seeds = $this->Tournament->Registration->find('all', array(
			'conditions' => array('Registration.tournament_id' => $this->request->params['pass'][0]),
			'order' => array('Registration.rating DESC', 'Registration.rd ASC')
		));
		debug($seeds);
		$torder = $this->Tournament->findOrder(count($seeds));
		
		$initialMatches = $this->Tournament->initMatches($torder, $seeds, $this->request->params['pass']['0']);		
		debug($initialMatches);
		
#		$startingMatches = $this->
		
		if ($this->Tournament->Match->saveMany($initialMatches)) {
			$this->Session->setFlash(__('Starting matches saved'));
			$this->setAction('run');
#			$this->redirect(array('action' => 'run'));         #Does not work, though I think it should
		} else {
			$this->Session->setFlash(__('Failed to start'));
			debug($this->Tournament->Match->validationErrors);
		}
	}
	
	public function run($id = null) {
		debug($initialMatches);
	}
}
