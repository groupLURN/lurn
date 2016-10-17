<?php
namespace App\Controller;
    

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\I18n\Time;
/**
 * Dashboard Controller
 *
 */
class DashboardController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */

    public function index()
    {    	      

        $this->loadModel('Projects');
        $this->loadModel('Milestones');
        $this->loadModel('Tasks');

        $projects = $this->Projects->find('all');

        $dueDate = new \DateTime('-7 days');
        $dueToday = $this->Projects->find('dueProjects', ['end_date_to' => $dueDate]);

        $this->set ( 'dueToday', $dueToday);

         if (isset($this->params['requested']))
        {
            return $projects;
        }
        else
        {   
            foreach ($projects as $project) {

                $latestTask         = $this->Tasks->find('latestTaskOfProject', ['project_id' => $project['id']])->toArray();

                if(count($latestTask) > 0) {
                    $latestMilestone    = $this->Milestones->get($latestTask[0]['milestone_id']);

                    $project['latestMilestone']    = $latestMilestone['title'];
                    $project['latestTask']         = $latestTask[0]['title'];
                    $project['updateDate']         = $latestTask[0]['modified'];
                } else {                    

                    $project['latestMilestone']    = "N/A";
                    $project['latestTask']         = "N/A";
                    $project['updateDate']         = "N/A";
                }

                $tasks              = $this->Tasks->find('byProject', ['project_id' => $project['id']])->toArray();
                $progress           = 0;
                $finished           = 0;

                foreach ($tasks as $task) {
                    if($task->is_finished == 1) {
                        $finished += 1;
                    }
                }

                if($finished > 0) {
                    $progress = $finished / count($tasks) * 100;

                    $progress = ceil( $progress * 10)/10;
                }


                $project['progress'] = $progress;
            }

            $this->set ( 'projects', $projects );  
        }

    }
      public function view($id = null)
    {         
        $project = $this->Projects->get($id, [
            'contain' => ['Clients', 'Employees', 'EmployeesJoin' => [
                'EmployeeTypes'
            ]]
        ]);
        $this->Projects->computeProjectStatus($project);
        $this->set('project', $project);
        $this->set('_serialize', ['project']);
    }
    
}
