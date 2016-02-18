<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 */
class EmployeesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'EmployeeTypes']
        ];

        $this->paginate += $this->createFinders($this->request->query);
        $employees = $this->paginate($this->Employees);

        $employeeTypes = $this->Employees->EmployeeTypes->find('list', ['limit' => 200])->toArray();
        $this->set(compact('employees', 'employeeTypes'));
        $this->set($this->request->query);
        $this->set('_serialize', ['employees']);
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => ['Users', 'EmployeeTypes', 'Projects' => [
                'Clients',
                'Employees'
            ]]
        ]);

        $this->set('employee', $employee);
        $this->set('_serialize', ['employee']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employee = $this->Employees->newEntity();
        $employee->user = $this->Employees->Users->newEntity();

        if ($this->request->is('post')) {
            $employee->user = $this->Employees->Users->patchEntity($employee->user, [
                'username' => $this->request->data['username'],
                'password' => $this->request->data['password'],
                'user_type_title' => 'Employee'
            ]);

            $employee = $this->Employees->patchEntity($employee, $this->request->data);

            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The employee could not be saved. Please, try again.'));
            }
        }
        $users = $this->Employees->Users->find('list', ['limit' => 200]);
        $employeeTypes = $this->Employees->EmployeeTypes->find('list', ['limit' => 200]);
        $projects = $this->Employees->Projects->find('list', ['limit' => 200]);
        $this->set(compact('employee', 'users', 'employeeTypes', 'projects'));
        $this->set('_serialize', ['employee']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => ['Users', 'Projects']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee = $this->Employees->patchEntity($employee, $this->request->data, [
                'associated' => [
                    'Users'
                ]
            ]);
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The employee could not be saved. Please, try again.'));
            }
        }
        $users = $this->Employees->Users->find('list', ['limit' => 200]);
        $employeeTypes = $this->Employees->EmployeeTypes->find('list', ['limit' => 200]);
        $projects = $this->Employees->Projects->find('list', ['limit' => 200]);
        $this->set(compact('employee', 'users', 'employeeTypes', 'projects'));
        $this->set('_serialize', ['employee']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employee = $this->Employees->get($id, ['contain' => ['Users', 'EmployeeTypes', 'Projects']]);

        if(!empty($employee->projects))
            $this->Flash->error(__('The employee is currently assigned to projects so it cannot be deleted.'));
        else if($this->Auth->user('id') === $employee->user_id)
            $this->Flash->error(__('You cannot delete yourself.'));
        else {
            $isSuccessful = $this->Employees->connection()->transactional(function() use ($employee){
                return $this->Employees->delete($employee, ['atomic' => false]) &&
                $this->Employees->Users->delete($employee->user, ['atomic' => false]);
            });

            if ($isSuccessful) {
                $this->Flash->success(__('The employee has been deleted.'));
            } else {
                $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
