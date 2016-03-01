<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;

/**
 * MaterialsGeneralInventories Controller
 *
 * @property \App\Model\Table\MaterialsGeneralInventoriesTable $MaterialsGeneralInventories
 */
class MaterialsGeneralInventoriesController extends AppController
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
                'unit_measure',
                'available_quantity',
                'unavailable_quantity',
                'total_quantity',
                'last_modified'
            ]
        ];

        $this->paginate += $this->createFinders($this->request->query, 'Materials');
        $this->paginate['finder']['generalInventorySummary'] = [];
        $materials = $this->paginate(TableRegistry::get('Materials'));

        $this->set(compact('materials'));
        $this->set($this->request->query);
        $this->set('_serialize', ['materials']);
    }

    /**
     * View method
     *
     * @param string|null $id Materials General Inventory id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $summary = TableRegistry::get('Materials')->find('generalInventorySummary', ['id' => $id])->first();

        $material = TableRegistry::get('Materials')->get($id, [
            'contain' => [
                'MaterialsGeneralInventories', 'MaterialsProjectInventories' => [
                    'Projects' => ['Clients', 'Employees', 'ProjectStatuses']
                ],
                'MaterialsTaskInventories'
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
        $materialsGeneralInventory = $this->MaterialsGeneralInventories->newEntity();
        if ($this->request->is('post')) {
            $materialsGeneralInventory = $this->MaterialsGeneralInventories->patchEntity($materialsGeneralInventory, $this->request->data);
            if ($this->MaterialsGeneralInventories->save($materialsGeneralInventory)) {
                $this->Flash->success(__('The materials general inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The materials general inventory could not be saved. Please, try again.'));
            }
        }
        $materials = $this->MaterialsGeneralInventories->Materials->find('list', ['limit' => 200]);
        $this->set(compact('materialsGeneralInventory', 'materials'));
        $this->set('_serialize', ['materialsGeneralInventory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Materials General Inventory id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try
        {
            $materialsGeneralInventory = $this->MaterialsGeneralInventories->get($id);
        }
        catch(RecordNotFoundException $e)
        {
            $materialsGeneralInventory = $this->MaterialsGeneralInventories->newEntity([
                'material_id' => $id,
                'quantity' => 0
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $materialsGeneralInventory = $this->MaterialsGeneralInventories->patchEntity($materialsGeneralInventory, $this->request->data);
            if ($this->MaterialsGeneralInventories->save($materialsGeneralInventory)) {
                $this->Flash->success(__('The materials general inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The materials general inventory could not be saved. Please, try again.'));
            }
        }
        $materials = $this->MaterialsGeneralInventories->Materials->find('list', ['limit' => 200]);
        $this->set(compact('materialsGeneralInventory', 'materials'));
        $this->set('_serialize', ['materialsGeneralInventory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Materials General Inventory id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $materialsGeneralInventory = $this->MaterialsGeneralInventories->get($id);
        if ($this->MaterialsGeneralInventories->delete($materialsGeneralInventory)) {
            $this->Flash->success(__('The materials general inventory has been deleted.'));
        } else {
            $this->Flash->error(__('The materials general inventory could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
