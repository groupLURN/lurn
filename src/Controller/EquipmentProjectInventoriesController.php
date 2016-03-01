<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EquipmentProjectInventories Controller
 *
 * @property \App\Model\Table\EquipmentProjectInventoriesTable $EquipmentProjectInventories
 */
class EquipmentProjectInventoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Equipment', 'Projects']
        ];
        $equipmentProjectInventories = $this->paginate($this->EquipmentProjectInventories);

        $this->set(compact('equipmentProjectInventories'));
        $this->set('_serialize', ['equipmentProjectInventories']);
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
        $equipmentProjectInventory = $this->EquipmentProjectInventories->get($id, [
            'contain' => ['Equipment', 'Projects']
        ]);

        $this->set('equipmentProjectInventory', $equipmentProjectInventory);
        $this->set('_serialize', ['equipmentProjectInventory']);
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
        $equipmentProjectInventory = $this->EquipmentProjectInventories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
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
