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

        $this->set('project', $project);

        return parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];

        $userTypeId = $user['employee']['employee_type_id'];
        $isAdmin = $userTypeId === 0;
        $isOwner = $userTypeId === 1;

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
                'available_in_house_quantity',
                'available_rented_quantity',
                'unavailable_in_house_quantity',
                'unavailable_rented_quantity',
                'total_quantity',
                'last_modified'
            ]
        ];

        $this->paginate += $this->createFinders($this->request->query, 'EquipmentInventories');
        $this->paginate['finder']['projectInventorySummary'] = ['project_id' => $id];
        $equipmentInventories = $this->paginate(TableRegistry::get('EquipmentInventories'));

        $milestones = TableRegistry::get('Milestones')->find('list')
            ->where(['project_id' => $id])
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
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {   

        $equipmentId = $this->request->query['equipment_id'];

        $summary = TableRegistry::get('EquipmentInventories')->find('projectInventorySummary', [
            'id' => $equipmentId,
            'project_id' => $id
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
            $equipmentInventory->project->id === $id &&
            $equipmentInventory->has('task');
        });

        $collection = new Collection($rentedEquipmentInventories);
        $unavailableRentedEquipment = $collection->filter(function($equipmentInventory)
        {
            return $equipmentInventory->has('project') &&
            $equipmentInventory->project->id === $id &&
            $equipmentInventory->has('task');
        });

        $availableRentedEquipment = $collection->filter(function($equipmentInventory)
        {
            return $equipmentInventory->has('project') &&
            $equipmentInventory->project->id === $id &&
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
}
