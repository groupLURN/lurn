<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RentalReceiveHeaders Controller
 *
 * @property \App\Model\Table\RentalReceiveHeadersTable $RentalReceiveHeaders
 */
class RentalReceiveHeadersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['RentalRequestHeaders']
        ];
        $rentalReceiveHeaders = $this->paginate($this->RentalReceiveHeaders);

        $this->set(compact('rentalReceiveHeaders'));
        $this->set('_serialize', ['rentalReceiveHeaders']);
    }

    /**
     * View method
     *
     * @param string|null $id Rental Receive Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rentalReceiveHeader = $this->RentalReceiveHeaders->get($id, [
            'contain' => ['RentalRequestHeaders', 'RentalReceiveDetails']
        ]);

        $this->set('rentalReceiveHeader', $rentalReceiveHeader);
        $this->set('_serialize', ['rentalReceiveHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rentalReceiveHeader = $this->RentalReceiveHeaders->newEntity();
        if ($this->request->is('post')) {
            $rentalReceiveHeader = $this->RentalReceiveHeaders->patchEntity($rentalReceiveHeader, $this->request->data);
            if ($this->RentalReceiveHeaders->save($rentalReceiveHeader)) {
                $this->Flash->success(__('The rental receive header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rental receive header could not be saved. Please, try again.'));
            }
        }
        $rentalRequestHeaders = $this->RentalReceiveHeaders->RentalRequestHeaders->find('list', ['limit' => 200]);
        $this->set(compact('rentalReceiveHeader', 'rentalRequestHeaders'));
        $this->set('_serialize', ['rentalReceiveHeader']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rental Receive Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rentalReceiveHeader = $this->RentalReceiveHeaders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rentalReceiveHeader = $this->RentalReceiveHeaders->patchEntity($rentalReceiveHeader, $this->request->data);
            if ($this->RentalReceiveHeaders->save($rentalReceiveHeader)) {
                $this->Flash->success(__('The rental receive header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rental receive header could not be saved. Please, try again.'));
            }
        }
        $rentalRequestHeaders = $this->RentalReceiveHeaders->RentalRequestHeaders->find('list', ['limit' => 200]);
        $this->set(compact('rentalReceiveHeader', 'rentalRequestHeaders'));
        $this->set('_serialize', ['rentalReceiveHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rental Receive Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rentalReceiveHeader = $this->RentalReceiveHeaders->get($id);
        if ($this->RentalReceiveHeaders->delete($rentalReceiveHeader)) {
            $this->Flash->success(__('The rental receive header has been deleted.'));
        } else {
            $this->Flash->error(__('The rental receive header could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
