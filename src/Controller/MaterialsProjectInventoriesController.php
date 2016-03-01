<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MaterialsProjectInventories Controller
 *
 * @property \App\Model\Table\MaterialsProjectInventoriesTable $MaterialsProjectInventories
 */
class MaterialsProjectInventoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Materials', 'Projects']
        ];
        $materialsProjectInventories = $this->paginate($this->MaterialsProjectInventories);

        $this->set(compact('materialsProjectInventories'));
        $this->set('_serialize', ['materialsProjectInventories']);
    }

    /**
     * View method
     *
     * @param string|null $id Materials Project Inventory id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $materialsProjectInventory = $this->MaterialsProjectInventories->get($id, [
            'contain' => ['Materials', 'Projects']
        ]);

        $this->set('materialsProjectInventory', $materialsProjectInventory);
        $this->set('_serialize', ['materialsProjectInventory']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $materialsProjectInventory = $this->MaterialsProjectInventories->newEntity();
        if ($this->request->is('post')) {
            $materialsProjectInventory = $this->MaterialsProjectInventories->patchEntity($materialsProjectInventory, $this->request->data);
            if ($this->MaterialsProjectInventories->save($materialsProjectInventory)) {
                $this->Flash->success(__('The materials project inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The materials project inventory could not be saved. Please, try again.'));
            }
        }
        $materials = $this->MaterialsProjectInventories->Materials->find('list', ['limit' => 200]);
        $projects = $this->MaterialsProjectInventories->Projects->find('list', ['limit' => 200]);
        $this->set(compact('materialsProjectInventory', 'materials', 'projects'));
        $this->set('_serialize', ['materialsProjectInventory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Materials Project Inventory id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $materialsProjectInventory = $this->MaterialsProjectInventories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $materialsProjectInventory = $this->MaterialsProjectInventories->patchEntity($materialsProjectInventory, $this->request->data);
            if ($this->MaterialsProjectInventories->save($materialsProjectInventory)) {
                $this->Flash->success(__('The materials project inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The materials project inventory could not be saved. Please, try again.'));
            }
        }
        $materials = $this->MaterialsProjectInventories->Materials->find('list', ['limit' => 200]);
        $projects = $this->MaterialsProjectInventories->Projects->find('list', ['limit' => 200]);
        $this->set(compact('materialsProjectInventory', 'materials', 'projects'));
        $this->set('_serialize', ['materialsProjectInventory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Materials Project Inventory id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $materialsProjectInventory = $this->MaterialsProjectInventories->get($id);
        if ($this->MaterialsProjectInventories->delete($materialsProjectInventory)) {
            $this->Flash->success(__('The materials project inventory has been deleted.'));
        } else {
            $this->Flash->error(__('The materials project inventory could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
