<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{
    private $__projectId = null;
    private $_milestones = null;

    public function beforeFilter(Event $event)
    {
        if(!isset($this->request->query['project_id']))
            return $this->redirect(['controller' => 'dashboard']);

        $this->viewBuilder()->layout('project_management');
        $this->__projectId = (int) $this->request->query['project_id'];

        $this->set('projectId', $this->__projectId);
        $this->set('statusList', array_flip($this->Tasks->status));
        return parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'Tasks' => [
                    'Equipment', 'ManpowerTypes', 'Materials',
                    'EquipmentReplenishmentDetails', 'ManpowerTypeReplenishmentDetails', 'MaterialReplenishmentDetails'
                ]
            ]
        ];
        
        $this->paginate += $this->createFinders($this->request->query, 'Milestones');
        $milestones = $this->paginate($this->Tasks->Milestones);

        $query = $this->Tasks->Milestones->find();

        $isFinishedCase = $query->newExpr()->addCase($query->newExpr()->add(['Tasks.is_finished' => 1]), 1, 'integer');

        $resultSet =
            $query
                ->select(['Milestones.id', 'finished_tasks' => $query->func()->coalesce([$query->func()->sum($isFinishedCase), 0]),
                    'total_tasks' => $query->func()->count('Tasks.id')])
                ->matching('Tasks')
                ->where(['Milestones.id IN' => $milestones->extract('id')->toArray()])
                ->group('Milestones.id')
                ->toArray();

        $milestonesProgress = [];
        foreach($resultSet as $milestoneProgress)
            $milestonesProgress[$milestoneProgress->id] = $milestoneProgress['finished_tasks']/ $milestoneProgress['total_tasks'] * 100;

        $this->set(compact('milestones', 'milestonesProgress'));
        $this->set($this->request->query);
        $this->set('_serialize', ['milestones', 'milestonesProgress']);

        $this->_milestones = $milestones;
    }

    public function manage()
    {
        $this->index();
        $milestones = $this->_milestones;
        $this->Tasks->computeForTaskReplenishmentUsingMilestones($milestones);

        $this->set(compact('taskReplenishment', 'milestones'));
        $this->set($this->request->query);
        $this->set('_serialize', ['taskReplenishment', 'milestones']);
    }

    public function replenish($id)
    {
        $task = $this->Tasks->get($id, [
            'contain' => [
                'Milestones',
                'Equipment', 'ManpowerTypes', 'Materials',
                'EquipmentReplenishmentDetails', 'ManpowerTypeReplenishmentDetails', 'MaterialReplenishmentDetails'
            ]
        ]);

        $this->Tasks->computeForTaskReplenishment($task);

        if($this->Tasks->replenish($task))
            $this->Flash->success(__('The Task ' . $task->title . ' has been replenished.'));
        else
            $this->Flash->error(__('The Task ' . $task->title . '  cannot be replenished. Please, try again.'));

        return $this->redirect(['action' => 'manage', '?' => ['project_id' => $this->__projectId]]);
    }

    public function viewStock($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Milestones',
                'Equipment', 'ManpowerTypes', 'Materials',
                'EquipmentReplenishmentDetails', 'ManpowerTypeReplenishmentDetails', 'MaterialReplenishmentDetails'
            ]
        ]);

        $this->Tasks->computeForTaskReplenishment($task);

        $this->set('task', $task);
        $this->set('_serialize', ['task']);
    }

    public function finish($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => [
                'Milestones',
                'Equipment', 'ManpowerTypes', 'Materials',
                'EquipmentReplenishmentDetails', 'ManpowerTypeReplenishmentDetails', 'MaterialReplenishmentDetails'
            ]
        ]);

        $this->Tasks->computeForTaskReplenishment($task);

        if ($this->request->is(['patch', 'post', 'put']))
        {
            $task->is_finished = 1;
            $task->comments = $this->request->data['comments'];
            $this->transpose($this->request->data, 'materials');

            if ($this->Tasks->returnToProjectInventory($task, $this->request->data['materials']) &&
                $this->Tasks->save($task))
            {   
                $this->loadModel('Notifications');
                $this->loadModel('Projects');
                $employees = [];

                $project = $this->Projects->get($task->milestone->project_id, [
                    'contain' => ['Employees', 'EmployeesJoin' => ['EmployeeTypes']]]);

                array_push($employees, $project->employee);
                for ($i=0; $i < count($project->employees_join); $i++) { 
                    $userType = $project->employees_join[$i]->employee_type_id;
                    if($userType == 1 || $userType == 3) {
                        array_push($employees, $project->employees_join[$i]);
                    }
                }

                foreach ($employees as $employee) {
                    $notification = $this->Notifications->newEntity();
                    $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'tasks', 
                        'action' => 'view/'.$task->id.'?project_id='.$project->id ], false));
                    $notification->link = $link;
                    $notification->message = $task->title.' has been completed.';
                    $notification->user_id = $employee['user_id'];
                    $notification->project_id = $project->id;
                    $this->Notifications->save($notification);
                }
                
                $this->Flash->success(__('The task has been marked finished!'));
                return $this->redirect(['action' => 'manage', '?' => ['project_id' => $this->__projectId]]);
            }
            else
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }

        $this->set(compact('task'));
        $this->set('_serialize', ['task']);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Milestones', 'Equipment', 'ManpowerTypes', 'Materials']
        ]);

        $this->set('task', $task);
        $this->set('_serialize', ['task']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $task = $this->Tasks->newEntity();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }
        $milestones = $this->Tasks->Milestones->find('list', ['limit' => 200]);
        $equipment = $this->Tasks->Equipment->find('list', ['limit' => 200]);
        $manpower = $this->Tasks->Manpower->find('list', ['limit' => 200]);
        $materials = $this->Tasks->Materials->find('list', ['limit' => 200]);
        $this->set(compact('task', 'milestones', 'equipment', 'manpower', 'materials'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            $task = $this->Tasks->get($id);

            $this->transpose($this->request->data, 'equipment');
            $this->transpose($this->request->data, 'manpower_types');
            $this->transpose($this->request->data, 'materials');

            $task = $this->Tasks->patchEntity($task, $this->request->data, [
                'associated' => ['Equipment', 'ManpowerTypes', 'Materials']
            ]);

            $task->dirty('manpower_types', true);
            $task->dirty('equipment', true);
            $task->dirty('materials', true);

            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(['action' => 'index', '?' => ['project_id' => $this->__projectId]]);
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }

        $task = $this->Tasks->get($id, [
            'contain' => ['Equipment', 'ManpowerTypes', 'Materials']
        ]);

        $milestones = $this->Tasks->Milestones->find('list', ['limit' => 200]);
        $equipment = $this->Tasks->Equipment->find('list', ['limit' => 200]);
        $manpowerTypes = $this->Tasks->ManpowerTypes->find('list', ['limit' => 200]);
//        $manpowerTypes
//            ->select(['__violation' =>
//                $manpowerTypes->func()->coalesce([
//                    $manpowerTypes->func()->sum(
//                        $manpowerTypes->newExpr()->addCase([
//                            $manpowerTypes->newExpr()->add(["Tasks.id IS NOT" => null])
//                        ], 1
//                        )
//                    ), 0
//                ])
//            ])
//            ->select($this->Tasks->Manpower)
//            ->leftJoinWith('ManpowerTasks.Tasks', function($query) use ($task)
//            {
//                return $query
//                    ->where(
//                        [
//                            'Tasks.start_date <=' => $task->start_date,
//                            'Tasks.end_date >=' => $task->start_date,
//                            'Tasks.id !=' => $task->id
//                        ]
//                    )
//                    ->orWhere(
//                        [
//                            'Tasks.start_date <=' => $task->end_date,
//                            'Tasks.end_date >=' => $task->end_date,
//                            'Tasks.id !=' => $task->id
//                        ]
//                    );
//            })
//            ->group(['Manpower.id'])
//            ->having(['__violation' => 0]);

        $materials = $this->Tasks->Materials->find('list', ['limit' => 200]);

        $selectedEquipment = $task->equipment;
        $selectedMaterials = $task->materials;
        $selectedManpowerTypes =  $task->manpower_types;

        $this->set(compact('task', 'milestones', 'equipment', 'manpowerTypes', 'materials',
            'selectedEquipment', 'selectedMaterials', 'selectedManpowerTypes'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The task has been deleted.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
