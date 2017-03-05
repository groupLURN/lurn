<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 */
class ClientsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->paginate += $this->createFinders($this->request->query);
        $clients = $this->paginate($this->Clients);

        $this->set(compact('clients'));
        $this->set($this->request->query);
        $this->set('_serialize', ['clients']);
    }

    public function isAuthorized($user)
    {        
        return $user['user_type_id'] === 0;
    }

    /**
     * View method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => ['Users', 'Projects' => ['Employees']]
        ]);

        foreach($client->projects as $project)
            $this->Clients->Projects->computeProjectStatus($project);

        $this->set('client', $client);
        $this->set('_serialize', ['client']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $client = $this->Clients->newEntity();
        $client->user = $this->Clients->Users->newEntity();
        if ($this->request->is('post')) {
            $client->user = $this->Clients->Users->patchEntity($client->user, [
                'username' => $this->request->data['username'],
                'password' => $this->request->data['password'],
                'user_type_title' => 'Client'
            ]);

            $client = $this->Clients->patchEntity($client, $this->request->data);
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('The client has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The client could not be saved. Please, try again.'));
            }
        }
        $users = $this->Clients->Users->find('list', ['limit' => 200]);
        $this->set(compact('client', 'users'));
        $this->set('_serialize', ['client']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => ['Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $client = $this->Clients->patchEntity($client, $this->request->data, [
                'associated' => [
                    'Users'
                ]
            ]);
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('The client has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The client could not be saved. Please, try again.'));
            }
        }
        $users = $this->Clients->Users->find('list', ['limit' => 200]);
        $this->set(compact('client', 'users'));
        $this->set('_serialize', ['client']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id, [
            'contain' => ['Users', 'Projects']
        ]);

        if(!empty($client->projects))
            $this->Flash->error(__('The client has project initiations so it cannot be deleted.'));
        else {
            $isSuccessful = $this->Clients->connection()->transactional(function() use ($client){
                return $this->Clients->delete($client, ['atomic' => false]) &&
                $this->Clients->Users->delete($client->user, ['atomic' => false]);
            });

            if ($isSuccessful) {
                $this->Flash->success(__('The client has been deleted.'));
            } else {
                $this->Flash->error(__('The client could not be deleted. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
