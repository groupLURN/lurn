<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Equipment;
use Cake\Collection\Collection;
use Cake\Core\Exception\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;

/**
 * EquipmentGeneralInventories Controller
 *
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
                'available_in_house_quantity',
                'available_rented_quantity',
                'unavailable_in_house_quantity',
                'unavailable_rented_quantity',
                'last_modified'
            ]
        ];

        $this->paginate += $this->createFinders($this->request->query, 'EquipmentInventories');
        $this->paginate['finder']['generalInventorySummary'] = [];
        $equipmentInventories = $this->paginate(TableRegistry::get('EquipmentInventories'));

        $projects = TableRegistry::get('Projects')->find('list')->toArray();
        $suppliers = TableRegistry::get('Suppliers')->find('list')->toArray();
        $equipmentTypes = Equipment::getTypes();
        $this->set(compact('equipmentInventories', 'projects', 'equipmentTypes', 'suppliers'));
        $this->set($this->request->query);
        $this->set('_serialize', ['equipmentInventories', 'projects', 'equipmentTypes', 'suppliers']);
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
        $summary = TableRegistry::get('EquipmentInventories')->find('generalInventorySummary', ['id' => $id])
            ->first();

        $rentedEquipmentInventories = TableRegistry::get('Equipment')->get($id, [
            'contain' => [
                'RentedEquipmentInventories' => [
                    'Projects' => ['Employees', 'Clients', 'ProjectStatuses'],
                    'RentalReceiveDetails.RentalRequestDetails.RentalRequestHeaders.Suppliers',
                    'RentalReceiveDetails.RentalReceiveHeaders'
                ]
            ]
        ])->rented_equipment_inventories;

        $inHouseEquipmentInventories = TableRegistry::get('Equipment')->get($id, [
            'contain' => [
                'InHouseEquipmentInventories' => [
                    'Projects' => ['Employees', 'Clients', 'ProjectStatuses']
                ]
            ]
        ])->in_house_equipment_inventories;

        // Filter all project inventories.
        $collection = new Collection($inHouseEquipmentInventories);
        $unavailableInHouseEquipment = $collection->filter(function($equipmentInventory)
        {
            return $equipmentInventory->has('project');
        });

        $collection = new Collection($rentedEquipmentInventories);
        $unavailableRentedEquipment = $collection->filter(function($equipmentInventory)
        {
            return $equipmentInventory->has('project');
        });

        $availableRentedEquipment = $collection->filter(function($equipmentInventory)
        {
            return !$equipmentInventory->has('project');
        });

        // Group By project id
        $unavailableInHouseEquipmentByProject = $unavailableInHouseEquipment->groupBy('project_id');
        $unavailableRentedEquipmentByProject = $unavailableRentedEquipment->groupBy('project_id');
        $availableRentedEquipmentByRental = $availableRentedEquipment->groupBy('rental_receive_detail_id');

        $unavailableInHouseEquipment = $unavailableRentedEquipment = [];
        foreach($unavailableInHouseEquipmentByProject as $row)
        {
            $unavailableInHouseEquipment[] = [
                'quantity' => count($row),
                'project' => $row[0]->project
            ];
        }

        foreach($unavailableRentedEquipmentByProject as $row)
        {
            $collection = new Collection($row);
            $details = $collection->groupBy('rental_receive_detail_id');
            $unavailableRentedEquipment[] = [
                'quantity' => count($row),
                'project' => $row[0]->project,
                'details' => $details->toList()
            ];
        }

        // Complete the collapsible feature to display the breakdown of the rental equipment detail.
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
        $equipment = TableRegistry::get('Equipment')->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            if (TableRegistry::get('Equipment')->adjustInHouseInventory($equipment, $this->request->data['quantity'])) {
                $this->Flash->success(__('The equipment general inventory has been adjusted.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The equipment general inventory could not be adjusted. Please, try again.'));
            }
        }

        $this->set(compact('equipment'));
        $this->set('_serialize', ['equipment']);
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
