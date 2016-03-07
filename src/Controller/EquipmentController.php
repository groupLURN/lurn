<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Equipment Controller
 *
 * @property \App\Model\Table\EquipmentTable $Equipment
 */
class EquipmentController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = $this->createFinders($this->request->query, 'EquipmentInventories') + [
                'contain' => ['Equipment']
        ];

        $equipmentInventories = $this->paginate(TableRegistry::get('EquipmentInventories'));

        $this->set(compact('equipmentInventories'));
        $this->set($this->request->query);
        $this->set('_serialize', ['equipmentInventories']);
    }

    /**
     * View method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $equipment = $this->Equipment->get($id, [
            'contain' => []
        ]);

        $this->set('equipment', $equipment);
        $this->set('_serialize', ['equipment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $equipmentInventory = TableRegistry::get('EquipmentInventories')->newEntity();

        if ($this->request->is('post')) {
            $equipment = $this->Equipment->find()->where(['name' => $this->request->data['Equipment']['name']])->first();
            if($equipment === null)
                $equipment = $this->Equipment->newEntity($this->request->data['Equipment']);

            $equipmentInventory = TableRegistry::get('EquipmentInventories')->patchEntity($equipmentInventory, $this->request->data);
            $equipmentInventory->equipment = $equipment;

            if (TableRegistry::get('EquipmentInventories')->save($equipmentInventory)) {
                $this->Flash->success(__('The equipment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The equipment could not be saved. Please, try again.'));
            }
        }

        $equipmentArray = $this->Equipment->find('all')->select('name')->toArray();

        $names = [];
        foreach($equipmentArray as $item)
            $names[] = $item['name'];

        $this->set(compact('equipmentInventory'));
        $this->set('_serialize', ['equipmentInventory']);
        $this->set('_backEnd', [
            [
            'autocomplete' => $names
            ]
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $equipment = $this->Equipment->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipment = $this->Equipment->patchEntity($equipment, $this->request->data);
            if ($this->Equipment->save($equipment)) {
                $this->Flash->success(__('The equipment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The equipment could not be saved. Please, try again.'));
            }
        }

        $equipmentArray = $this->Equipment->find('all')->select('name')->toArray();

        $names = [];
        foreach($equipmentArray as $item)
            $names[] = $item['name'];

        $this->set(compact('equipment'));
        $this->set('_serialize', ['equipment']);
        $this->set('_backEnd', [
            [
                'autocomplete' => $names
            ]
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $equipment = $this->Equipment->get($id);
        if ($this->Equipment->delete($equipment)) {
            $this->Flash->success(__('The equipment has been deleted.'));
        } else {
            $this->Flash->error(__('The equipment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
