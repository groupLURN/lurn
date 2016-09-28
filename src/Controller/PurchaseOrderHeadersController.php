<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
* PurchaseOrderHeaders Controller
*
* @property \App\Model\Table\PurchaseOrderHeadersTable $PurchaseOrderHeaders
*/
class PurchaseOrderHeadersController extends AppController
{

/**
* Index method
*
* @return \Cake\Network\Response|null
*/
public function index()
{
	$this->paginate = [
	'contain' => ['Projects', 'Suppliers']
	];

	$this->paginate += $this->createFinders($this->request->query);
	$purchaseOrderHeaders = $this->paginate($this->PurchaseOrderHeaders);
	$projects = TableRegistry::get('Projects')->find('list')->toArray();
	$suppliers = TableRegistry::get('Suppliers')->find('list')->toArray();

	$this->set(compact('purchaseOrderHeaders', 'projects', 'suppliers'));
	$this->set($this->request->query);
	$this->set('_serialize', ['purchaseOrderHeaders', 'projects', 'suppliers']);
}

/**
* View method
*
* @param string|null $id Purchase Order Header id.
* @return \Cake\Network\Response|null
* @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
*/
public function view($id = null)
{
	$purchaseOrderHeader = $this->PurchaseOrderHeaders->get($id, [
		'contain' => ['Projects', 'Suppliers', 'PurchaseOrderDetails' => ['Materials', 'PurchaseReceiveDetails']]
		]);

	$this->PurchaseOrderHeaders->computeQuantityRemaining($purchaseOrderHeader);
	$this->set('purchaseOrderHeader', $purchaseOrderHeader);
	$this->set('_serialize', ['purchaseOrderHeader']);
}

/**
* Add method
*
* @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
*/
public function add()
{
	$this->loadModel('Projects');
	$this->loadModel('Milestones');
	$this->loadModel('Tasks');
	$this->loadModel('Suppliers');
	$this->loadModel('Materials');

	$purchaseOrderHeader = $this->PurchaseOrderHeaders->newEntity();

	if ($this->request->is('post')) {
		$this->transpose($this->request->data, 'purchase_order_details');
		$purchaseOrderHeader = $this->PurchaseOrderHeaders->patchEntity($purchaseOrderHeader, $this->request->data, [
			'associated' => ['PurchaseOrderDetails']
			]);
		if ($this->PurchaseOrderHeaders->save($purchaseOrderHeader)) {
			$this->Flash->success(__('The purchase order number ' . $purchaseOrderHeader->number . ' has been saved.'));
			return $this->redirect(['action' => 'index']);
		} else {
			$this->Flash->error(__('The purchase order header could not be saved. Please, try again.'));
		}
	}

	$projects 		= $this->Projects->find('list')->toArray();
	$milestones 	= $this->Milestones->find('list')->toArray();
	$tasks 			= $this->Tasks->find('list')->toArray();
	$suppliers 		= $this->Suppliers->find('list')->toArray();
	$materials 		= $this->Materials->find('list')->toArray();
	$this->set(compact('purchaseOrderHeader', 'projects', 'milestones', 'tasks', 'suppliers', 'materials'));
	$this->set('_serialize', ['purchaseOrderHeader', 'projects', 'suppliers', 'materials']);
}

/**
* Edit method
*
* @param string|null $id Purchase Order Header id.
* @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
* @throws \Cake\Network\Exception\NotFoundException When record not found.
*/
public function edit($id = null)
{
	$purchaseOrderHeader = $this->PurchaseOrderHeaders->get($id, [
		'contain' => []
		]);
	if ($this->request->is(['patch', 'post', 'put'])) {
		$purchaseOrderHeader = $this->PurchaseOrderHeaders->patchEntity($purchaseOrderHeader, $this->request->data);
		if ($this->PurchaseOrderHeaders->save($purchaseOrderHeader)) {
			$this->Flash->success(__('The purchase order header has been saved.'));
			return $this->redirect(['action' => 'index']);
		} else {
			$this->Flash->error(__('The purchase order header could not be saved. Please, try again.'));
		}
	}
	$projects = $this->PurchaseOrderHeaders->Projects->find('list', ['limit' => 200]);
	$suppliers = $this->PurchaseOrderHeaders->Suppliers->find('list', ['limit' => 200]);
	$this->set(compact('purchaseOrderHeader', 'projects', 'suppliers'));
	$this->set('_serialize', ['purchaseOrderHeader']);
}

/**
* Delete method
*
* @param string|null $id Purchase Order Header id.
* @return \Cake\Network\Response|null Redirects to index.
* @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
*/
public function delete($id = null)
{
	$this->request->allowMethod(['post', 'delete']);
	$purchaseOrderHeader = $this->PurchaseOrderHeaders->get($id);
	if ($this->PurchaseOrderHeaders->delete($purchaseOrderHeader)) {
		$this->Flash->success(__('The purchase order header has been deleted.'));
	} else {
		$this->Flash->error(__('The purchase order header could not be deleted. Please, try again.'));
	}
	return $this->redirect(['action' => 'index']);
} 

// public function getFilteredSuppliers() {
// 	$this->loadModel('Suppliers');

// 	$suppliers 	= array();



// 	$project 	= $this->request->query('project_id');
// 	$milestone	= $this->request->query('milestone_id');
// 	$task		= $this->request->query('task_id');

// 	if (isset($project)) {
// 		$suppliers = $this->Suppliers->find('list', ['limit' => 200]);
// 	}

// 	header('Content-Type: application/json');
// 	echo json_encode($suppliers);
// 	exit();
// }	

/**
* Method for getting milestones from the database
*
* @return json response
*/
public function getMilestones() {
	$this->loadModel('Milestones');
	$milestones 	= array();
	$project_id 	= $this->request->query('project_id');

	if ($project_id) {
		$milestones = $this->Milestones->find('byProjectId', ['project_id' => $project_id]);
	}

	header('Content-Type: application/json');
	echo json_encode($milestones);
	exit();
}	

/**
* Method for getting tasks from the database
*
* @return json response
*/
public function getTasks() {
	$this->loadModel('Tasks');
	$tasks 	= array();

	$project_id 	= $this->request->query('project_id');
	$milestone_id 	= $this->request->query('milestone_id');

	if ($project_id !== null && $milestone_id !== null) {
		$tasks = $this->Tasks->find('byProjectAndMilestone', ['project_id' => $project_id, 'milestone_id' => $milestone_id]);

	} else  if ($project_id !== null) {
		$tasks = $this->Tasks->find('byProject', ['project_id' => $project_id]);
	} 


	header('Content-Type: application/json');
	echo json_encode($tasks);
	exit();
}	

/**
* Method for getting suppliers from the database
*
* @return json response
*/
public function getSuppliers() {
	$this->loadModel('MaterialsTasks');
	$this->loadModel('Suppliers');
	$this->loadModel('Tasks');

	$suppliers 	= array();
	$materials  = array();

	$project_id 	= $this->request->query('project_id');
	$milestone_id 	= $this->request->query('milestone_id');
	$task_id 		= $this->request->query('task_id');

	if ($task_id !== null) {
		$suppliers_holder = array();

		$materials = $this->MaterialsTasks->find('byTask', ['task_id' => $task_id])->toArray();

		foreach ($materials as $key => $value) {
			foreach ($this->Suppliers->find('byMaterial', ['material_id' => $value['material_id']]) as $row) {
				array_push($suppliers_holder, $row);
			}
		}

		$suppliers = array_unique($suppliers_holder);


	} else if ($milestone_id !== null && $project_id !== null) {
		$suppliers_holder 	= array();
		$materials_holder 	= array();
		$tasks 				= array();
		$task_ids 			= array();

		$tasks = $this->Tasks->find('byProjectAndMilestone', ['project_id' => $project_id, 'milestone_id' => $milestone_id]);;

		foreach ($tasks as $row) {
				array_push($task_ids, $row['id']);
		}

		$task_ids = array_unique($task_ids);


		foreach ($task_ids as $key => $value) {

		$task_id = (float)$value;
				
			debug( $this->MaterialsTasks->find('byTask', ['task_id' => $task_id]) );
			foreach ( $this->MaterialsTasks->find('byTask', ['task_id' => $task_id]) as $row) {
			debug($task_id);
				array_push($materials_holder, $row);
			}
		}

		$materials = array_unique($materials_holder);

		foreach ($materials as $key => $value) {
			foreach ($this->Suppliers->find('byMaterial', ['material_id' => $value['material_id']]) as $row) {
				array_push($suppliers_holder, $row);
			}
		}

		$suppliers = array_unique($suppliers_holder);

	} else  if ($project_id !== null) {
		$suppliers_holder = array();
	} 

	


	// header('Content-Type: application/json');
	// echo json_encode($suppliers);
	exit();
}	



}
