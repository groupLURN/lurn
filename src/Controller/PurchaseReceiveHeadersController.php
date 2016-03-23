<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;

/**
 * PurchaseReceiveHeaders Controller
 *
 * @property \App\Model\Table\PurchaseReceiveHeadersTable $PurchaseReceiveHeaders
 */
class PurchaseReceiveHeadersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'sortWhitelist' => ['PurchaseReceiveHeaders.id', 'PurchaseOrderHeaders.id', 'Projects.title', 'Suppliers.name', 'PurchaseOrderHeaders.created', 'PurchaseReceiveHeaders.created']
        ];

        $this->paginate += $this->createFinders($this->request->query);
        $this->paginate['finder']['PurchaseReceives'] = [];
        $purchaseReceiveHeaders = $this->paginate($this->PurchaseReceiveHeaders);

        $projects = $this->PurchaseReceiveHeaders->PurchaseReceiveDetails->PurchaseOrderDetails->PurchaseOrderHeaders->Projects->find('list')->toArray();
        $suppliers = $this->PurchaseReceiveHeaders->PurchaseReceiveDetails->PurchaseOrderDetails->PurchaseOrderHeaders->Suppliers->find('list')->toArray();

        $this->set($this->request->query);
        $this->set(compact('purchaseReceiveHeaders', 'projects', 'suppliers'));
        $this->set('_serialize', ['purchaseReceiveHeaders', 'projects', 'suppliers']);
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Receive Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchaseReceiveHeader = $this->PurchaseReceiveHeaders->get($id, [
            'contain' => ['PurchaseReceiveDetails']
        ]);

        $this->set('purchaseReceiveHeader', $purchaseReceiveHeader);
        $this->set('_serialize', ['purchaseReceiveHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $purchaseReceiveHeader = $this->PurchaseReceiveHeaders->newEntity();
        if ($this->request->is('post')) {
            $this->transpose($this->request->data, 'purchase_receive_details');

            $purchaseReceiveHeader = $this->PurchaseReceiveHeaders->patchEntity($purchaseReceiveHeader, $this->request->data);

            if ($this->PurchaseReceiveHeaders->save($purchaseReceiveHeader)) {
                $this->Flash->success(__('The purchase receive number ' . $purchaseReceiveHeader->number . ' has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The purchase receive header could not be saved. Please, try again.'));
            }
        }
        $materials = TableRegistry::get('Materials')->find('list')->toArray();

        // Retrieve incomplete purchase requests.
        $purchaseOrderHeaders = $this->PurchaseReceiveHeaders->PurchaseReceiveDetails->PurchaseOrderDetails
            ->PurchaseOrderHeaders
            ->find()
            ->contain(['Projects', 'Suppliers', 'PurchaseOrderDetails' => [
                'Materials', 'PurchaseReceiveDetails']
            ])
            ->toArray();

        foreach($purchaseOrderHeaders as $purchaseOrderHeader)
        {
            $this->PurchaseReceiveHeaders->PurchaseReceiveDetails->PurchaseOrderDetails->PurchaseOrderHeaders->computeQuantityRemaining($purchaseOrderHeader)
                ->computeAllQuantityReceived($purchaseOrderHeader);
        }

        $collection = new Collection($purchaseOrderHeaders);
        $incompleteOrders = $collection->filter(function ($request, $key) {
            return $request->all_quantity_received === false;
        });

        $purchaseOrderHeaders = [];
        foreach($incompleteOrders as $incompleteOrder)
            $purchaseOrderHeaders[$incompleteOrder->id] = $incompleteOrder->id;

        $this->set(compact('purchaseReceiveHeader', 'purchaseOrderHeaders', 'materials'));
        $this->set('_serialize', ['purchaseReceiveHeader', 'purchaseOrderHeaders', 'materials']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Receive Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchaseReceiveHeader = $this->PurchaseReceiveHeaders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseReceiveHeader = $this->PurchaseReceiveHeaders->patchEntity($purchaseReceiveHeader, $this->request->data);
            if ($this->PurchaseReceiveHeaders->save($purchaseReceiveHeader)) {
                $this->Flash->success(__('The purchase receive header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The purchase receive header could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('purchaseReceiveHeader'));
        $this->set('_serialize', ['purchaseReceiveHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Receive Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseReceiveHeader = $this->PurchaseReceiveHeaders->get($id);
        if ($this->PurchaseReceiveHeaders->delete($purchaseReceiveHeader)) {
            $this->Flash->success(__('The purchase receive header has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase receive header could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
