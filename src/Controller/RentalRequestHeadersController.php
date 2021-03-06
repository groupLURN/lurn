<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
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
        $this->paginate += $this->createFinders($this->request->query);
        $rentalRequestHeaders = $this->paginate($this->RentalRequestHeaders);
        $projects = TableRegistry::get('Projects')->find('list')->toArray();
        $suppliers = TableRegistry::get('Suppliers')->find('list')->toArray();

        $this->set(compact('rentalRequestHeaders', 'projects', 'suppliers'));
        $this->set($this->request->query);
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
            'contain' => ['Projects', 'Suppliers', 'RentalRequestDetails' => [
                'Equipment', 'RentalReceiveDetails']
            ]
        ]);

        $this->RentalRequestHeaders->computeQuantityRemaining($rentalRequestHeader);
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
                $this->Flash->success(__('The rental request number ' . $rentalRequestHeader->number . ' has been saved.'));
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rental request could not be saved. Please, try again.'));
            }
        }
        $projects = $this->RentalRequestHeaders->Projects->find('list', ['limit' => 200])->toArray();
        $suppliers = $this->RentalRequestHeaders->Suppliers->find('list', ['limit' => 200]);
        $equipment = TableRegistry::get('Equipment')->find('list', ['limit' => 200])->toArray();
        $this->set(compact('rentalRequestHeader', 'projects', 'suppliers', 'equipment'));
        $this->set('_serialize', ['rentalRequestHeader', 'projects', 'suppliers', 'equipment']);
    }
}
