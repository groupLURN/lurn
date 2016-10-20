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

        $projects = $this->Projects->find('all')->toArray();

        $dueDate = new \DateTime('-7 days');
        $dueProjects = $this->Projects->find('dueProjects', ['end_date_to' => $dueDate]);

        $this->set ('dueProjects', $dueProjects);

         if (isset($this->params['requested']))
        {
            return $projects;
        }
        else
        {   
            $noUpdates = [];
            $this->getProjectUpdates($projects, $noUpdates);

            $calendar = $this->populateCalendar($projects);

            $this->removeProjectsWithNoRecentUpdates($projects, $noUpdates);

            $this->populateProjectProgress($projects);
            $this->populateProjectProgress($dueProjects);

            $this->set('projects', $projects);
            $this->set('calendar', $calendar);  
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
    

    private function populateCalendar($projects = []){

            $calendar['year']       = date('Y');
            $calendar['month']      = date('F');
            $calendar['dayNames']   = ['Sun', 'Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat'];
            $days       = [];
            $events     = [];
            $noOfWeeks  = 0;

            for ($day = 1; $day < date('t')+1; $day++) { 

                $tempDate = date('Y').'-'.date('n').'-'.$day;
                
                $dayOfTheWeek = date('w', strtotime($tempDate));


                foreach ($projects as $project) {
                    $endDate= $project->end_date->year.'-'.$project->end_date->month.'-'.$project->end_date->day;

                    //add due projects to list
                    if(strcmp($endDate, $tempDate) == 0){
                        if(!isset($events[$noOfWeeks][$dayOfTheWeek])){
                            $events[$noOfWeeks][$dayOfTheWeek] = [];
                        }
                        array_push($events[$noOfWeeks][$dayOfTheWeek], true);
                    }

                    //add events to list
                    if(strcmp($project['updatedDate'], 'N/A') != 0) {
                        if($project['updatedDate'] != null) {
                            $updatedDate = $project['updatedDate']->year.'-'.$project['updatedDate']->month.'-'.$project['updatedDate']->day;

                            if(strcmp($updatedDate, $tempDate) == 0){
                                if(!isset($events[$noOfWeeks][$dayOfTheWeek])){
                                    $events[$noOfWeeks][$dayOfTheWeek] = [];
                                }

                                array_push($events[$noOfWeeks][$dayOfTheWeek],  true);                
                            }

                        }
                    }
                }

                $days[$noOfWeeks][$dayOfTheWeek] = $day;
                if($dayOfTheWeek  == 6){
                    $noOfWeeks++;

                    $days[$noOfWeeks] = [];
                } else if($day == date('t') && $dayOfTheWeek < 6){
                    $noOfWeeks++;
                }
            }

            $calendar['noOfWeeks']      = $noOfWeeks;
            $calendar['days']           = $days;
            $calendar['events']         = $events;
            $calendar['currentDay']     = date('d');

            return $calendar;

    }

    private function populateProjectProgress(&$projects){

        foreach ($projects as $project) {
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
    }

    private function getProjectUpdates(&$projects, &$noUpdates){
        $tempIndex = 0;
        foreach ($projects as $project) {

            $latestTask         = $this->Tasks->find('latestTaskOfProject', ['project_id' => $project['id']])->toArray();

            if(count($latestTask) > 0) {
                $latestMilestone    = $this->Milestones->get($latestTask[0]['milestone_id']);

                $project['latestMilestone']    = $latestMilestone['title'];
                $project['latestTask']         = $latestTask[0]['title'];
                $project['updatedDate']         = $latestTask[0]['modified'];
            } else {                    
                $noUpdates[] = $tempIndex;
            }

       
            $tempIndex++;
        }

    }

    private function removeProjectsWithNoRecentUpdates(&$projects, &$noUpdates){        

        foreach ($noUpdates as $key => $value) {
            unset($projects[$value]);
        }
    }
}
