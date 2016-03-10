<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RentalRequestHeaders Controller
 *
 * @property \App\Model\Table\RentalRequestHeadersTable $RentalRequestHeaders
 */
class RentalRequestHeadersController extends AppController
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
        $rentalRequestHeaders = $this->paginate($this->RentalRequestHeaders);

        $this->set(compact('rentalRequestHeaders'));
        $this->set('_serialize', ['rentalRequestHeaders']);
    }

    /**
     * View method
     *
     * @param string|null $id Rental Request Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rentalRequestHeader = $this->RentalRequestHeaders->get($id, [
            'contain' => ['Projects', 'Suppliers', 'RentalRequestDetails']
        ]);

        $this->set('rentalRequestHeader', $rentalRequestHeader);
        $this->set('_serialize', ['rentalRequestHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rentalRequestHeader = $this->RentalRequestHeaders->newEntity();
        if ($this->request->is('post')) {
            $rentalRequestHeader = $this->RentalRequestHeaders->patchEntity($rentalRequestHeader, $this->request->data);
            if ($this->RentalRequestHeaders->save($rentalRequestHeader)) {
                $this->Flash->success(__('The rental request header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rental request header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->RentalRequestHeaders->Projects->find('list', ['limit' => 200]);
        $suppliers = $this->RentalRequestHeaders->Suppliers->find('list', ['limit' => 200]);
        $this->set(compact('rentalRequestHeader', 'projects', 'suppliers'));
        $this->set('_serialize', ['rentalRequestHeader']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rental Request Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rentalRequestHeader = $this->RentalRequestHeaders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rentalRequestHeader = $this->RentalRequestHeaders->patchEntity($rentalRequestHeader, $this->request->data);
            if ($this->RentalRequestHeaders->save($rentalRequestHeader)) {
                $this->Flash->success(__('The rental request header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rental request header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->RentalRequestHeaders->Projects->find('list', ['limit' => 200]);
        $suppliers = $this->RentalRequestHeaders->Suppliers->find('list', ['limit' => 200]);
        $this->set(compact('rentalRequestHeader', 'projects', 'suppliers'));
        $this->set('_serialize', ['rentalRequestHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rental Request Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rentalRequestHeader = $this->RentalRequestHeaders->get($id);
        if ($this->RentalRequestHeaders->delete($rentalRequestHeader)) {
            $this->Flash->success(__('The rental request header has been deleted.'));
        } else {
            $this->Flash->error(__('The rental request header could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
