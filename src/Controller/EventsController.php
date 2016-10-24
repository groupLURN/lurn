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
        $days               = [];
        $dueProjects        = [];
        $dueProjectIds      = [];
        $updates            = [];
        $updatedProjectIds  = [];
        $updatedTaskIds     = [];
        $noOfWeeks          = 0;

        foreach ($projects as $project) { 
            $updatedTasks = $this->Tasks->find('latestTaskOfProject', ['project_id' => $project['id']])->toArray();

            if(count($updatedTasks) > 0) {         
                $project['updatedTasks'] = $updatedTasks;
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

                    if(!isset($dueProjectIds[$noOfWeeks][$dayOfTheWeek])){
                        $dueProjectIds[$noOfWeeks][$dayOfTheWeek] = [];
                    }

                    array_push($dueProjects[$noOfWeeks][$dayOfTheWeek], $project->title);
                    array_push($dueProjectIds[$noOfWeeks][$dayOfTheWeek], $project->id);
                }

                //add updates to list
                if(isset($project['updatedTasks'])) {

                    for ($i=0; $i < count($project['updatedTasks']); $i++) { 
                        $latestMilestone    = $this->Milestones->get($project['updatedTasks'][$i]['milestone_id']);
                        $updatedDate        = $project['updatedTasks'][$i]['modified']->year.'-'.$project['updatedTasks'][$i]['modified']->month.'-'.$project['updatedTasks'][$i]['modified']->day;

                        if(strcmp($updatedDate, $tempDate) == 0){
                            if(!isset($updates[$noOfWeeks][$dayOfTheWeek])){
                                $updates[$noOfWeeks][$dayOfTheWeek] = [];
                            }
                        
                            if(!isset($updatedProjectIds[$noOfWeeks][$dayOfTheWeek])){
                                $updatedProjectIds[$noOfWeeks][$dayOfTheWeek] = [];
                            }

                            if(!isset($updatedTaskIds[$noOfWeeks][$dayOfTheWeek])){
                                $updatedTaskIds[$noOfWeeks][$dayOfTheWeek] = [];
                            }

                            $update = $project->title.'<ul class="milestone"><li>&gt;&gt; '.$latestMilestone->title.'</li></ul>';
                            array_push($updates[$noOfWeeks][$dayOfTheWeek],  $update);
                            array_push($updatedProjectIds[$noOfWeeks][$dayOfTheWeek],  $project->id); 
                            array_push($updatedTaskIds[$noOfWeeks][$dayOfTheWeek],  $project['updatedTasks'][$i]['id']);             
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

        $calendar['noOfWeeks']          = $noOfWeeks;
        $calendar['days']               = $days;        
        $calendar['dueProjects']        = $dueProjects;
        $calendar['dueProjectIds']      = $dueProjectIds;
        $calendar['updates']            = $updates;
        $calendar['updatedProjectIds']  = $updatedProjectIds;
        $calendar['updatedTaskIds']     = $updatedTaskIds;
        $calendar['currentDay']         = date('d');

        $this->set('calendar', $calendar);  

    }


}
