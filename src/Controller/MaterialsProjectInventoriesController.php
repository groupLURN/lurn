<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * MaterialsProjectInventories Controller
 *
 * @property \App\Model\Table\MaterialsProjectInventoriesTable $MaterialsProjectInventories
 */
class MaterialsProjectInventoriesController extends AppController
{
    private $_projectId = null;

    public function beforeFilter(Event $event)
    {
        if(!isset($this->request->query['project_id']))
            return $this->redirect(['controller' => 'dashboard']);

        $this->viewBuilder()->layout('project_management');
        $this->_projectId = (int) $this->request->query['project_id'];

        $this->set('projectId', $this->_projectId);
        return parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'sortWhitelist' => [
                'unit_measure',
                'available_quantity',
                'unavailable_quantity',
                'total_quantity',
                'last_modified'
            ]
        ];

        $this->paginate += $this->createFinders($this->request->query, 'Materials');
        $this->paginate['finder']['projectInventorySummary'] = ['project_id' => $this->_projectId];
        $materials = $this->paginate(TableRegistry::get('Materials'));

        $this->set(compact('materials'));
        $this->set($this->request->query);
        $this->set('_serialize', ['materials']);
    }

    /**
     * View method
     *
     * @param string|null $id Materials Project Inventory id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $summary = TableRegistry::get('Materials')->find('projectInventorySummary', [
            'id' => $id,
            'project_id' => $this->_projectId
        ])->first();

        $material = TableRegistry::get('Materials')->get($id, [
            'contain' => [
                'MaterialsTaskInventories' => [
                    'Tasks'
                ]
            ]
        ]);

        $this->set(compact('material', 'summary'));
        $this->set('_serialize', ['material', 'summary']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $materialsProjectInventory = $this->MaterialsProjectInventories->newEntity();
        if ($this->request->is('post')) {
            $materialsProjectInventory = $this->MaterialsProjectInventories->patchEntity($materialsProjectInventory, $this->request->data);
            if ($this->MaterialsProjectInventories->save($materialsProjectInventory)) {
                $this->Flash->success(__('The materials project inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The materials project inventory could not be saved. Please, try again.'));
            }
        }
        $materials = $this->MaterialsProjectInventories->Materials->find('list', ['limit' => 200]);
        $projects = $this->MaterialsProjectInventories->Projects->find('list', ['limit' => 200]);
        $this->set(compact('materialsProjectInventory', 'materials', 'projects'));
        $this->set('_serialize', ['materialsProjectInventory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Materials Project Inventory id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try
        {
            $materialsProjectInventory = $this->MaterialsProjectInventories->get([
                'material_id' => $id,
                'project_id' => $this->_projectId
            ]);
        }
        catch(RecordNotFoundException $e)
        {
            $materialsProjectInventory = $this->MaterialsProjectInventories->newEntity([
                'material_id' => $id,
                'project_id' => $this->_projectId,
                'quantity' => 0
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $materialsProjectInventory = $this->MaterialsProjectInventories->patchEntity($materialsProjectInventory, $this->request->data);
            if ($this->MaterialsProjectInventories->save($materialsProjectInventory)) {
                $this->Flash->success(__('The materials project inventory has been saved.'));
                return $this->redirect(['action' => 'index', '?' => ['project_id' => $this->_projectId]]);
            } else {
                $this->Flash->error(__('The materials project inventory could not be saved. Please, try again.'));
            }
        }
        $materials = $this->MaterialsProjectInventories->Materials->find('list', ['limit' => 200]);
        $projects = $this->MaterialsProjectInventories->Projects->find('list', ['limit' => 200]);
        $this->set(compact('materialsProjectInventory', 'materials', 'projects'));
        $this->set('_serialize', ['materialsProjectInventory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Materials Project Inventory id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $materialsProjectInventory = $this->MaterialsProjectInventories->get($id);
        if ($this->MaterialsProjectInventories->delete($materialsProjectInventory)) {
            $this->Flash->success(__('The materials project inventory has been deleted.'));
        } else {
            $this->Flash->error(__('The materials project inventory could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
