<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

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
        $projects = TableRegistry::get('Projects')->find('list')->toArray();
        $suppliers = TableRegistry::get('Suppliers')->find('list')->toArray();

        $this->set(compact('rentalRequestHeaders', 'projects', 'suppliers'));
        $this->set('_serialize', ['rentalRequestHeaders', 'projects', 'suppliers']);
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
            $this->transpose($this->request->data, 'rental_request_details');
            $rentalRequestHeader = $this->RentalRequestHeaders->patchEntity($rentalRequestHeader, $this->request->data, [
                'associated' => ['RentalRequestDetails']
            ]);
            if ($this->RentalRequestHeaders->save($rentalRequestHeader)) {
                $this->Flash->success(__('The rental request header has been saved.'));
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rental request header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->RentalRequestHeaders->Projects->find('list', ['limit' => 200]);
        $suppliers = $this->RentalRequestHeaders->Suppliers->find('list', ['limit' => 200]);
        $equipment = TableRegistry::get('Equipment')->find('list', ['limit' => 200])->toArray();
        $this->set(compact('rentalRequestHeader', 'projects', 'suppliers', 'equipment'));
        $this->set('_serialize', ['rentalRequestHeader', 'projects', 'suppliers', 'equipment']);
    }
}
