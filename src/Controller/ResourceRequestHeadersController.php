<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

/**
 * ResourceRequestHeaders Controller
 *
 * @property \App\Model\Table\ResourceRequestHeadersTable $ResourceRequestHeaders
 */
class ResourceRequestHeadersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['ProjectFrom', 'ProjectTo']
        ];

        $this->paginate += $this->createFinders($this->request->query);
        $resourceRequestHeaders = $this->paginate($this->ResourceRequestHeaders);
        $projects = TableRegistry::get('Projects')->find('list')->toArray();

        $this->set(compact('resourceRequestHeaders', 'projects'));
        $this->set($this->request->query);
        $this->set('_serialize', ['resourceRequestHeaders', 'projects']);
    }

    /**
     * View method
     *
     * @param string|null $id Resource Request Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resourceRequestHeader = $this->ResourceRequestHeaders->find('byId', ['id' => $id])->first();

        $this->set('resourceRequestHeader', $resourceRequestHeader);
        $this->set('_serialize', ['resourceRequestHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resourceRequestHeader = $this->ResourceRequestHeaders->newEntity();
        if ($this->request->is('post')) {
            $this->transpose($this->request->data, 'equipment');
            $this->transpose($this->request->data, 'manpower_types');
            $this->transpose($this->request->data, 'materials');
            $resourceRequestHeader = $this->ResourceRequestHeaders->patchEntity($resourceRequestHeader, $this->request->data, [
                'associated' => ['Equipment', 'ManpowerTypes', 'Materials']
                ]);

            if ($this->ResourceRequestHeaders->save($resourceRequestHeader)) {
                $this->loadModel('Notifications');
                $this->loadModel('Projects');
                $employees = [];

                $project = $this->Projects->find('byId', ['project_id' => $resourceRequestHeader->from_project_id])->first();
                
                array_push($employees, $project->employee);
                for ($i=0; $i < count($project->employees_join); $i++) { 
                    $employeeType = $project->employees_join[$i]->employee_type_id;
                    if($employeeType == 1 || $employeeType == 4) {
                        array_push($employees, $project->employees_join[$i]);
                    }
                }

                foreach ($employees as $employee) {
                    $notification = $this->Notifications->newEntity();
                    $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'resource-request-headers', 'action' => 'view/'. $resourceRequestHeader->id ], false));
                    $notification->link = $link;
                    $notification->message = '<b>'.$project->title.'</b> made a resource request. Click to see the request.';
                    $notification->user_id = $employee['user_id'];
                    $notification->project_id = $resourceRequestHeader->from_project_id;
                    $this->Notifications->save($notification);
                }

                $this->Flash->success(__('The resource request number ' . $resourceRequestHeader->id .' has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resource request header could not be saved. Please, try again.'));
            }
        }

        $projects = $this->ResourceRequestHeaders->ProjectTo->find('list', ['limit' => 200])
        ->matching('EmployeesJoin.Users', function($query)
        {
            return $query->where(['Users.id' => $this->userId]);
        })
        ->toArray();

        $materials = TableRegistry::get('Materials')->find('list', ['limit' => 200]);
        $equipment = TableRegistry::get('Equipment')->find('list', ['limit' => 200]);
        $manpowerTypes = TableRegistry::get('ManpowerTypes')->find('list', ['limit' => 200]);
        $this->set(compact('resourceRequestHeader', 'projects', 'materials', 'equipment', 'manpowerTypes'));
        $this->set('_serialize', ['resourceRequestHeader', 'projects', 'materials', 'equipment', 'manpowerTypes']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Resource Request Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resourceRequestHeader = $this->ResourceRequestHeaders->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resourceRequestHeader = $this->ResourceRequestHeaders->patchEntity($resourceRequestHeader, $this->request->data);
            if ($this->ResourceRequestHeaders->save($resourceRequestHeader)) {
                $this->Flash->success(__('The resource request header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resource request header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->ResourceRequestHeaders->Projects->find('list', ['limit' => 200]);
        $this->set(compact('resourceRequestHeader', 'projects'));
        $this->set('_serialize', ['resourceRequestHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Resource Request Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resourceRequestHeader = $this->ResourceRequestHeaders->get($id);
        if ($this->ResourceRequestHeaders->delete($resourceRequestHeader)) {
            $this->Flash->success(__('The resource request header has been deleted.'));
        } else {
            $this->Flash->error(__('The resource request header could not be deleted. Please, try again.'));
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
        $milestones     = [];
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
        $tasks  = [];

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
    * Method for getting materials from the database
    *
    * @return json response
    */
    public function getMaterials() {
        $this->loadModel('Materials');
        $this->loadModel('Tasks');

        $materialsNeeded   = [];
        $taskIds           = [];

        $project_id     = $this->request->query('project_id');
        $milestone_id   = $this->request->query('milestone_id');
        $task_id        = $this->request->query('task_id');

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
            $materialsNeededPerTask = $this->Materials->find('byTask', ['task_id' => $task_id])->toArray();
                         
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

    /**
    * Method for getting magnpower from the database
    *
    * @return json response
    */
    public function getManpower() {
        $this->loadModel('ManpowerTypesTasks');
        $this->loadModel('Tasks');

        $manpowerNeeded = [];
        $tasks          = [];


        $project_id     = $this->request->query('project_id');
        $milestone_id   = $this->request->query('milestone_id');
        $task_id        = $this->request->query('task_id');

        if ($task_id != null) {
            $task = $this->Tasks->get($task_id);
            array_push($tasks, $task);

        } else if ($project_id != null) {
            if($milestone_id != null) {
                $tasks = $this->Tasks->find('byProjectAndMilestone', ['project_id' => $project_id, 'milestone_id' => $milestone_id]);
            } else {
                $tasks = $this->Tasks->find('byProject', ['project_id' => $project_id]);
            }

        }     

        foreach ($tasks as $task) {
            $manpowerNeededPerTask = $this->ManpowerTypesTasks->find('byTaskId', ['task_id'=>$task->id])->toArray();
                   
            $push = true;

            foreach ($manpowerNeededPerTask as $manpowerPerTask) {                            
                foreach ($manpowerNeeded as $manpower) {
                    if ($manpower->manpower_type_id == $manpowerPerTask->manpower_type_id) {
                        $manpower->quantity += $manpowerPerTask->quantity;
                        $push = false;
                    } 
                }
                
                if (count($manpowerNeeded) == 0 || $push) {
                    array_push($manpowerNeeded, $manpowerPerTask);
                }
            }
         
           
        } 

        header('Content-Type: application/json');
        echo json_encode($manpowerNeeded);
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

        $equipmentNeeded            = [];
        $equipmentNeededPerTask     = [];
        $taskIds                    = [];

        $project_id     = $this->request->query('project_id');
        $milestone_id   = $this->request->query('milestone_id');
        $task_id        = $this->request->query('task_id');

        if ($task_id != null) {
            $taskIds = [$task_id];
        } else if ($project_id != null) {
            $tasks = [];

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
            $equipmentNeededPerTask = $this->Equipment->find('byTask', ['task_id' => $task_id])->toArray();
                         
            $push = true;

            foreach ($equipmentNeededPerTask as $equipmentPerTask) {                            
                foreach ($equipmentNeeded as $equipment) {
                    if ($equipment->id == $equipmentPerTask->id) {
                        $equipment['et']['quantity'] += $equipmentPerTask['et']['quantity'];
                        $push = false;
                    } 
                }
                
                if (count($equipmentNeeded) == 0 || $push) {
                    array_push($equipmentNeeded, $equipmentPerTask);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($equipmentNeeded);
        exit();
    }


}
