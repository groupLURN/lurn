<?php
namespace App\Controller;

use App\Controller\AppController;

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
            'contain' => ['Clients', 'Employees', 'ProjectStatuses']
        ];
        $this->paginate += $this->createFinders($this->request->query);
        $projects = $this->paginate($this->Projects);

        $this->set(compact('projects'));
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
            'contain' => ['Clients', 'Employees', 'ProjectStatuses']
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
        $employees = $this->Projects->Employees->find('list', ['limit' => 200])->matching(
            'EmployeeTypes', function($query){
                return $query->where(['EmployeeTypes.title' => 'Project Manager/Project Supervisor']);
            }
        );

        $projectStatuses = $this->Projects->ProjectStatuses->find('list', ['limit' => 200]);
        $this->set(compact('project', 'clients', 'employees', 'projectStatuses'));
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
            'contain' => []
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
        $this->set(compact('project', 'clients', 'employees', 'projectStatuses'));
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

        if (in_array($action, ['edit', 'add'])) {

            // Authorize only if the user is a project manager.
            $resultSet = $this->Projects->Employees->find()
                ->contain(['Users'])
                ->where(['Users.id' => $user['id']])
                ->matching(
                    'EmployeeTypes', function($query){
                    return $query->where(['EmployeeTypes.title' => 'Project Manager/Project Supervisor']);
                })->first();

            return $resultSet !== null;
        }

        return parent::isAuthorized($user);
    }
}
