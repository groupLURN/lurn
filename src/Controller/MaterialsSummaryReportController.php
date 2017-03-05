<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * MaterialsSummaryReportController Controller
 *
 */
class MaterialsSummaryReportController extends AppController
{

    public function beforeFilter(Event $event)
    {
        if(empty($this->request->params['pass'])){
            return $this->redirect(['controller' => 'dashboard']);
        }

        $this->loadModel('Projects');
        $this->viewBuilder()->layout('project_management');
        $projectId = (int) $this->request->params['pass'][0];
        
        $this->set('projectId', $projectId);
        
        $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();
        
        $this->set('isFinished', $project->is_finished );

        $this->set('projectId', $projectId);
        return parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];

        $userTypeId = $user['employee']['employee_type_id'];
        $isAdmin = $userTypeId == 0;
        $isOwner = $userTypeId == 1;
        $isProjectManager = $userTypeId == 2;
        $isWarehouseEngineer = $userTypeId == 4;

        $projectId = $this->request->params['pass'][0];

        $isUserAssigned = $this->Projects->find()
        ->matching('EmployeesJoin', function($query) use ($user) {
            return $query->where(['EmployeesJoin.user_id' => $user['id']]);
        })
        ->where(['Projects.id' => $projectId])
        ->first() !== null;
        
        return ($isUserAssigned &&  $isProjectManager || $isWarehouseEngineer) || $isOwner || $isAdmin;
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($id = null)
    {
        $this->loadModel('Projects');
        $this->loadModel('MaterialsTaskInventories');
        $this->loadModel('MaterialsTasks');

        $project = $this->Projects->find('byId', ['project_id'=>$id])->first();

        if($project->is_finished == 0) {
            return $this->redirect(['controller' => 'dashboard']);
        }
        
        $materials = [];
        $materialsInventories = $this->MaterialsTaskInventories->find('byProjectId', ['project_id'=>$id])->toArray();

        foreach ($materialsInventories as $materialsInventory) {
            $tempmaterials = $materialsInventory->material;
            $materials[$tempmaterials->name] = $tempmaterials;
        }

        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){
                $materialList = [];
                $materialsTasks = $this->MaterialsTasks->find('byTask', ['task_id'=>$task->id])->toArray();
                foreach ($materialsTasks  as $materialsTask) {
                    $materialList[$materialsTask->material->name] = $materialsTask;
                }
                $task['materials'] = $materialList;
            }
        }

        ksort($materials);

        $this->set(compact('project'));
        $this->set(compact('materials'));
    }

    public function view($id = null, $download = null)
    {
        $this->viewBuilder()->layout('summary-report');

        $this->loadModel('Projects');
        $this->loadModel('MaterialsTaskInventories');
        $this->loadModel('MaterialsTasks');

        $project = $this->Projects->find('byId', ['project_id'=>$id])->first();
        if($project->is_finished == 0) {
            return $this->redirect(['controller' => 'dashboard']);
        }
        
        $materials = [];
        $materialsInventories = $this->MaterialsTaskInventories->find('byProjectId', ['project_id'=>$id])->toArray();

        foreach ($materialsInventories as $materialsInventory) {
            $tempmaterials = $materialsInventory->material;
            $materials[$tempmaterials->name] = $tempmaterials;
        }

        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){
                $materialList = [];
                $materialsTasks = $this->MaterialsTasks->find('byTask', ['task_id'=>$task->id])->toArray();
                foreach ($materialsTasks  as $materialsTask) {
                    $materialList[$materialsTask->material->name] = $materialsTask;
                }
                $task['materials'] = $materialList;
            }
        }

        ksort($materials);

        $this->set(compact('project'));
        $this->set(compact('materials'));

        $currentDate = Time::now();
        $currentDate = $currentDate->month . "/" . $currentDate->day . "/" . $currentDate->year;
        $this->set('currentDate', $currentDate);

        if ($download == 1)
            $download = true;
        else
            $download = false;

        $this->viewBuilder()->options([
            'pdfConfig' => [
                'orientation' => 'landscape',
                'filename' => 'General_materials_Inventory_Report_' . $currentDate . '.pdf',
                'download' => $download
            ]           
        ]); 
    }
}
