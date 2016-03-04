<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{
    private $__projectId = null;

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
            'contain' => 'Tasks'
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
        $this->set('_serialize', ['milestones']);
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
            'contain' => ['Milestones', 'Equipment', 'Manpower' => [
                'ManpowerTypes'
            ], 'Materials']
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

            $nullSet = [
                'manpower' => [],
                'equipment' => [],
                'materials' => []
            ];

            if(isset($this->request->data['resources']))
                $this->request->data['resources'] += $nullSet;
            else
                $this->request->data['resources'] = $nullSet;

            $this->request->data += $this->_resourcesAdapter($this->request->data['resources']);

            $task = $this->Tasks->patchEntity($task, $this->request->data, [
                'associated' => ['Equipment', 'Manpower', 'Materials']
            ]);

            $task->dirty('manpower', true);
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
            'contain' => ['Equipment', 'Manpower', 'Materials']
        ]);

        $milestones = $this->Tasks->Milestones->find('list', ['limit' => 200]);
        $equipment = $this->Tasks->Equipment->find('list', ['limit' => 200]);
        $manpower = $this->Tasks->Manpower->find('list', ['limit' => 200]);
        $manpower
            ->select(['__violation' =>
                $manpower->func()->coalesce([
                    $manpower->func()->sum(
                        $manpower->newExpr()->addCase([
                            $manpower->newExpr()->add(["Tasks.id IS NOT" => null])
                        ], 1
                        )
                    ), 0
                ])
            ])
            ->select($this->Tasks->Manpower)
            ->leftJoinWith('ManpowerTasks.Tasks', function($query) use ($task)
            {
                return $query
                    ->where(
                        [
                            'Tasks.start_date <=' => $task->start_date,
                            'Tasks.end_date >=' => $task->start_date,
                            'Tasks.id !=' => $task->id
                        ]
                    )
                    ->orWhere(
                        [
                            'Tasks.start_date <=' => $task->end_date,
                            'Tasks.end_date >=' => $task->end_date,
                            'Tasks.id !=' => $task->id
                        ]
                    );
            })
            ->group(['Manpower.id'])
            ->having(['__violation' => 0]);

        $materials = $this->Tasks->Materials->find('list', ['limit' => 200]);

        $selectedEquipment = $task->equipment;
        $selectedMaterials = $task->materials;
        $selectedManpower =  $task->manpower;

        $this->set(compact('task', 'milestones', 'equipment', 'manpower', 'materials',
            'selectedEquipment', 'selectedMaterials', 'selectedManpower'));
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

    private function _resourcesAdapter($input)
    {
        $output = [];
        // resource (e.g. ['materials', 'manpower']
        foreach($input as $resource => $resourceElement)
            // Key (e.g. ['id', '_joinData']
            foreach($resourceElement as $key => $array)
                foreach($array as $index => $value)
                    $output[$resource][$index][$key] = $value;
        return $output;
    }
}
