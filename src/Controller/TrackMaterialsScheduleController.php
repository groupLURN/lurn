<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Core\Exception\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;

/**
 * TrackMaterialsSchedule Controller
 *
 */
class TrackMaterialsScheduleController extends AppController
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
            'sortWhitelist' => [
                'Projects.title',
                'Milestones.title',
                'Tasks.title',
                'Tasks.start_date',
                'Tasks.end_date',
                'MaterialsTasks.quantity',
                'quantity_available'
            ],
            'contain' => [
                'MaterialsGeneralInventories'
            ]
        ];


        $this->paginate += $this->createFinders($this->request->query, 'Materials');
        $this->paginate['finder']['materialsSchedule'] = [];
        $materials = $this->paginate(TableRegistry::get('Materials'));

        $projects = TableRegistry::get('Projects')->find('list')->toArray();

        $this->set(compact('materials', 'projects'));
        $this->set($this->request->query);
        $this->set('_serialize', ['materials', 'projects']);
    }
}
