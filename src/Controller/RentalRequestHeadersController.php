<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;

/**
 * RentalRequestHeaders Controller
 *
 * @property \App\Model\Table\RentalRequestHeadersTable $RentalRequestHeaders
 */
class RentalRequestHeadersController extends AppController
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
        $rentalRequestHeaders = $this->paginate($this->RentalRequestHeaders);
        $projects = TableRegistry::get('Projects')->find('list')->toArray();
        $suppliers = TableRegistry::get('Suppliers')->find('list')->toArray();

        $this->set(compact('rentalRequestHeaders', 'projects', 'suppliers'));
        $this->set($this->request->query);
        $this->set('_serialize', ['rentalRequestHeaders', 'projects', 'suppliers']);
    }

    /**
     * View method
     *
     * @param string|null $id Rental Request Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rentalRequestHeader = $this->RentalRequestHeaders->find('byId', ['id' => $id])->first();

        $this->RentalRequestHeaders->computeQuantityRemaining($rentalRequestHeader);
        $this->set('rentalRequestHeader', $rentalRequestHeader);
        $this->set('_serialize', ['rentalRequestHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rentalRequestHeader = $this->RentalRequestHeaders->newEntity();
        if ($this->request->is('post')) {
            $postData = $this->request->data;
            $count = count($postData['rental_request_details_quantity']);
            for ($i = 0; $i < $count; $i++) {
                if($postData['rental_request_details_quantity'][$i] == 0
                    || $postData['rental_request_details_quantity'][$i] == ''){
                    unset($postData['rental_request_details_equipment_id'][$i]);
                    unset($postData['rental_request_details_quantity'][$i]);
                    unset($postData['rental_request_details_duration'][$i]);
                }
            }

            $count = count($postData['rental_request_details_duration']);

            for ($i = 0; $i < $count; $i++) {
                if ( $postData['rental_request_details_quantity'][$i] < 1) {

                    $this->Flash->error(__('Quantity must be at least 1.'));
                    $this->redirect(['action' => 'add']);
                    return;
                }
                if ( $postData['rental_request_details_duration'][$i] < 1
                    || $postData['rental_request_details_duration'][$i] == '') {

                    $this->Flash->error(__('Duration must be at least 1 day and must not be blank.'));
                    $this->redirect(['action' => 'add']);
                    return;
                }
                if ( $postData['rental_request_details_equipment_id'][$i] < 0
                    || $postData['rental_request_details_equipment_id'][$i] == '') {

                    $this->Flash->error(__('Invalid equipment id.'));
                    $this->redirect(['action' => 'add']);
                    return;
                }
            }

            $this->transpose($postData, 'rental_request_details');
            $rentalRequestHeader = $this->RentalRequestHeaders->patchEntity($rentalRequestHeader, $postData, [
                'associated' => ['RentalRequestDetails']
            ]);

            if ($this->RentalRequestHeaders->save($rentalRequestHeader)) {

                $this->loadModel('Notifications');
                $this->loadModel('Projects');
                $employees = [];

                $project = $this->Projects->find('byId', ['project_id' => $rentalRequestHeader->project_id])->first();

                array_push($employees, $project->employee);
                for ($i=0; $i < count($project->employees_join); $i++) { 
                    $employeeType = $project->employees_join[$i]->employee_type_id;
                    if($employeeType == 1 || $employeeType == 4) {
                        array_push($employees, $project->employees_join[$i]);
                    }
                }

                foreach ($employees as $employee) {
                    $notification = $this->Notifications->newEntity();
                    $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'rental-request-headers', 'action' => 'view/'. $rentalRequestHeader->id ], false));
                    $notification->link = $link;
                    $notification->message = '<b>'.$project->title.'</b> has made a rental request. Click to see the request.';
                    $notification->user_id = $employee['user_id'];
                    $notification->project_id = $rentalRequestHeader->project_id;
                    $this->Notifications->save($notification);
                }

                $this->Flash->success(__('The rental request number ' . $rentalRequestHeader->number . ' has been saved.'));
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rental request could not be saved. Please, try again.'));
            }
        }
        $projects = $this->RentalRequestHeaders->Projects->find('list')->where(['is_finished' => 0])->toArray();
        $suppliers = $this->RentalRequestHeaders->Suppliers->find('list', ['limit' => 200]);
        $equipment = TableRegistry::get('Equipment')->find('list', ['limit' => 200])->toArray();
        $this->set(compact('rentalRequestHeader', 'projects', 'suppliers', 'equipment'));
        $this->set('_serialize', ['rentalRequestHeader', 'projects', 'suppliers', 'equipment']);
}

/**
* Method for getting milestones from the database
*
* @return json response
*/
public function getMilestones() {
    $this->loadModel('Milestones');
    $milestones     = array();
    $project_id     = $this->request->query('project_id');

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
    $tasks  = array();

    $project_id     = $this->request->query('project_id');
    $milestone_id   = $this->request->query('milestone_id');

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

    $suppliers  = array();
    $materials  = array();

    $project_id     = $this->request->query('project_id');
    $milestone_id   = $this->request->query('milestone_id');
    $task_id        = $this->request->query('task_id');

    if ($task_id != null) {

        $suppliers = $this->Suppliers->find('byTaskAndEquipment', ['task_id' => $task_id]);

    } else if ($project_id != null) {
        $suppliers_holder   = array();
        $tasks              = array();
        $task_ids           = array();

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
                
            foreach ( $this->Suppliers->find('byTaskAndEquipment', ['task_id' => $task_id]) as $row) {
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
public function getEquipment() {
    $this->loadModel('Equipment');
    $this->loadModel('Tasks');

    $equipment  = array();

    $project_id     = $this->request->query('project_id');
    $milestone_id   = $this->request->query('milestone_id');
    $task_id        = $this->request->query('task_id');
    $supplier_id    = $this->request->query('supplier_id');

    if($supplier_id != null) {
        if ($task_id != null) {

            $equipment = $this->Equipment->find('byTaskAndSupplier', ['task_id' => $task_id, 'supplier_id' => $supplier_id]);

        } else if ($project_id != null) {
            $equipment_holder   = array();
            $tasks              = array();
            $task_ids           = array();

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
                    
                foreach ( $this->Equipment->find('byTaskAndSupplier', ['task_id' => $task_id, 'supplier_id' => $supplier_id]) as $row) {
                    array_push($equipment_holder, $row);
                }
            }

            $equipment = array_values(array_unique($equipment_holder));

        } 
    }

    header('Content-Type: application/json');
    echo json_encode($equipment);
    exit();
}

}
