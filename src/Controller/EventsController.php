<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 */
class EventsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {

        $this->loadModel('Projects');
        $this->loadModel('Milestones');    
        $this->loadModel('Tasks');    

        $projects = $this->Projects->find('all')->toArray();

        $calendar = [];

        $calendar['year']       = date('Y');
        $calendar['month']      = date('F');
        $calendar['dayNames']   = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $days           = [];
        $dueProjects    = [];
        $updates        = [];
        $noOfWeeks      = 0;

        foreach ($projects as $project) { 
            $latestTask         = $this->Tasks->find('latestTaskOfProject', ['project_id' => $project['id']])->toArray();

            if(count($latestTask) > 0) {
                $updatedDate        = $latestTask[0]['modified']->year.'-'.$latestTask[0]['modified']->month.'-'.$latestTask[0]['modified']->day;
                $latestMilestone    = $this->Milestones->get($latestTask[0]['milestone_id']);

                $project['updatedDate']     = $updatedDate;                
                $project['latestMilestone'] = $latestMilestone;
            }
        }


        //create the calendar
        for ($day = 1; $day < date('t')+1; $day++) { 

            $tempDate = date('Y').'-'.date('n').'-'.$day;
            
            $dayOfTheWeek = date('w', strtotime($tempDate));

            foreach ($projects as $project) {
                $endDate= $project->end_date->year.'-'.$project->end_date->month.'-'.$project->end_date->day;

                //add due projects to list
                if(strcmp($endDate, $tempDate) == 0){
                    if(!isset($dueProjects[$noOfWeeks][$dayOfTheWeek])){
                        $dueProjects[$noOfWeeks][$dayOfTheWeek] = [];
                    }
                    array_push($dueProjects[$noOfWeeks][$dayOfTheWeek], $project->title);
                }

                //add updates to list
                if(isset($project['updatedDate'])) {

                    if(strcmp($project['updatedDate'], $tempDate) == 0){
                        if(!isset($updates[$noOfWeeks][$dayOfTheWeek])){
                            $updates[$noOfWeeks][$dayOfTheWeek] = [];
                        }

                        $update = $project->title.'<ul class="milestone"><li>&gt;&gt; '.$project['latestMilestone']->title.'</li></ul>';
                        array_push($updates[$noOfWeeks][$dayOfTheWeek],  $update);                
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
        $calendar['dueProjects']    = $dueProjects;
        $calendar['updates']        = $updates;
        $calendar['currentDay']     = date('d');

        $this->set('calendar', $calendar);  

    }


}
