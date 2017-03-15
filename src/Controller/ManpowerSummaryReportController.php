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

        $project = $this->Projects->find('byId', ['project_id'=>$id])->first();

        $manpower = [];
        $manpower['skilledWorkers'] = [];
        $manpower['laborers'] = [];

        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){    
                foreach ($task->manpower_per_task as $tempManpower) {
                    if($tempManpower->manpower_type_id == 1){
                        $manpower['skilledWorkers'][$tempManpower->id] = $tempManpower;
                    } else {
                        $manpower['laborers'][$tempManpower->id] = $tempManpower;
                    }
                }
            }
        }

        $this->set(compact('project'));
        $this->set(compact('manpower'));
    }

    public function view($id = null, $download = null)
    {
        $this->viewBuilder()->layout('summary-report');

        $project = $this->Projects->find('byId', ['project_id'=>$id])->first();

        $manpower = [];
        $manpower['skilledWorkers'] = [];
        $manpower['laborers'] = [];

        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){    
                foreach ($task->manpower_per_task as $tempManpower) {
                    if($tempManpower->manpower_type_id == 1){
                        $manpower['skilledWorkers'][$tempManpower->id] = $tempManpower;
                    } else {
                        $manpower['laborers'][$tempManpower->id] = $tempManpower;
                    }
                }
            }
        }

        $this->set(compact('project'));
        $this->set(compact('manpower'));

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
