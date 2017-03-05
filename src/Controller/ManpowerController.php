<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Manpower Controller
 *
 * @property \App\Model\Table\ManpowerTable $Manpower
 */
class ManpowerController extends AppController
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
            'contain' => ['ManpowerTypes']
        ];
        $this->paginate += $this->createFinders($this->request->query);
        $manpower = $this->paginate($this->Manpower);
        $manpowerTypes = $this->Manpower->ManpowerTypes->find('list', ['limit' => 200])->toArray();

        $this->set(compact('manpower', 'manpowerTypes'));
        $this->set($this->request->query);
        $this->set('_serialize', ['manpower']);
    }

    /**
     * View method
     *
     * @param string|null $id Manpower id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $manpower = $this->Manpower->get($id, [
            'contain' => ['ManpowerTypes']
        ]);

        $this->set('manpower', $manpower);
        $this->set('_serialize', ['manpower']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $manpower = $this->Manpower->newEntity();
        if ($this->request->is('post')) {
            $manpower = $this->Manpower->patchEntity($manpower, $this->request->data);
            if ($this->Manpower->save($manpower)) {
                $this->Flash->success(__('The manpower has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The manpower could not be saved. Please, try again.'));
            }
        }
        $manpowerTypes = $this->Manpower->ManpowerTypes->find('list', ['limit' => 200]);
        $this->set(compact('manpower', 'manpowerTypes'));
        $this->set('_serialize', ['manpower']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Manpower id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $manpower = $this->Manpower->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $manpower = $this->Manpower->patchEntity($manpower, $this->request->data);
            if ($this->Manpower->save($manpower)) {
                $this->Flash->success(__('The manpower has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The manpower could not be saved. Please, try again.'));
            }
        }
        $manpowerTypes = $this->Manpower->ManpowerTypes->find('list', ['limit' => 200]);
        $this->set(compact('manpower', 'manpowerTypes'));
        $this->set('_serialize', ['manpower']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Manpower id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $manpower = $this->Manpower->get($id);
        if ($this->Manpower->delete($manpower)) {
            $this->Flash->success(__('The manpower has been deleted.'));
        } else {
            $this->Flash->error(__('The manpower could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
