<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * EquipmentProjectInventories Controller
 *
 * @property \App\Model\Table\EquipmentProjectInventoriesTable $EquipmentProjectInventories
 */
class EquipmentProjectInventoriesController extends AppController
{
    private $_projectId = null;

    public function beforeFilter(Event $event)
    {
        if(!isset($this->request->query['project_id']))
            return $this->redirect(['controller' => 'dashboard']);

        $this->viewBuilder()->layout('project_management');
        $this->_projectId = (int) $this->request->query['project_id'];

        $this->set('projectId', $this->_projectId);
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
            'sortWhitelist' => [
                'available_quantity',
                'unavailable_quantity',
                'total_quantity',
                'last_modified'
            ]
        ];

        $this->paginate += $this->createFinders($this->request->query, 'EquipmentInventories');
        $this->paginate['finder']['projectInventorySummary'] = ['project_id' => $this->_projectId];
        $equipmentInventories = $this->paginate(TableRegistry::get('EquipmentInventories'));

        $milestones = TableRegistry::get('Milestones')->find('list')
            ->where(['project_id' => $this->_projectId])
            ->toArray();

        $this->set(compact('equipmentInventories', 'milestones'));
        $this->set($this->request->query);
        $this->set('_serialize', ['equipmentInventories', 'milestones']);
    }

    /**
     * View method
     *
     * @param string|null $id Equipment Project Inventory id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $summary = TableRegistry::get('EquipmentInventories')->find('projectInventorySummary', [
            'id' => $id,
            'project_id' => $this->_projectId
        ])->first();

        $equipmentInventories = TableRegistry::get('EquipmentInventories')->find()
            ->contain(['Equipment', 'Tasks' => ['Milestones']])
            ->matching('Equipment', function($query) use ($id)
            {
                return $query->where(['Equipment.id' => $id]);
            })
            ->where(['EquipmentInventories.project_id' => $this->_projectId])
            ->orderAsc('Milestones.title')
            ->toArray();

        $collection = new Collection($equipmentInventories);

        $unavailableEquipment = $collection->filter(function($equipmentInventories)
        {
            return $equipmentInventories->has('task');
        });

        $unavailableEquipmentByTask = $unavailableEquipment->groupBy('task_id');

        $details = [];
        foreach($unavailableEquipmentByTask as $row)
            $details[] = [
                'quantity' => count($row),
                'task' => $row[0]->task
            ];

        $this->set(compact('details', 'summary'));
        $this->set('_serialize', ['details', 'summary']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $equipmentProjectInventory = $this->EquipmentProjectInventories->newEntity();
        if ($this->request->is('post')) {
            $equipmentProjectInventory = $this->EquipmentProjectInventories->patchEntity($equipmentProjectInventory, $this->request->data);
            if ($this->EquipmentProjectInventories->save($equipmentProjectInventory)) {
                $this->Flash->success(__('The equipment project inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The equipment project inventory could not be saved. Please, try again.'));
            }
        }
        $equipment = $this->EquipmentProjectInventories->Equipment->find('list', ['limit' => 200]);
        $projects = $this->EquipmentProjectInventories->Projects->find('list', ['limit' => 200]);
        $this->set(compact('equipmentProjectInventory', 'equipment', 'projects'));
        $this->set('_serialize', ['equipmentProjectInventory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Equipment Project Inventory id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try
        {
            $equipmentProjectInventory = $this->EquipmentProjectInventories->get([
                'equipment_id' => $id,
                'project_id' => $this->_projectId
            ]);
        }
        catch(RecordNotFoundException $e)
        {
            $equipmentProjectInventory = $this->EquipmentProjectInventories->newEntity([
                'equipment_id' => $id,
                'project_id' => $this->_projectId,
                'quantity' => 0
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipmentProjectInventory = $this->EquipmentProjectInventories->patchEntity($equipmentProjectInventory, $this->request->data);
            if ($this->EquipmentProjectInventories->save($equipmentProjectInventory)) {
                $this->Flash->success(__('The equipment project inventory has been saved.'));
                return $this->redirect(['action' => 'index', '?' => ['project_id' => $this->_projectId]]);
            } else {
                $this->Flash->error(__('The equipment project inventory could not be saved. Please, try again.'));
            }
        }
        $equipment = $this->EquipmentProjectInventories->Equipment->find('list', ['limit' => 200]);
        $projects = $this->EquipmentProjectInventories->Projects->find('list', ['limit' => 200]);
        $this->set(compact('equipmentProjectInventory', 'equipment', 'projects'));
        $this->set('_serialize', ['equipmentProjectInventory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Equipment Project Inventory id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $equipmentProjectInventory = $this->EquipmentProjectInventories->get($id);
        if ($this->EquipmentProjectInventories->delete($equipmentProjectInventory)) {
            $this->Flash->success(__('The equipment project inventory has been deleted.'));
        } else {
            $this->Flash->error(__('The equipment project inventory could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
