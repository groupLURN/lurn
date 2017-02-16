<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 *  ManpowerSummaryReportController Controller
 *
 */
class  ManpowerSummaryReportController extends AppController
{

    public function beforeFilter(Event $event)
    {
        if(empty($this->request->params['pass']))
            return $this->redirect(['controller' => 'dashboard']);

        $this->loadModel('Projects');
        $this->viewBuilder()->layout('project_management');
        $projectId = (int) $this->request->params['pass'][0];
        
        $this->set('projectId', $projectId);
        
        $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();
        
        $this->set('isFinished', $project->is_finished );

        $this->set('projectId', $projectId);
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
        $this->loadModel('Manpower');

        $project = $this->Projects->find('byId', ['project_id'=>$id])->first();
        if($project->is_finished == 0) {
            return $this->redirect(['controller' => 'dashboard']);
        }
        $manpower = [];
        $manpowerList = $this->Manpower->find('all')->toArray();

        $skilledWorkers = 0;
        $laborers = 0;

        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){    
                $tempManpowerList = [];
                foreach ($manpowerList as $tempManpower) {
                    if($task->id === $tempManpower->task_id){
                        $tempManpowerList[$tempManpower->name] = $tempManpower;
                        $manpower[$tempManpower->name] = $tempManpower;

                        if($tempManpower->manpower_type_id == 1){
                            $skilledWorkers++;
                        } else {
                            $laborers++;
                        }
                    }
                }

                $manpower['skilledWorkers'] = $skilledWorkers;
                $manpower['laborers']       = $laborers;
                $task['manpower']           = $tempManpowerList;
            }
        }

        $this->set(compact('project'));
        $this->set(compact('manpower'));
    }

    public function view($id = null, $download = null)
    {
        $this->viewBuilder()->layout('summary-report');
        
        $this->loadModel('Projects');
        $this->loadModel('Manpower');

        $project = $this->Projects->find('byId', ['project_id'=>$id])->first();
        if($project->is_finished == 0) {
            return $this->redirect(['controller' => 'dashboard']);
        }
        $manpower = [];
        $manpowerList = $this->Manpower->find('all')->toArray();

        $skilledWorkers = 0;
        $laborers = 0;

        foreach ($project->milestones as $milestone){
            foreach ($milestone->tasks as $task){    
                $tempManpowerList = [];
                foreach ($manpowerList as $tempManpower) {
                    if($task->id === $tempManpower->task_id){
                        $tempManpowerList[$tempManpower->name] = $tempManpower;
                        $manpower[$tempManpower->name] = $tempManpower;

                        if($tempManpower->manpower_type_id == 1){
                            $skilledWorkers++;
                        } else {
                            $laborers++;
                        }
                    }
                }

                $manpower['skilledWorkers'] = $skilledWorkers;
                $manpower['laborers']       = $laborers;
                $task['manpower']           = $tempManpowerList;
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
                'filename' => 'General_Equipment_Inventory_Report_' . $currentDate . '.pdf',
                'download' => $download
            ]           
        ]); 
    }
}
