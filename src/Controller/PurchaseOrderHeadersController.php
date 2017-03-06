<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

/**
* PurchaseOrderHeaders Controller
*
* @property \App\Model\Table\PurchaseOrderHeadersTable $PurchaseOrderHeaders
*/
class PurchaseOrderHeadersController extends AppController
{
    public function isAuthorized($user)
    {        
        $action = $this->request->params['action'];
        $employeeTypeId = isset($user['employee']['employee_type_id'])
            ? $user['employee']['employee_type_id'] : '';

        if ($action === 'view') {
            return in_array($employeeTypeId, [0, 2, 4], true);
        }
        
        return in_array($employeeTypeId, [0, 2], true);
    }
    
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
		$purchaseOrderHeader = $this->PurchaseOrderHeaders->find('byId', ['id' => $id])->first();

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
			$postData = $this->request->data;
			$count = count($postData['purchase_order_details']['quantity']);

			for ($i = 0; $i < $count; $i++) {
				if($postData['purchase_order_details']['quantity'][$i] == 0
	                || $postData['purchase_order_details']['quantity'][$i] == ''){
					unset($postData['purchase_order_details']['material_id'][$i]);
					unset($postData['purchase_order_details']['quantity'][$i]);
				}
			}

	        $count = count($postData['purchase_order_details']['material_id']);

			if ($count === 0) {
				$this->Flash->error(__('Please enter at least 1 purchase order detail.'));
				return $this->redirect(['action' => 'add']);
			}

	        foreach ($postData['purchase_order_details']['material_id'] as $key => $value) {  
	            if ( $postData['purchase_order_details']['material_id'][$key] < 0
	                || $postData['purchase_order_details']['material_id'][$key] == '') {

	                $this->Flash->error(__('Invalid material id.'));
	                return $this->redirect(['action' => 'add']);	                
	            }

	            if ( $postData['purchase_order_details']['quantity'][$key] < 1) {

	                $this->Flash->error(__('Quantity must be at least 1.'));
	                return $this->redirect(['action' => 'add']);
	            }
	        }


			$this->transpose($postData , 'purchase_order_details');

			$purchaseOrderHeader = $this->PurchaseOrderHeaders->patchEntity($purchaseOrderHeader, $postData , [
				'associated' => ['PurchaseOrderDetails']
				]);

			if ($this->PurchaseOrderHeaders->save($purchaseOrderHeader)) {
	                $this->loadModel('Notifications');
	                $this->loadModel('Projects');
	                $employees = [];

	                $project = $this->Projects->find('byId', ['project_id' => $purchaseOrderHeader->project_id])->first();

	                array_push($employees, $project->employee);
	                for ($i=0; $i < count($project->employees_join); $i++) { 
	                    $employeeType = $project->employees_join[$i]->employee_type_id;
	                    if($employeeType == 1 || $employeeType == 4) {
	                        array_push($employees, $project->employees_join[$i]);
	                    }
	                }

	                foreach ($employees as $employee) {
	                    $notification = $this->Notifications->newEntity();
	                    $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'purchase-order-headers', 'action' => 'view/'. $purchaseOrderHeader->id ], false));
	                    $notification->link = $link;
	                    $notification->message = '<b>'.$project->title.'</b> has made a purchase order. Click to see the order.';
	                    $notification->user_id = $employee['user_id'];
	                    $notification->project_id = $purchaseOrderHeader->project_id;
	                    $this->Notifications->save($notification);
	                }

				$this->Flash->success(__('The purchase order number ' . $purchaseOrderHeader->number . ' has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The purchase order header could not be saved. Please, try again.'));
			}
		}

		$projects 		= $this->Projects->find('list')->where(['is_finished' => 0])->toArray();
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

		if ($project_id != null && $milestone_id != null) {
			$tasks = $this->Tasks->find('byProjectAndMilestone', ['project_id' => $project_id, 'milestone_id' => $milestone_id]);

		} else  if ($project_id != null) {
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

		if ($task_id != null) {

			$suppliers = $this->Suppliers->find('byTaskAndMaterial', ['task_id' => $task_id]);

		} else if ($project_id != null) {
			$suppliers_holder 	= array();
			$tasks 				= array();
			$task_ids 			= array();

			if($milestone_id != null) {

				$tasks = $this->Tasks->find('byProjectAndMilestone', ['project_id' => $project_id, 'milestone_id' => $milestone_id]);
			} else{

			 	$tasks = $this->Tasks->find('byProject', ['project_id' => $project_id]);
			}

			foreach ($tasks as $row) {
				array_push($task_ids, $row['id']);
			}

			$task_ids = array_unique($task_ids);


			foreach ($task_ids as $key => $value) {

				$task_id = (float)$value;
					
				foreach ( $this->Suppliers->find('byTaskAndMaterial', ['task_id' => $task_id]) as $row) {
					array_push($suppliers_holder, $row);
				}
			}


			$suppliers = array_values(array_unique($suppliers_holder));
		} 

		header('Content-Type: application/json');
		echo json_encode($suppliers);
		exit();
	}

	/**
    * Method for getting materials from the database
    *
    * @return json response
    */
    public function getMaterials() {
        $this->loadModel('Materials');
        $this->loadModel('Tasks');

        $materialsNeeded            = [];
        $taskIds           			= [];

        $project_id     = $this->request->query('project_id');
        $milestone_id   = $this->request->query('milestone_id');
        $task_id        = $this->request->query('task_id');
		$supplier_id	= $this->request->query('supplier_id');

        if ($task_id != null) {
            $taskIds = [$task_id];

        } else if ($project_id != null) {
            $materials_holder   = [];
            $tasks              = [];

            if($milestone_id != null) {
                $tasks = $this->Tasks->find('byProjectAndMilestone', ['project_id' => $project_id, 'milestone_id' => $milestone_id]);
            } else{

                $tasks = $this->Tasks->find('byProject', ['project_id' => $project_id]);
            }

            foreach ($tasks as $row) {
                array_push($taskIds, $row['id']);
            }

            $taskIds = array_unique($taskIds);
        } 

        foreach ($taskIds as $key => $value) {
            $task_id = (float)$value;
            $materialsNeededPerTask = $this->Materials->find('byTaskAndSupplier', ['task_id' => $task_id, 'supplier_id' => $supplier_id]);
                         
            $push = true;

            foreach ($materialsNeededPerTask as $materialsPerTask) {                            
                foreach ($materialsNeeded as $material) {
                    if ($material->id == $materialsPerTask->id) {
                        $material['mt']['quantity'] += $materialsPerTask['mt']['quantity'];
                        $push = false;
                    } 
                }
                
                if (count($materialsNeeded) == 0 || $push) {
                    array_push($materialsNeeded, $materialsPerTask);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($materialsNeeded);
        exit();
    }	
}
