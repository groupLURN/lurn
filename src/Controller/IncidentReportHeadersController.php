<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;
use DateTime;

/**
 * IncidentReportHeaders Controller
 *
 * @property \App\Model\Table\IncidentReportHeadersTable $IncidentReportHeaders
 */
class IncidentReportHeadersController extends AppController
{

    public function beforeFilter(Event $event)
    {   
        $this->viewBuilder()->layout('default');
        return parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($id = null)
    {
        $this->paginate = [
        'contain' => ['Projects']
        ];

        $incidentReportHeaders = $this->paginate($this->IncidentReportHeaders);

        $this->set(compact('incidentReportHeaders'));
        $this->set('_serialize', ['incidentReportHeaders']);
    }

    /**
     * View method
     *
     * @param string|null $id Incident Report Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {   
        $this->loadComponent('IncidentReport', []);

        $incidentReportHeader = $this->IncidentReport->prepareIncidentReport($id);

        $this->set('incidentReport', $incidentReportHeader);
        $this->set('_serialize', ['incidentReport']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $this->loadModel('Projects');
        $this->loadModel('Tasks');
        $this->loadModel('IncidentReportDetails');

        $incidentReportHeader = $this->IncidentReportHeaders->newEntity();

        if ($this->request->is('post')) {
            $valid = true;
            $postData           = $this->request->data;
            $postData['date']   = new DateTime($postData['date']);

            $project = $this->Projects->get($postData['project_id'], [
                'contain' => ['EmployeesJoin' => [
                'EmployeeTypes'
                ]]
                ]);
            

            foreach($project->employees_join as $employee) {
                if($employee->employee_type->id == 3) {
                    $postData['project_engineer'] = $employee->employee_type->id;            
                }
            }

            $incidentReportHeader = $this->IncidentReportHeaders->patchEntity($incidentReportHeader, $postData);

            if(!isset($postData['involved-id'])) {
                $valid = false;
                $this->Flash->error(__('Please add involved persons.'));
            }


            if($incidentReportHeader->type === 'los') {               
                if(!isset($postData['item-id'])) {
                    $valid = false;
                    $this->Flash->error(__('Please add lost items.'));
                }
            } 

            if($valid) {
                if ($this->IncidentReportHeaders->save($incidentReportHeader)) {
                    $incidentReportDetails = [];
                    $dateNow = new DateTime();

                    $taskDetail     = $this->IncidentReportDetails->newEntity();
                    $taskDetail['incident_report_header_id'] = $incidentReportHeader->id;
                    $taskDetail['type'] = 'task';
                    $taskDetail['value'] = $postData['task'];
                    $taskDetail['created'] = $dateNow;

                    array_push($incidentReportDetails, $taskDetail);

                    $summaryDetail  = $this->IncidentReportDetails->newEntity();
                    $summaryDetail['incident_report_header_id'] = $incidentReportHeader->id;
                    $summaryDetail['type'] = 'incident_summary';
                    $summaryDetail['value'] = $postData['involved-summary'];
                    $summaryDetail['created'] = $dateNow;

                    array_push($incidentReportDetails, $summaryDetail);

                    $locationDetail  = $this->IncidentReportDetails->newEntity();
                    $locationDetail['incident_report_header_id'] = $incidentReportHeader->id;
                    $locationDetail['type'] = 'incident_summary';
                    $locationDetail['value'] = $postData['location'];
                    $locationDetail['created'] = $dateNow;

                    array_push($incidentReportDetails, $locationDetail);

                    $personsInvolved = $postData['involved-id'];

                    for($i = 0; $i < count($personsInvolved); $i++) {
                        $incidentReportDetail = $this->IncidentReportDetails->newEntity();

                        $incidentReportDetail['incident_report_header_id'] = $incidentReportHeader->id;
                        $incidentReportDetail['type'] = 'persons_involved';
                        $incidentReportDetail['value'] = $personsInvolved[$i];
                        $incidentReportDetail['created'] = $dateNow;

                        array_push($incidentReportDetails, $incidentReportDetail);
                    }

                    if($incidentReportHeader->type === 'los') {
                        $itemsLost      = $postData['item-id'];
                        $itemsQuantity  = $postData['item-quantity'];
                        for($i = 0; $i < count($itemsLost); $i++) {
                            $incidentReportDetail = $this->IncidentReportDetails->newEntity();

                            $incidentReportDetail['incident_report_header_id'] = $incidentReportHeader->id;
                            $incidentReportDetail['type'] = 'item_lost';
                            $incidentReportDetail['value'] = $itemsLost[$i];
                            $incidentReportDetail['attribute'] = $itemsQuantity[$i];
                            $incidentReportDetail['created'] = $dateNow;

                            array_push($incidentReportDetails, $incidentReportDetail);
                        }
                    } else {
                        $injuredSummaries = $postData['injured-summary'];
                        for($i = 0; $i < count($injuredSummaries); $i++) {
                            $incidentReportDetail = $this->IncidentReportDetails->newEntity();

                            $incidentReportDetail['incident_report_header_id'] = $incidentReportHeader->id;
                            $incidentReportDetail['type'] = 'injured_summary';
                            $incidentReportDetail['value'] = $injuredSummaries[$i];
                            $incidentReportDetail['attribute'] = $personsInvolved[$i];
                            $incidentReportDetail['created'] = $dateNow;

                            array_push($incidentReportDetails, $incidentReportDetail);
                        }
                    }

                    foreach($incidentReportDetails as $incidentReportDetail) {
                        if(!($this->IncidentReportDetails->save($incidentReportDetail))) {

                            $this->Flash->error(__('The incident report could not be saved. Please, try again.'));
                        }
                    }

                    $this->Flash->success(__('The incident report has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The incident report could not be saved. Please, try again.'));
                }
            }
            
        }

        $projects = [];

        $tempProjects = $this->Projects->find('all')
        ->where(['is_finished' => 0])
        ->contain(['EmployeesJoin' => [
            'EmployeeTypes'
            ]])
        ->toArray();

        foreach ($tempProjects as $tempProject) {
            $projectEngineer = null;

            foreach($tempProject->employees_join as $employee) {
                if($employee->employee_type->id == 3) {
                    $projectEgineer = $employee;            
                }
            }

            $project = [
            'text' => $tempProject->title,
            'value' => $tempProject->id,
            'data-project-engineer' => $projectEgineer->name,
            'data-location' => $tempProject->location
            ];

            array_push($projects, $project);
        }

        $this->set(compact('incidentReportHeader', 'projects'));
        $this->set('_serialize', ['incidentReportHeader', 'projects']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Incident Report Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $incidentReportHeader = $this->IncidentReportHeaders->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $incidentReportHeader = $this->IncidentReportHeaders->patchEntity($incidentReportHeader, $this->request->data);
            if ($this->IncidentReportHeaders->save($incidentReportHeader)) {
                $this->Flash->success(__('The incident report header has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The incident report header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->IncidentReportHeaders->Projects->find('list', ['limit' => 200]);
        $this->set(compact('incidentReportHeader', 'projects'));
        $this->set('_serialize', ['incidentReportHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Incident Report Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $valid = true;
        $this->loadModel('IncidentReportDetails');

        $this->request->allowMethod(['post', 'delete']);
        $incidentReportHeader = $this->IncidentReportHeaders->get($id, [
            'contain' => ['IncidentReportDetails']
            ]);
        

        foreach($incidentReportHeader['incident_report_details'] as $incidentReportDetail) {
            if (!($this->IncidentReportDetails->delete($incidentReportDetail))) {
                $this->Flash->error(__('The incident report header could not be deleted. Please, try again.'));
            } else {
                $valid = false;
            }
        }

        if($valid) {
            if ($this->IncidentReportHeaders->delete($incidentReportHeader)) {
                $this->Flash->success(__('The incident report has been deleted.'));
            } else {
                $this->Flash->error(__('The incident report could not be deleted. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

     /**
    * Method for getting all the employees and manpower assigned to a project
    *
    * @return json response
    */
     public function getPersons() {
        $this->loadModel('Projects');
        $this->loadModel('Manpower');

        $manpower  = [];

        $projectId  = $this->request->query('project_id');
        $taskId     = $this->request->query('task_id');

        if($projectId > 0 && $taskId > 0) {
            $project = $this->Projects->get($projectId, [
                'contain' => ['Employees', 'EmployeesJoin' => [
                'EmployeeTypes'
                ]]
                ]);

            foreach ($project->employees_join as $employee) {
                array_push($manpower, [
                    'id' => $employee->id, 
                    'name' => $employee->name,
                    'age' => $employee->age,
                    'address' => $employee->address,
                    'contact' => $employee->contact,
                    'occupation' => 'Employee'
                    ]);
            }   

            if ($projectId != null && $taskId != null) {
                $taskManpower = $this->Manpower->find('byProjectAndTask', ['project_id' => $projectId, 'task_id' => $taskId]);

                foreach ($taskManpower as $manpowerRow) {
                    array_push($manpower, [
                        'id' => $manpowerRow->id, 
                        'name' => $manpowerRow->name,
                        'age' => $manpowerRow->age,
                        'address' => $manpowerRow->address,
                        'contact' => $manpowerRow->contact,
                        'occupation' => $manpowerRow->manpower_type->title
                        ]);
                }

            }
        }

        header('Content-Type: application/json');
        echo json_encode($manpower);
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
        
        if ($project_id != null) {
            $tasks = $this->Tasks->find('byProject', ['project_id' => $project_id]);
        } 

        header('Content-Type: application/json');
        echo json_encode($tasks);
        exit();
    }   



    /**
    * Method for getting materials and equipment from the database
    *
    * @return json response
    */
    public function getItems() {
        $this->loadModel('EquipmentTasks');
        $this->loadModel('MaterialsTasks');
        $this->loadModel('Tasks');

        $items  = [];

        $taskId     = $this->request->query('task_id');

        if ($taskId != null) {                   
            foreach ( $this->MaterialsTasks->find('byTask', ['task_id' => $taskId]) as $material) {
                $materialName = $material->material->name;
                array_push($items, $materialName);
            }   

            foreach ($this->EquipmentTasks->find('byTaskId', ['task_id'=>$taskId]) as $equipment) {
                $equipmentName = $equipment->equipment->name;

                array_push($items, $equipmentName);
            }

            $items = array_unique($items);
        }



        header('Content-Type: application/json');
        echo json_encode($items);
        exit();
    }


}
