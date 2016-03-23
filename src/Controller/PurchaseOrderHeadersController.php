<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PurchaseOrderHeaders Controller
 *
 * @property \App\Model\Table\PurchaseOrderHeadersTable $PurchaseOrderHeaders
 */
class PurchaseOrderHeadersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projects', 'Suppliers']
        ];
        $purchaseOrderHeaders = $this->paginate($this->PurchaseOrderHeaders);

        $this->set(compact('purchaseOrderHeaders'));
        $this->set('_serialize', ['purchaseOrderHeaders']);
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Order Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchaseOrderHeader = $this->PurchaseOrderHeaders->get($id, [
            'contain' => ['Projects', 'Suppliers', 'PurchaseOrderDetails']
        ]);

        $this->set('purchaseOrderHeader', $purchaseOrderHeader);
        $this->set('_serialize', ['purchaseOrderHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $purchaseOrderHeader = $this->PurchaseOrderHeaders->newEntity();
        if ($this->request->is('post')) {
            $purchaseOrderHeader = $this->PurchaseOrderHeaders->patchEntity($purchaseOrderHeader, $this->request->data);
            if ($this->PurchaseOrderHeaders->save($purchaseOrderHeader)) {
                $this->Flash->success(__('The purchase order header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The purchase order header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->PurchaseOrderHeaders->Projects->find('list', ['limit' => 200]);
        $suppliers = $this->PurchaseOrderHeaders->Suppliers->find('list', ['limit' => 200]);
        $this->set(compact('purchaseOrderHeader', 'projects', 'suppliers'));
        $this->set('_serialize', ['purchaseOrderHeader']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Order Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchaseOrderHeader = $this->PurchaseOrderHeaders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseOrderHeader = $this->PurchaseOrderHeaders->patchEntity($purchaseOrderHeader, $this->request->data);
            if ($this->PurchaseOrderHeaders->save($purchaseOrderHeader)) {
                $this->Flash->success(__('The purchase order header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The purchase order header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->PurchaseOrderHeaders->Projects->find('list', ['limit' => 200]);
        $suppliers = $this->PurchaseOrderHeaders->Suppliers->find('list', ['limit' => 200]);
        $this->set(compact('purchaseOrderHeader', 'projects', 'suppliers'));
        $this->set('_serialize', ['purchaseOrderHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Order Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseOrderHeader = $this->PurchaseOrderHeaders->get($id);
        if ($this->PurchaseOrderHeaders->delete($purchaseOrderHeader)) {
            $this->Flash->success(__('The purchase order header has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase order header could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
