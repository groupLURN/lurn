<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clients', 'Employees', 'ProjectStatuses', 'Milestones' => ['Tasks']]
        ];

        $this->paginate += [
            'finder' =>
                array_merge(
                    $this->createFinders($this->request->query)['finder'],
                    ['ByAuthorization' => ['user_id' => $this->Auth->user('id')]]
                )
        ];

        $projects = $this->paginate($this->Projects);
        foreach($projects as $project)
        {
            $milestones = new Collection($project->milestones);
            list($finishedTasks, $totalTasks) = $milestones->reduce(function($accumulated, $milestone)
            {
                $tasks = new Collection($milestone->tasks);

                list($finishedTasks, $totalTasks) = $tasks->reduce(function($accumulated, $task)
                {
                    return [$accumulated[0] + $task->is_finished, $accumulated[1] + 1];
                }, [0, 0]);

                return [$accumulated[0] + $finishedTasks, $accumulated[1] + $totalTasks];
            }, [0, 0]);
            $project->progress = $finishedTasks / $totalTasks * 100;
        }

        $projectStatuses = $this->Projects->ProjectStatuses->find('list', ['limit' => 200])->toArray();

        $this->set(compact('projects', 'projectStatuses'));
        $this->set($this->request->query);
        $this->set('_serialize', ['projects']);
    }

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Clients', 'Employees', 'ProjectStatuses', 'EmployeesJoin' => [
                'EmployeeTypes'
            ]]
        ]);

        $this->set('project', $project);
        $this->set('_serialize', ['project']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $clients = $this->Projects->Clients->find('list', ['limit' => 200]);

        $employeesJoin = $this->Projects->EmployeesJoin->find('list', ['limit' => 200])->toArray();
        $projectStatuses = $this->Projects->ProjectStatuses->find('list', ['limit' => 200]);
        $employees = $this->Projects->Employees->find('list', ['limit' => 200]);
        $this->set(compact('project', 'clients', 'projectStatuses', 'employees', 'employeesJoin'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Employees', 'EmployeesJoin']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $clients = $this->Projects->Clients->find('list', ['limit' => 200]);
        $employees = $this->Projects->Employees->find('list', ['limit' => 200]);
        $projectStatuses = $this->Projects->ProjectStatuses->find('list', ['limit' => 200]);
        $employeesJoin = $this->Projects->EmployeesJoin->find('list', ['limit' => 200])->toArray();

        $currentEmployeesJoin = [];
        foreach($project->employees_join as $employee)
            $currentEmployeesJoin[] = $employee->id;

        $this->set(compact('project', 'clients', 'projectStatuses', 'employees', 'employeesJoin', 'currentEmployeesJoin'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];

        $isProjectManager = $this->Projects->Employees->find()
            ->contain(['Users'])
            ->where(['Users.id' => $user['id']])
            ->matching('EmployeeTypes', function($query){
                return $query->where(['EmployeeTypes.title' => 'Project Manager/Project Supervisor']);
            })->first() !== null;

        if (in_array($action, ['edit', 'add', 'delete']))
            return $isProjectManager;
        else if (in_array($action, ['view']))
        {
            $projectId = $this->request->params['pass'][0];

            $isUserAssigned = $this->Projects->find()
                ->matching('EmployeesJoin', function($query) use ($user) {
                    return $query->where(['EmployeesJoin.user_id' => $user['id']]);
                })
                ->where(['Projects.id' => $projectId])
                ->first() !== null;

            return $isUserAssigned || $isProjectManager;
        }

        return parent::isAuthorized($user);
    }
}
