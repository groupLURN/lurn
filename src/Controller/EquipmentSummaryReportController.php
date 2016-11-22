<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * EquipmentProjectSummaryReportController Controller
 *
 */
class EquipmentSummaryReportController extends AppController
{


    public function beforeFilter(Event $event)
    {
        if(empty($this->request->params['pass']))
            return $this->redirect(['controller' => 'dashboard']);

        $this->viewBuilder()->layout('project_management');
        $this->set('projectId', $this->request->params['pass'][0]);
        return parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($id = null)
    {
        $this->loadModel('Projects');
        $this->loadModel('EquipmentInventories');
        $this->loadModel('EquipmentTasks');

        $project = $this->Projects->find('byProjectId', ['project_id'=>$id])->first();
        $equipment = [];
        $equipmentInventories = $this->EquipmentInventories->find('byProjectId', ['project_id'=>$id])->toArray();

        foreach ($equipmentInventories as $equipmentInventory) {
            $tempEquipment = $equipmentInventory->equipment;
            $equipment[$tempEquipment->name] = $tempEquipment;
        }

        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){
                $equipmentList = [];
                $equipmentTasks = $this->EquipmentTasks->find('byTaskId', ['task_id'=>$task->id])->toArray();
                foreach ($equipmentTasks  as $equipmentTask) {
                    $equipmentList[$equipmentTask->equipment->name] = $equipmentTask;
                }
                $task['equipment'] = $equipmentList;
            }
        }

        ksort($equipment);

        $this->set(compact('project'));
        $this->set(compact('equipment'));
    }

    public function view($id = null, $download = null)
    {
        $this->viewBuilder()->layout('summary-report');
        $this->loadModel('Projects');
        $this->loadModel('EquipmentInventories');
        $this->loadModel('EquipmentTasks');

        $project = $this->Projects->find('byProjectId', ['project_id'=>$id])->first();
        $equipment = [];
        $equipmentInventories = $this->EquipmentInventories->find('byProjectId', ['project_id'=>$id])->toArray();

        foreach ($equipmentInventories as $equipmentInventory) {
            $tempEquipment = $equipmentInventory->equipment;
            $equipment[$tempEquipment->name] = $tempEquipment;
        }

        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){
                $equipmentList = [];
                $equipmentTasks = $this->EquipmentTasks->find('byTaskId', ['task_id'=>$task->id])->toArray();
                foreach ($equipmentTasks  as $equipmentTask) {
                    $equipmentList[$equipmentTask->equipment->name] = $equipmentTask;
                }
                $task['equipment'] = $equipmentList;
            }
        }

        ksort($equipment);

        $this->set(compact('project'));
        $this->set(compact('equipment'));

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
