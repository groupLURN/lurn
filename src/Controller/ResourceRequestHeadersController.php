<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ResourceRequestHeaders Controller
 *
 * @property \App\Model\Table\ResourceRequestHeadersTable $ResourceRequestHeaders
 */
class ResourceRequestHeadersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projects']
        ];
        $resourceRequestHeaders = $this->paginate($this->ResourceRequestHeaders);

        $this->set(compact('resourceRequestHeaders'));
        $this->set('_serialize', ['resourceRequestHeaders']);
    }

    /**
     * View method
     *
     * @param string|null $id Resource Request Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resourceRequestHeader = $this->ResourceRequestHeaders->get($id, [
            'contain' => ['Projects', 'ResourceRequestDetails']
        ]);

        $this->set('resourceRequestHeader', $resourceRequestHeader);
        $this->set('_serialize', ['resourceRequestHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resourceRequestHeader = $this->ResourceRequestHeaders->newEntity();
        if ($this->request->is('post')) {
            $resourceRequestHeader = $this->ResourceRequestHeaders->patchEntity($resourceRequestHeader, $this->request->data);
            if ($this->ResourceRequestHeaders->save($resourceRequestHeader)) {
                $this->Flash->success(__('The resource request header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resource request header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->ResourceRequestHeaders->Projects->find('list', ['limit' => 200]);
        $this->set(compact('resourceRequestHeader', 'projects'));
        $this->set('_serialize', ['resourceRequestHeader']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Resource Request Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resourceRequestHeader = $this->ResourceRequestHeaders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resourceRequestHeader = $this->ResourceRequestHeaders->patchEntity($resourceRequestHeader, $this->request->data);
            if ($this->ResourceRequestHeaders->save($resourceRequestHeader)) {
                $this->Flash->success(__('The resource request header has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resource request header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->ResourceRequestHeaders->Projects->find('list', ['limit' => 200]);
        $this->set(compact('resourceRequestHeader', 'projects'));
        $this->set('_serialize', ['resourceRequestHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Resource Request Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resourceRequestHeader = $this->ResourceRequestHeaders->get($id);
        if ($this->ResourceRequestHeaders->delete($resourceRequestHeader)) {
            $this->Flash->success(__('The resource request header has been deleted.'));
        } else {
            $this->Flash->error(__('The resource request header could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
