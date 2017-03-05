<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * MaterialsProjectInventories Controller
 *
 * @property \App\Model\Table\MaterialsProjectInventoriesTable $MaterialsProjectInventories
 */
class MaterialsProjectInventoriesController extends AppController
{
    private $_projectId = null;

    public function beforeFilter(Event $event)
    {
        if(empty($this->request->params['pass'])) {
            return $this->redirect(['controller' => 'dashboard']);
        }

        $this->loadModel('Projects');
        $this->viewBuilder()->layout('project_management');
        $projectId = (int) $this->request->params['pass'][0];
        
        $this->set('projectId', $projectId);
        
        $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();

        $this->set('isFinished', $project->is_finished );

        $this->set('projectId', $projectId);
        return parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];

        $userTypeId = $user['employee']['employee_type_id'];
        $isAdmin = $userTypeId == 0;
        $isOwner = $userTypeId == 1;

        $projectId = $this->request->params['pass'][0];

        $isUserAssigned = $this->Projects->find()
        ->matching('EmployeesJoin', function($query) use ($user) {
            return $query->where(['EmployeesJoin.user_id' => $user['id']]);
        })
        ->where(['Projects.id' => $projectId])
        ->first() !== null;
        
        return $isUserAssigned || $isOwner || $isAdmin;
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($id = null)
    {
        $this->paginate = [
            'sortWhitelist' => [
                'unit_measure',
                'available_quantity',
                'unavailable_quantity',
                'total_quantity',
                'last_modified'
            ]
        ];

        $this->paginate += $this->createFinders($this->request->query, 'Materials');

        if(!isset($this->request->query['milestone_id']))
            $this->request->query['milestone_id'] = 0;

        $this->paginate['finder']['projectInventorySummary'] = [
            'project_id' => $id,
            'milestone_id' => $this->request->query['milestone_id']
        ];

        $materials = $this->paginate(TableRegistry::get('Materials'));

        $milestones = TableRegistry::get('Milestones')->find('list')
            ->where(['project_id' => $id])
            ->toArray();

        $this->set(compact('materials', 'milestones'));
        $this->set($this->request->query);
        $this->set('_serialize', ['materials', 'milestones']);
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
        $materialId = $this->request->query['material_id'];
        $summary = TableRegistry::get('Materials')->find('projectInventorySummary', [
            'id' => $materialId,
            'project_id' => $id
        ])->first();

        $material = TableRegistry::get('Materials')->get($id, [
            'contain' => [
                'MaterialsTaskInventories' => [
                    'Tasks' => ['Milestones']
                ]
            ]
        ]);

        $this->set(compact('material', 'summary'));
        $this->set('_serialize', ['material', 'summary']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $materialsProjectInventory = $this->MaterialsProjectInventories->newEntity();
        if ($this->request->is('post')) {
            $materialsProjectInventory = $this->MaterialsProjectInventories->patchEntity($materialsProjectInventory, $this->request->data);
            if ($this->MaterialsProjectInventories->save($materialsProjectInventory)) {
                $this->Flash->success(__('The materials project inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The materials project inventory could not be saved. Please, try again.'));
            }
        }
        $materials = $this->MaterialsProjectInventories->Materials->find('list', ['limit' => 200]);
        $projects = $this->MaterialsProjectInventories->Projects->find('list', ['limit' => 200]);
        $this->set(compact('materialsProjectInventory', 'materials', 'projects'));
        $this->set('_serialize', ['materialsProjectInventory']);
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
        $materialId = $this->request->query['material_id'];
        try
        {
            $materialsProjectInventory = $this->MaterialsProjectInventories->get([
                'material_id' => $materialId,
                'project_id' => $id
            ]);
        }
        catch(RecordNotFoundException $e)
        {
            $materialsProjectInventory = $this->MaterialsProjectInventories->newEntity([
                'material_id' => $materialId,
                'project_id' => $id,
                'quantity' => 0
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $materialsProjectInventory = $this->MaterialsProjectInventories->patchEntity($materialsProjectInventory, $this->request->data);
            if ($this->MaterialsProjectInventories->save($materialsProjectInventory)) {
                $this->Flash->success(__('The materials project inventory has been saved.'));
                return $this->redirect(['action' => 'index', '?' => ['project_id' => $id]]);
            } else {
                $this->Flash->error(__('The materials project inventory could not be saved. Please, try again.'));
            }
        }
        $materials = $this->MaterialsProjectInventories->Materials->find('list', ['limit' => 200]);
        $projects = $this->MaterialsProjectInventories->Projects->find('list', ['limit' => 200]);
        $this->set(compact('materialsProjectInventory', 'materials', 'projects'));
        $this->set('_serialize', ['materialsProjectInventory']);
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
        $materialsProjectInventory = $this->MaterialsProjectInventories->get($id);
        if ($this->MaterialsProjectInventories->delete($materialsProjectInventory)) {
            $this->Flash->success(__('The materials project inventory has been deleted.'));
        } else {
            $this->Flash->error(__('The materials project inventory could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
