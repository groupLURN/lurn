<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Collection\Collection;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * RentalReceiveHeaders Controller
 *
 * @property \App\Model\Table\RentalReceiveHeadersTable $RentalReceiveHeaders
 */
class RentalReceiveHeadersController extends AppController
{
    public function isAuthorized($user)
    {        
        $employeeTypeId = isset($user['employee']['employee_type_id'])
            ? $user['employee']['employee_type_id'] : '';
        return in_array($employeeTypeId, [0, 4], true);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'sortWhitelist' => ['RentalReceiveHeaders.id', 'RentalRequestHeaders.id', 'Projects.title', 'Suppliers.name', 'RentalRequestHeaders.created', 'RentalReceiveHeaders.created']
        ];

        $this->paginate += $this->createFinders($this->request->query);
        $this->paginate['finder']['RentalReceives'] = [];
        $rentalReceiveHeaders = $this->paginate($this->RentalReceiveHeaders);

        $projects = $this->RentalReceiveHeaders->RentalReceiveDetails->RentalRequestDetails->RentalRequestHeaders->Projects->find('list')->toArray();
        $suppliers = $this->RentalReceiveHeaders->RentalReceiveDetails->RentalRequestDetails->RentalRequestHeaders->Suppliers->find('list')->toArray();
        $equipment = TableRegistry::get('Equipment')->find('list')->toArray();
        $this->set(compact('rentalReceiveHeaders', 'projects', 'suppliers', 'equipment'));
        $this->set($this->request->query);
        $this->set('_serialize', ['rentalReceiveHeaders', 'projects', 'suppliers', 'equipment']);
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
        $rentalReceiveHeader = $this->RentalReceiveHeaders->find('byId', ['id' => $id])->first();

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

            $this->transpose($this->request->data, 'rental_receive_details');

            foreach($this->request->data['rental_receive_details'] as &$rentalReceiveDetail)
            {
                $rentalReceiveDetail['start_date'] = $this->request->data['receive_date'];
                $rentalReceiveDetail['end_date'] = Time::parse($this->request->data['receive_date'])->addDays($rentalReceiveDetail['duration'])->jsonSerialize();
            }
            unset($rentalReceiveDetail);

            $rentalReceiveHeader = $this->RentalReceiveHeaders->patchEntity($rentalReceiveHeader, $this->request->data);

            if ($this->RentalReceiveHeaders->save($rentalReceiveHeader)) {
                $this->loadModel('Notifications');
                $this->loadModel('Projects');
                $employees = [];

                $rentalReceive = $this->RentalReceiveHeaders->find('byId',['id'=>$rentalReceiveHeader->id])->first();

                $projectId = 0;

                if(count($rentalReceive->rental_receive_details) > 0){
                    $tempRentalReceiveDetail = $rentalReceive->rental_receive_details[0];
                    $projectId = $tempRentalReceiveDetail->rental_request_detail->rental_request_header->project_id;
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
                    $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'rental-receive-headers', 'action' => 'view/'. $rentalReceiveHeader->id ], false));
                    $notification->link = $link;
                    $notification->message = '<b>'.$project->title.'\'s</b> has rental request has been received. Click to see the rental receive.';
                    $notification->user_id = $employee['user_id'];
                    $notification->project_id = $rentalReceiveHeader->project_id;
                    $this->Notifications->save($notification);
                }


                $this->Flash->success(__('The rental receive number ' . $rentalReceiveHeader->number . ' has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rental receive header could not be saved. Please, try again.'));
            }
        }
        $equipment = TableRegistry::get('Equipment')->find('list')->toArray();

        // Retrieve incomplete rental requests.
        $rentalRequestHeaders = $this->RentalReceiveHeaders->RentalReceiveDetails->RentalRequestDetails
            ->RentalRequestHeaders
            ->find()
            ->contain(['Projects', 'Suppliers', 'RentalRequestDetails' => [
                'Equipment', 'RentalReceiveDetails']
            ])
            ->toArray();

        foreach($rentalRequestHeaders as $rentalRequestHeader)
        {
            $this->RentalReceiveHeaders->RentalReceiveDetails->RentalRequestDetails->RentalRequestHeaders->computeQuantityRemaining($rentalRequestHeader)
                ->computeAllQuantityReceived($rentalRequestHeader);
        }

        $collection = new Collection($rentalRequestHeaders);
        $incompleteRequests = $collection->filter(function ($request, $key) {
            return $request->all_quantity_received === false;
        });

        $rentalRequestHeaders = [];
        foreach($incompleteRequests as $incompleteRequest)
            $rentalRequestHeaders[$incompleteRequest->id] = $incompleteRequest->id;

        $this->set(compact('rentalReceiveHeader', 'rentalRequestHeaders', 'equipment'));
        $this->set('_serialize', ['rentalReceiveHeader', 'rentalRequestHeaders', 'equipment']);
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
        $rentalRequestHeaders = $this->RentalReceiveHeaders->RentalRequestHeaders->find('list');
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
