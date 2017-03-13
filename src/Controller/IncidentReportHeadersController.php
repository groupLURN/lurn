<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\DatabaseConstants;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\I18n\Time;
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
        if(!isset($this->request->query['project_id']))
            return $this->redirect(['controller' => 'dashboard']);

        $this->loadModel('Projects');
        $this->viewBuilder()->layout('project_management');
        $projectId = (int) $this->request->query['project_id'];
        
        $this->set('projectId', $projectId);
        
        $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();

        $this->set('isFinished', $project->is_finished );
        return parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {  
        $action = $this->request->params['action'];

        $userTypeId = isset($user['employee']['employee_type_id'])
            ? $user['employee']['employee_type_id'] : '';
        $isAdmin = $userTypeId === 0;
        $isOwner = $userTypeId === 1;
        $isProjectManager = $userTypeId === 2;
        $isWarehouseKeeper = $userTypeId === 4;

        $projectId = $this->request->query('project_id');

        $isUserAssigned = false;
        if ($user['user_type_id'] === 2) {                
            $isUserAssigned = $this->Projects->find()
            ->matching('EmployeesJoin', function($query) use ($user) {
                return $query->where(['EmployeesJoin.user_id' => $user['id']]);
            })
            ->where(['Projects.id' => $projectId])
            ->first() !== null;
        } else {
            $isUserAssigned = $this->Projects->find()
            ->where([
                    'Projects.id' => $projectId, 
                    'Projects.client_id' => $user['client']['id']
                ])
            ->first() !== null;
        }

        if (in_array($action, ['add', 'delete', 'edit','get-items', 'get-persons', 'get-tasks']))
        {   
            return ($isUserAssigned && ($isProjectManager|| $isWarehouseKeeper)) 
                || $isOwner 
                || $isAdmin;
        } else if (in_array($action, ['index', 'view', 'generate-report']))
        {
            return $isUserAssigned || $isAdmin || $isOwner;
        }

        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($id = null)
    {
        $this->loadComponent('IncidentReport', []);

        $projectId = (int) $this->request->query['project_id'];
        
        $this->paginate = [
            'contain' => ['Projects'],
            'finder' =>
                [
                    'ByProjectId' => [
                        'project_id' => $projectId
                    ]
                ]
        ];

        $incidentReportHeaders = $this->paginate($this->IncidentReportHeaders);
        $incidentReportHeaders = $this->IncidentReport->prepareIncidentReportsForList($incidentReportHeaders);

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

        $incidentReportHeader = $this->IncidentReport->prepareIncidentReportView($id);

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
        $this->loadComponent('IncidentReport', []);

        $this->loadModel('Projects');
        $this->loadModel('IncidentReportDetails');

        $incidentReportHeader   = $this->IncidentReportHeaders->newEntity();
        $projects               = $this->IncidentReport->initializeProjectsList();

        if ($this->request->is('post')) {
            $valid              = true;
            $postData           = $this->request->data;
            $postData['date']   = new DateTime($postData['date']);

            $project = $this->Projects->find('byId', ['project_id' => $postData['project_id']])->first();

            foreach($project->employees_join as $employee) {
                if($employee->employee_type->id == 3) {
                    $postData['project_engineer'] = $employee->id;  
                    break;          
                }
            }

            $incidentReportHeader = $this->IncidentReportHeaders->patchEntity($incidentReportHeader, $postData);

            $incidentReportDetails = $this->IncidentReport->prepareIncidentReportDetailsSave($postData);

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

                    foreach($incidentReportDetails as $incidentReportDetail) {
                        $incidentReportDetail['incident_report_header_id'] = $incidentReportHeader->id;
                        if(!($this->IncidentReportDetails->save($incidentReportDetail))) {

                            $this->Flash->error(__('The incident report could not be saved. Please, try again.'));
                        }
                    }

                    $this->Flash->success(__('The incident report has been saved.'));

                    $projectId = (int) $this->request->query['project_id'];
                    return $this->redirect(['action' => 'index', '?' => ['project_id' => $projectId]]);
                } else {
                    $this->Flash->error(__('The incident report could not be saved. Please, try again.'));
                }
            }

            $incidentReportHeader->incident_report_details = $incidentReportDetails;

            
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
        $this->loadComponent('IncidentReport', []);

        $this->loadModel('Projects');
        $this->loadModel('IncidentReportDetails');

        $incidentReportHeader   = $this->IncidentReport->prepareIncidentReportView($id);

        $projectId = (int) $this->request->query['project_id'];

        if(is_int($incidentReportHeader) && $incidentReportHeader == DatabaseConstants::RECORDNOTFOUND) {
            $this->Flash->error(__('The record was not found.'));

            return $this->redirect(['action' => 'index', '?' => ['project_id' => $projectId]]);
        }

        if ($projectId != $incidentReportHeader->project_id) {
            $this->Flash->error(__('The incident report was not assiged to that project.'));

            return $this->redirect(['action' => 'index', '?' => ['project_id' => $projectId]]);
        }

        $projects = $this->IncidentReport->initializeProjectsList($incidentReportHeader->project_id);        

        if ($this->request->is(['patch', 'post', 'put'])) {
            $valid = true;

            $incidentReportHeader = $this->IncidentReportHeaders->get($id, [
                'contain' => ['Projects' => [
                'EmployeesJoin' => [
                'EmployeeTypes'
                ]
                ], 
                'IncidentReportDetails']
                ]);

            $postData           = $this->request->data;
            $postData['date']   = new DateTime($postData['date']);

            $project = $this->Projects->find('byId', ['project_id' => $postData['project_id']])->first();

            foreach($project->employees_join as $employee) {
                if($employee->employee_type->id == 3) {
                    $postData['project_engineer'] = $employee->id; 
                    break;           
                }
            }

            $newIncidentReportHeader = $this->IncidentReportHeaders->patchEntity($incidentReportHeader, $postData, [
                'associated' => [
                    'Projects'
                ]
            ]); 

            if(!isset($postData['involved-id'])) {
                $valid = false;
                $this->Flash->error(__('Please add involved persons.'));
            }

            if($newIncidentReportHeader->type === 'los') {               
                if(!isset($postData['item-id'])) {
                    $valid = false;
                    $this->Flash->error(__('Please add lost items.'));
                }
            } 

            if($valid) {
                $incidentReportDetails = $this->IncidentReport->prepareIncidentReportDetailsSave($postData);

                if ($this->IncidentReportHeaders->save($newIncidentReportHeader)) {

                    $oldIncidentReportDetails = $incidentReportHeader['incident_report_details'];
                    $this->IncidentReport->deleteIncidentReportDetails($oldIncidentReportDetails);

                    foreach($incidentReportDetails as $incidentReportDetail) {
                        $incidentReportDetail['incident_report_header_id'] = $incidentReportHeader->id;
                        if(!($this->IncidentReportDetails->save($incidentReportDetail))) {

                            $this->Flash->error(__('The incident report could not be saved. Please, try again.'));
                        }
                    }

                    $this->Flash->success(__('The incident report header has been updated.'));

                    return $this->redirect(['action' => 'index', '?' => ['project_id' => $projectId]]);
                } else {
                    $this->Flash->error(__('The incident report header could not be updated. Please, try again.'));
                }
            }
        }

        $this->set(compact('incidentReportHeader', 'projects'));
        $this->set('_serialize', ['incidentReportHeader', 'projects']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Incident Report Header id.
     */
    public function delete($id = null)
    {
        $this->loadComponent('IncidentReport', []);

        $valid = true;

        $this->request->allowMethod(['post', 'delete']);
        $incidentReportHeader = $this->IncidentReportHeaders->get($id, [
            'contain' => ['IncidentReportDetails']
            ]);

        $projectId = (int) $this->request->query['project_id'];

        if ($projectId != $incidentReportHeader->project_id) {
            $this->Flash->error(__('The incident report was not assiged to that project.'));

            return $this->redirect(['action' => 'index', '?' => ['project_id' => $projectId]]);
        }
        
        $incidentReportDetails = $incidentReportHeader['incident_report_details'];
        $valid = $this->IncidentReport->deleteIncidentReportDetails($incidentReportDetails);

        if($valid && $this->IncidentReportHeaders->delete($incidentReportHeader)) {
            $this->Flash->success(__('The incident report has been deleted.'));
        } else {
            $this->Flash->error(__('The incident report could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', '?' => ['project_id' => $projectId]]);
    }

    /**
     * Generate pdf output method.
     *
     * @param string $id Incident Report Header id.
     * @param integer $download Flag for downloading.
     */
    public function generateReport($id, $download = null)
    {
        $this->loadComponent('IncidentReport', []);
        $this->viewBuilder()->layout('incident-report');

        $currentDate = Time::now();
        $currentDate = sprintf('%02d', $currentDate->month) . sprintf('%02d', $currentDate->day) . $currentDate->year;

        $incidentReportHeader = $this->IncidentReport->prepareIncidentReportView($id);

        $projectId = (int) $this->request->query['project_id'];

        if ($projectId != $incidentReportHeader->project_id) {
            $this->Flash->error(__('The incident report was not assiged to that project.'));

            return $this->redirect(['action' => 'index', '?' => ['project_id' => $projectId]]);
        }

        $this->set('incidentReport', $incidentReportHeader);
        $this->set('_serialize', ['incidentReport']);

        if ($download == 1){
            $download = true;
        }else{
            $download = false;
        }

        $this->viewBuilder()->options([
            'pdfConfig' => [
                'orientation' => 'portrait',
                'pageSize' => 'Letter',
                'filename' => 'Incident_Report_' . $currentDate . '.pdf',
                'download' => $download
            ]           
        ])->template('pdf');
    }
     /**
    * Method for getting all the employees and manpower assigned to a project
    *
    * @return json response
    */
    public function getPersons() 
    {
        $this->loadModel('Projects');
        $this->loadModel('Manpower');

        $manpower  = [];

        $projectId  = $this->request->query('project_id');
        $taskId     = $this->request->query('task_id');

        if($projectId > 0 && $taskId > 0) {
            $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();

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
    public function getTasks() 
    {
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
    public function getItems() 
    {
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
