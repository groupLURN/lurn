<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;

/**
 * PurchaseReceiveHeaders Controller
 *
 * @property \App\Model\Table\PurchaseReceiveHeadersTable $PurchaseReceiveHeaders
 */
class PurchaseReceiveHeadersController extends AppController
{
    public function isAuthorized($user)
    {        
        return in_array($user['user_type_id'], [0, 4]);
    }
    
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
        $purchaseReceiveHeader = $this->PurchaseReceiveHeaders->find('byId', ['id' => $id])->first();

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
                $this->loadModel('Notifications');
                $this->loadModel('Projects');
                $employees = [];

                $purchaseReceive = $this->PurchaseReceiveHeaders->find('byId',['id'=>$purchaseReceiveHeader->id])->first();

                $projectId = 0;

                if(count($purchaseReceive->purchase_receive_details) > 0){
                    $tempPurchaseReceiveDetail = $purchaseReceive->purchase_receive_details[0];
                    $projectId = $tempPurchaseReceiveDetail->purchase_order_detail->purchase_order_header->project_id;
                }

                $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();

                array_push($employees, $project->employee);
                for ($i=0; $i < count($project->employees_join); $i++) { 
                    $employeeType = $project->employees_join[$i]->employee_type_id;
                    if($employeeType == 1 || $employeeType == 4) {
                        array_push($employees, $project->employees_join[$i]);
                    }
                }

                foreach ($employees as $employee) {
                    $notification = $this->Notifications->newEntity();
                    $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'purchase-receive-headers', 'action' => 'view/'. $purchaseReceiveHeader->id ], false));
                    $notification->link = $link;
                    $notification->message = '<b>'.$project->title.'\'s</b> purchase order has been received. Click to see the purchase receive.';
                    $notification->user_id = $employee['user_id'];
                    $notification->project_id = $purchaseReceiveHeader->project_id;
                    $this->Notifications->save($notification);
                }

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
