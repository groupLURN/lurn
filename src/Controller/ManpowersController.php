<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Manpowers Controller
 *
 * @property \App\Model\Table\ManpowersTable $Manpowers
 */
class ManpowersController extends AppController
{

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
        $manpowers = $this->paginate($this->Manpowers);

        $this->set(compact('manpowers'));
        $this->set('_serialize', ['manpowers']);
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
        $manpower = $this->Manpowers->get($id, [
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
        $manpower = $this->Manpowers->newEntity();
        if ($this->request->is('post')) {
            $manpower = $this->Manpowers->patchEntity($manpower, $this->request->data);
            if ($this->Manpowers->save($manpower)) {
                $this->Flash->success(__('The manpower has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The manpower could not be saved. Please, try again.'));
            }
        }
        $manpowerTypes = $this->Manpowers->ManpowerTypes->find('list', ['limit' => 200]);
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
        $manpower = $this->Manpowers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $manpower = $this->Manpowers->patchEntity($manpower, $this->request->data);
            if ($this->Manpowers->save($manpower)) {
                $this->Flash->success(__('The manpower has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The manpower could not be saved. Please, try again.'));
            }
        }
        $manpowerTypes = $this->Manpowers->ManpowerTypes->find('list', ['limit' => 200]);
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
        $manpower = $this->Manpowers->get($id);
        if ($this->Manpowers->delete($manpower)) {
            $this->Flash->success(__('The manpower has been deleted.'));
        } else {
            $this->Flash->error(__('The manpower could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
