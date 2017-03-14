<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;

/**
 *  ManpowerSummaryReportController Controller
 *
 */
class  ManpowerSummaryReportController extends SummaryReportController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($id = null)
    {        
        $this->loadModel('Projects');
        $this->loadModel('ManpowerTypes');
        $this->loadModel('ManpowerTypesTasks');

        $project = $this->Projects->find('byId', ['project_id'=>$id])->first();

        $manpowerTypes       = $this->ManpowerTypes->find('all')->toArray();
        $manpowerTypesTasks = $this->ManpowerTypesTasks->find('all')->toArray();


        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){    
                $tempManpowerList = [];
                foreach ($manpowerTypesTasks as $manpowerTypesTask) {
                    if($task->id === $manpowerTypesTask->task_id){
                        foreach ($manpowerTypes as $manpowerType) {        
                            if ($manpowerType->id === $manpowerTypesTask->manpower_type_id) {
                                if (!isset($tempManpowerList[$manpowerType->title])) {
                                    $tempManpowerList[$manpowerType->title] = 0;
                                }

                                $tempManpowerList[$manpowerType->title] += $manpowerTypesTask->quantity;
                            }                    
                        }
                    }
                }

                $task['manpower'] = $tempManpowerList;
            }
        }

        $this->set(compact('project'));
        $this->set(compact('manpowerTypes'));
    }

    public function view($id = null, $download = null)
    {
        $this->viewBuilder()->layout('summary-report');
        
        $this->loadModel('Projects');
        $this->loadModel('ManpowerTypes');
        $this->loadModel('ManpowerTypesTasks');

        $project = $this->Projects->find('byId', ['project_id'=>$id])->first();

        $manpowerTypes       = $this->ManpowerTypes->find('all')->toArray();
        $manpowerTypesTasks = $this->ManpowerTypesTasks->find('all')->toArray();


        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){    
                $tempManpowerList = [];
                foreach ($manpowerTypesTasks as $manpowerTypesTask) {
                    if($task->id === $manpowerTypesTask->task_id){
                        foreach ($manpowerTypes as $manpowerType) {        
                            if ($manpowerType->id === $manpowerTypesTask->manpower_type_id) {
                                if (!isset($tempManpowerList[$manpowerType->title])) {
                                    $tempManpowerList[$manpowerType->title] = 0;
                                }

                                $tempManpowerList[$manpowerType->title] += $manpowerTypesTask->quantity;
                            }                    
                        }
                    }
                }

                $task['manpower'] = $tempManpowerList;
            }
        }

        $this->set(compact('project'));
        $this->set(compact('manpowerTypes'));

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
                'filename' => 'General_Equipment_Inventory_Report_' . $currentDate . '.pdf',
                'download' => $download
            ]           
        ]); 
    }
}
