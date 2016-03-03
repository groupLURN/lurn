<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Core\Exception\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;

/**
 * EquipmentGeneralInventories Controller
 *
 * @property \App\Model\Table\EquipmentGeneralInventoriesTable $EquipmentGeneralInventories
 */
class EquipmentGeneralInventoriesController extends AppController
{

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

        $this->paginate += $this->createFinders($this->request->query, 'Equipment');
        $this->paginate['finder']['generalInventorySummary'] = [];
        $equipment = $this->paginate(TableRegistry::get('Equipment'));

        $this->set(compact('equipment'));
        $this->set($this->request->query);
        $this->set('_serialize', ['equipment']);
    }

    /**
     * View method
     *
     * @param string|null $id Equipment General Inventory id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $summary = TableRegistry::get('Equipment')->find('generalInventorySummary', ['id' => $id])->first();

        $equipment = TableRegistry::get('Equipment')->get($id, [
            'contain' => [
                'EquipmentProjectInventories' => [
                    'Projects' => ['Clients', 'Employees', 'ProjectStatuses'],
                    'EquipmentTaskInventories'
                ]
            ]
        ]);

        foreach($equipment->equipment_project_inventories as &$projectInventory)
        {
            $collection = new Collection($projectInventory->equipment_task_inventories);
            $projectInventory->quantity += $collection->reduce(function($accumulated, $taskInventory)
            {
                return $accumulated + $taskInventory->quantity;
            }, 0);
        }
        unset($projectInventory);
        $this->set(compact('equipment', 'summary'));
        $this->set('_serialize', ['equipment', 'summary']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $equipmentGeneralInventory = $this->EquipmentGeneralInventories->newEntity();
        if ($this->request->is('post')) {
            $equipmentGeneralInventory = $this->EquipmentGeneralInventories->patchEntity($equipmentGeneralInventory, $this->request->data);
            if ($this->EquipmentGeneralInventories->save($equipmentGeneralInventory)) {
                $this->Flash->success(__('The equipment general inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The equipment general inventory could not be saved. Please, try again.'));
            }
        }
        $equipment = $this->EquipmentGeneralInventories->Equipment->find('list', ['limit' => 200]);
        $this->set(compact('equipmentGeneralInventory', 'equipment'));
        $this->set('_serialize', ['equipmentGeneralInventory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Equipment General Inventory id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try
        {
            $equipmentGeneralInventory = $this->EquipmentGeneralInventories->get($id);
        }
        catch(RecordNotFoundException $e)
        {
            $equipmentGeneralInventory = $this->EquipmentGeneralInventories->newEntity([
                'equipment_id' => $id,
                'quantity' => 0
            ]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipmentGeneralInventory = $this->EquipmentGeneralInventories->patchEntity($equipmentGeneralInventory, $this->request->data);
            if ($this->EquipmentGeneralInventories->save($equipmentGeneralInventory)) {
                $this->Flash->success(__('The equipment general inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The equipment general inventory could not be saved. Please, try again.'));
            }
        }
        $equipment = $this->EquipmentGeneralInventories->Equipment->find('list', ['limit' => 200]);
        $this->set(compact('equipmentGeneralInventory', 'equipment'));
        $this->set('_serialize', ['equipmentGeneralInventory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Equipment General Inventory id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $equipmentGeneralInventory = $this->EquipmentGeneralInventories->get($id);
        if ($this->EquipmentGeneralInventories->delete($equipmentGeneralInventory)) {
            $this->Flash->success(__('The equipment general inventory has been deleted.'));
        } else {
            $this->Flash->error(__('The equipment general inventory could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
