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

         if (isset($this->params['requested']))
        {
            return $projects;
        }
        else
        {   
            foreach ($projects as $project) {
                $task       = $this->Tasks->find('latestTaskOfProject', ['project_id' => $project['id']])->toArray();
                $milestone  = $this->Milestones->get($task[0]['milestone_id'])->toArray();

                $project['latestMilestone']    = $task[0]['title'];
                $project['latestTask']         = $milestone['title'];
                $project['updateDate']         = $task[0]['modified'];
            }

            $this->set ( 'projects', $projects );  
            $this->set ( 'dueToday', $dueToday);
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
