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
        $resourceRequestHeader = $this->ResourceRequestHeaders->get($id, [
            'contain' => ['ProjectFrom', 'ProjectTo', 'Equipment', 'ManpowerTypes', 'Materials']
        ]);

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

                $project = $this->Projects->get($resourceRequestHeader->from_project_id, [
                    'contain' => ['Employees', 'EmployeesJoin' => ['EmployeeTypes']]]);

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
                    $notification->message = $project->title.' has made an inventory request. Click to see request.';
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
}
