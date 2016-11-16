<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;

/**
 * ResourceTransferHeaders Controller
 *
 * @property \App\Model\Table\ResourceTransferHeadersTable $ResourceTransferHeaders
 */
class ResourceTransferHeadersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ResourceRequestHeaders', 'ProjectTo', 'ProjectFrom']
        ];
        $this->paginate += $this->createFinders($this->request->query);
        $resourceTransferHeaders = $this->paginate($this->ResourceTransferHeaders);
        $projects = TableRegistry::get('Projects')->find('list')->toArray();

        $this->set($this->request->query);
        $this->set(compact('resourceTransferHeaders', 'projects'));
        $this->set('_serialize', ['resourceTransferHeaders', 'projects']);
    }

    /**
     * View method
     *
     * @param string|null $id Resource Transfer Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resourceTransferHeader = $this->ResourceTransferHeaders->get($id, [
            'contain' => ['ResourceRequestHeaders', 'ProjectFrom', 'ProjectTo',
                'EquipmentTransferDetails' => ['EquipmentInventories' => ['Equipment']],
                'ManpowerTransferDetails' => ['Manpower' => ['ManpowerTypes']],
                'MaterialTransferDetails' => ['Materials']
            ]
        ]);

        $this->set('resourceTransferHeader', $resourceTransferHeader);
        $this->set('_serialize', ['resourceTransferHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resourceTransferHeader = $this->ResourceTransferHeaders->newEntity();
        if ($this->request->is('post')) {
            $this->transpose($this->request->data, 'equipment_inventories');
            $this->transpose($this->request->data, 'manpower');
            $this->transpose($this->request->data, 'materials');

            $resourceTransferHeader = $this->ResourceTransferHeaders->patchEntity($resourceTransferHeader, $this->request->data);

            if ($this->ResourceTransferHeaders->save($resourceTransferHeader)) {
                $this->Flash->success(__('The resource transfer number ' . $resourceTransferHeader-> id . ' has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resource transfer header could not be saved. Please, try again.'));
            }
        }

        // Retrieve incomplete resource requests.
        $resourceRequestHeaders = $this->ResourceTransferHeaders->ResourceRequestHeaders
            ->findIncompleteRequestHeaders();
        $resourceRequestHeadersHash = $this->ResourceTransferHeaders->ResourceRequestHeaders
            ->createHash($resourceRequestHeaders);

        $projects = $this->ResourceTransferHeaders->ProjectTo->find('list');

        $selectedResourceRequestHeaderId = isset($this->request->query['resources_request_number'])? (int) $this->request->query['resources_request_number']: 0;

        $selectedResourceRequestHeader = (new Collection($resourceRequestHeaders))->filter(
            function($resourceRequestHeader) use ($selectedResourceRequestHeaderId)
            {
                return $resourceRequestHeader->id ===  $selectedResourceRequestHeaderId;
            }
        )->first();

        $this->set($this->request->query);
        $this->set(compact('resourceTransferHeader', 'selectedResourceRequestHeader', 'resourceRequestHeadersHash', 'projects'));
        $this->set('_serialize', ['resourceTransferHeader', 'selectedResourceRequestHeader', 'resourceRequestHeadersHash', 'projects']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Resource Transfer Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resourceTransferHeader = $this->ResourceTransferHeaders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resourceTransferHeader = $this->ResourceTransferHeaders->patchEntity($resourceTransferHeader, $this->request->data);
            if ($this->ResourceTransferHeaders->save($resourceTransferHeader)) {
                $this->Flash->success(__('The resource transfer header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resource transfer header could not be saved. Please, try again.'));
            }
        }
        $resourceRequestHeaders = $this->ResourceTransferHeaders->ResourceRequestHeaders->find('list', ['limit' => 200]);
        $projects = $this->ResourceTransferHeaders->Projects->find('list', ['limit' => 200]);
        $this->set(compact('resourceTransferHeader', 'resourceRequestHeaders', 'projects'));
        $this->set('_serialize', ['resourceTransferHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Resource Transfer Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resourceTransferHeader = $this->ResourceTransferHeaders->get($id);
        if ($this->ResourceTransferHeaders->delete($resourceTransferHeader)) {
            $this->Flash->success(__('The resource transfer header has been deleted.'));
        } else {
            $this->Flash->error(__('The resource transfer header could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
