<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Core\Exception\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;

/**
 * TrackManpowerSchedule Controller
 *
 */
class TrackManpowerScheduleController extends AppController
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
            'sortWhitelist' => [
                'Projects.title',
                'Milestones.title',
                'Tasks.title',
                'Tasks.start_date',
                'Tasks.end_date',
                'ManpowerTypesTasks.quantity',
                'quantity_available'
            ],
            'contain' => [
                'ManpowerGeneralInventories'
            ]
        ];


        $this->paginate += $this->createFinders($this->request->query, 'ManpowerTypes');
        $this->paginate['finder']['manpowerTypesSchedule'] = [];
        $manpower = $this->paginate(TableRegistry::get('ManpowerTypes'));
        $manpowerTypes = $this->ManpowerTypes->find('list', ['limit' => 200])->toArray();

        $projects = TableRegistry::get('Projects')->find('list')->toArray();

        $this->set(compact('manpower', 'projects', 'manpowerTypes'));
        $this->set($this->request->query);
        $this->set('_serialize', ['manpower', 'projects', 'manpowerTypes']);
    }
}
