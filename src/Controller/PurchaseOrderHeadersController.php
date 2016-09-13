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
}
