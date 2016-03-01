<?php
namespace App\Controller;

use App\Controller\AppController;

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
            'contain' => ['Materials']
        ];
        $materialsGeneralInventories = $this->paginate($this->MaterialsGeneralInventories);

        $this->set(compact('materialsGeneralInventories'));
        $this->set('_serialize', ['materialsGeneralInventories']);
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
        $materialsGeneralInventory = $this->MaterialsGeneralInventories->get($id, [
            'contain' => ['Materials']
        ]);

        $this->set('materialsGeneralInventory', $materialsGeneralInventory);
        $this->set('_serialize', ['materialsGeneralInventory']);
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
        $materialsGeneralInventory = $this->MaterialsGeneralInventories->get($id, [
            'contain' => []
        ]);
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
