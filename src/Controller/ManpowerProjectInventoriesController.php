<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * ManpowerProjectInventories Controller
 *
 * @property \App\Model\Table\ManpowerTable $Manpower
 */
class ManpowerProjectInventoriesController extends AppController
{
    private $_projectId = null;

    public function beforeFilter(Event $event)
    {
        if(empty($this->request->params['pass'])) {
            return $this->redirect(['controller' => 'dashboard']);
        }

        $this->loadModel('Projects');
        $this->viewBuilder()->layout('project_management');
        $projectId = (int) $this->request->params['pass'][0];
        
        $this->set('projectId', $projectId);
        
        $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();

        $this->set('isFinished', $project->is_finished );

        $this->set('project', $project);

        return parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];

        $userTypeId = $user['employee']['employee_type_id'];
        $isAdmin = $userTypeId === 0;
        $isOwner = $userTypeId === 1;

        $projectId = $this->request->params['pass'][0];

        $isUserAssigned = $this->Projects->find()
        ->matching('EmployeesJoin', function($query) use ($user) {
            return $query->where(['EmployeesJoin.user_id' => $user['id']]);
        })
        ->where(['Projects.id' => $projectId])
        ->first() !== null;
        
        return $isUserAssigned || $isOwner || $isAdmin;
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($id = null)
    {
        $this->paginate = [
            'sortWhitelist' => [
                'available_quantity',
                'unavailable_quantity',
                'total_quantity',
                'last_modified'
            ]
        ];

        $this->paginate += $this->createFinders($this->request->query, 'Manpower');
        $this->paginate['finder']['projectInventorySummary'] = ['project_id' => $id];
        $manpower = $this->paginate(TableRegistry::get('Manpower'));
        $manpowerTypes = $this->Manpower->ManpowerTypes->find('list', ['limit' => 200])->toArray();

        $milestones = TableRegistry::get('Milestones')->find('list')
            ->where(['project_id' => $id])
            ->toArray();

        $this->set(compact('manpower', 'manpowerTypes', 'milestones'));
        $this->set($this->request->query);
        $this->set('_serialize', ['manpower', 'manpowerTypes', 'milestones']);
    }

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $manpowerTypeId = $this->request->query['manpower_type_id'];
        $summary = TableRegistry::get('Manpower')->find('projectInventorySummary', [
            'id' => $manpowerTypeId,
            'project_id' => $id
        ])->first();

        $manpower = TableRegistry::get('Manpower')->find()
            ->contain(['Tasks' => ['Milestones']])
            ->matching('ManpowerTypes', function($query) use ($manpowerTypeId)
            {
                return $query->where(['ManpowerTypes.id' => $manpowerTypeId]);
            })
            ->where(['Manpower.project_id' => $id])
            ->orderAsc('Milestones.title')
            ->all();

        $collection = new Collection($manpower);

        $availableManpower = $collection->filter(function($manpower)
        {
            return !$manpower->has('task');
        });

        $unavailableManpower = $collection->filter(function($manpower)
        {
            return $manpower->has('task');
        });

        $unavailableManpowerByTask = $unavailableManpower->groupBy('task_id');

        $this->set(compact('summary', 'availableManpower', 'unavailableManpowerByTask'));
        $this->set('_serialize', ['summary', 'availableManpower', 'unavailableManpowerByTask']);
    }
}
