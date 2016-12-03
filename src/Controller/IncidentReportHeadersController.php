<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * IncidentReportHeaders Controller
 *
 * @property \App\Model\Table\IncidentReportHeadersTable $IncidentReportHeaders
 */
class IncidentReportHeadersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        if(empty($this->request->params['pass']))
            return $this->redirect(['controller' => 'dashboard']);

        $projectId = $this->request->params['pass'][0];

        $this->loadModel('Projects');

        $project = $this->Projects->get($projectId, [
            'contain' => ['Clients', 'Employees', 'EmployeesJoin' => [
            'EmployeeTypes'
            ]]
        ]);

        $this->viewBuilder()->layout('project_management');
        $this->set('projectId', $projectId);
        $this->set('project', $project);
        return parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($id = null)
    {
        $this->paginate = [
            'contain' => ['Projects']
        ];

        $incidentReportHeaders = $this->paginate($this->IncidentReportHeaders);

        $this->set(compact('incidentReportHeaders'));
        $this->set('_serialize', ['incidentReportHeaders']);
    }

    /**
     * View method
     *
     * @param string|null $id Incident Report Header id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $incidentReportHeader = $this->IncidentReportHeaders->get($id, [
            'contain' => ['Projects', 'IncidentReportDetails']
        ]);

        $this->set('incidentReportHeader', $incidentReportHeader);
        $this->set('_serialize', ['incidentReportHeader']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $incidentReportHeader = $this->IncidentReportHeaders->newEntity();
        if ($this->request->is('post')) {
            $incidentReportHeader = $this->IncidentReportHeaders->patchEntity($incidentReportHeader, $this->request->data);

            debug($incidentReportHeader);
            die();
            // if ($this->IncidentReportHeaders->save($incidentReportHeader)) {
            //     $this->Flash->success(__('The incident report header has been saved.'));

            //     return $this->redirect(['action' => 'index']);
            // } else {
            //     $this->Flash->error(__('The incident report header could not be saved. Please, try again.'));
            // }
        }

        $project = $this->IncidentReportHeaders->Projects->find('byProjectId', ['project_id' => $id]);

        $this->set(compact('incidentReportHeader', 'project'));
        $this->set('_serialize', ['incidentReportHeader', 'project']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Incident Report Header id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $incidentReportHeader = $this->IncidentReportHeaders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $incidentReportHeader = $this->IncidentReportHeaders->patchEntity($incidentReportHeader, $this->request->data);
            if ($this->IncidentReportHeaders->save($incidentReportHeader)) {
                $this->Flash->success(__('The incident report header has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The incident report header could not be saved. Please, try again.'));
            }
        }
        $projects = $this->IncidentReportHeaders->Projects->find('list', ['limit' => 200]);
        $this->set(compact('incidentReportHeader', 'projects'));
        $this->set('_serialize', ['incidentReportHeader']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Incident Report Header id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $incidentReportHeader = $this->IncidentReportHeaders->get($id);
        if ($this->IncidentReportHeaders->delete($incidentReportHeader)) {
            $this->Flash->success(__('The incident report header has been deleted.'));
        } else {
            $this->Flash->error(__('The incident report header could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
