<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Equipment;
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
                'available_in_house_quantity',
                'available_rented_quantity',
                'unavailable_in_house_quantity',
                'unavailable_rented_quantity',
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

        $suppliers = TableRegistry::get('Suppliers')->find('list')->toArray();
        $equipmentTypes = Equipment::getTypes();
        $this->set(compact('equipmentInventories', 'milestones', 'suppliers', 'equipmentTypes'));
        $this->set($this->request->query);
        $this->set('_serialize', ['equipmentInventories', 'milestones', 'suppliers', 'equipmentTypes']);
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

        $rentedEquipmentInventories = TableRegistry::get('Equipment')->get($id, [
            'contain' => [
                'RentedEquipmentInventories' => [
                    'Tasks' => ['Milestones'],
                    'Projects',
                    'RentalReceiveDetails.RentalRequestDetails.RentalRequestHeaders.Suppliers',
                    'RentalReceiveDetails.RentalReceiveHeaders'
                ]
            ]
        ])->rented_equipment_inventories;

        $inHouseEquipmentInventories = TableRegistry::get('Equipment')->get($id, [
            'contain' => [
                'InHouseEquipmentInventories' => [
                    'Tasks' => ['Milestones'],
                    'Projects'
                ]
            ]
        ])->in_house_equipment_inventories;

        // Filter all task inventories.
        $collection = new Collection($inHouseEquipmentInventories);
        $unavailableInHouseEquipment = $collection->filter(function($equipmentInventory)
        {
            return $equipmentInventory->has('project') &&
            $equipmentInventory->project->id === $this->_projectId &&
            $equipmentInventory->has('task');
        });

        $collection = new Collection($rentedEquipmentInventories);
        $unavailableRentedEquipment = $collection->filter(function($equipmentInventory)
        {
            return $equipmentInventory->has('project') &&
            $equipmentInventory->project->id === $this->_projectId &&
            $equipmentInventory->has('task');
        });

        $availableRentedEquipment = $collection->filter(function($equipmentInventory)
        {
            return $equipmentInventory->has('project') &&
            $equipmentInventory->project->id === $this->_projectId &&
            !$equipmentInventory->has('task');
        });

        // Group By task id
        $unavailableInHouseEquipmentByTask = $unavailableInHouseEquipment->groupBy('task_id');
        $unavailableRentedEquipmentByTask = $unavailableRentedEquipment->groupBy('task_id');
        $availableRentedEquipmentByRental = $availableRentedEquipment->groupBy('rental_receive_detail_id');

        $unavailableInHouseEquipment = $unavailableRentedEquipment = [];
        foreach($unavailableInHouseEquipmentByTask as $row)
        {
            $unavailableInHouseEquipment[] = [
                'quantity' => count($row),
                'task' => $row[0]->task
            ];
        }

        foreach($unavailableRentedEquipmentByTask as $row)
        {
            $collection = new Collection($row);
            $details = $collection->groupBy('rental_receive_detail_id');
            $unavailableRentedEquipment[] = [
                'quantity' => count($row),
                'task' => $row[0]->task,
                'details' => $details->toList()
            ];
        }

        $this->set(compact('unavailableInHouseEquipment', 'unavailableRentedEquipment', 'availableRentedEquipmentByRental', 'summary'));
        $this->set('_serialize', ['unavailableInHouseEquipment', 'unavailableRentedEquipment', 'availableRentedEquipmentByRental', 'summary']);
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
