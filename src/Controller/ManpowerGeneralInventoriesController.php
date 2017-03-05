<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Core\Exception\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;

/**
 * ManpowerGeneralInventories Controller
 *
 * @property \App\Model\Table\ManpowerTable $Manpower
 */
class ManpowerGeneralInventoriesController extends AppController
{
    public function isAuthorized($user)
    {        
        $employeeTypeId = isset($user['employee']['employee_type_id'])
            ? $user['employee']['employee_type_id'] : '';
        return in_array($employeeTypeId, [0, 4], true);
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

        $this->paginate += $this->createFinders($this->request->query, 'Manpower');
        $this->paginate['finder']['generalInventorySummary'] = [];
        $manpower = $this->paginate(TableRegistry::get('Manpower'));
        $manpowerTypes = $this->Manpower->ManpowerTypes->find('list', ['limit' => 200])->toArray();
        $projects = TableRegistry::get('Projects')->find('list')->toArray();

        $this->set(compact('manpower', 'manpowerTypes', 'projects'));
        $this->set($this->request->query);
        $this->set('_serialize', ['manpower', 'manpowerTypes', 'projects']);
    }

    /**
     * View method
     *
     * @param string|null $id Manpower General Inventory id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $summary = TableRegistry::get('Manpower')->find('generalInventorySummary', ['id' => $id])
            ->first();

        $manpower = TableRegistry::get('ManpowerTypes')->get($id, [
            'contain' => [
                'Manpower' => [
                    'Projects' => ['Employees', 'Clients']
                ]
            ]
        ])->manpower;

        foreach($manpower as $manpower_)
            if(isset($manpower_->project))
                TableRegistry::get('Projects')->computeProjectStatus($manpower_->project);

        $collection = new Collection($manpower);


        $availableManpower = $collection->filter(function($manpower)
        {
            return !$manpower->has('project');
        });

        $unavailableManpower = $collection->filter(function($manpower)
        {
            return $manpower->has('project');
        });

        $unavailableManpowerByProject = $unavailableManpower->groupBy('project_id');

        $this->set(compact('summary', 'availableManpower', 'unavailableManpowerByProject'));
        $this->set('_serialize', ['summary', 'availableManpower', 'unavailableManpowerByProject']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Manpower General Inventory id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try
        {
            $equipmentGeneralInventory = $this->ManpowerGeneralInventories->get($id);
        }
        catch(RecordNotFoundException $e)
        {
            $equipmentGeneralInventory = $this->ManpowerGeneralInventories->newEntity([
                'equipment_id' => $id,
                'quantity' => 0
            ]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipmentGeneralInventory = $this->ManpowerGeneralInventories->patchEntity($equipmentGeneralInventory, $this->request->data);
            if ($this->ManpowerGeneralInventories->save($equipmentGeneralInventory)) {
                $this->Flash->success(__('The equipment general inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The equipment general inventory could not be saved. Please, try again.'));
            }
        }
        $equipment = $this->ManpowerGeneralInventories->Manpower->find('list', ['limit' => 200]);
        $this->set(compact('equipmentGeneralInventory', 'equipment'));
        $this->set('_serialize', ['equipmentGeneralInventory']);
    }
}
