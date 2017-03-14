<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * MaterialsSummaryReportController Controller
 *
 */
class MaterialsSummaryReportController extends SummaryReportController
{
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
                'pageSize' => 'Letter',
                'filename' => 'General_materials_Inventory_Report_' . $currentDate . '.pdf',
                'download' => $download
            ]           
        ]); 
    }
}
