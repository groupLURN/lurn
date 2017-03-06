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
        $days               = [];
        $dueProjects        = [];
        $dueProjectIds      = [];
        $updates            = [];
        $updatedProjectIds  = [];
        $updatedTaskIds     = [];
        $noOfWeeks          = 0;

        $tempYear           = isset($this->request->query['year']) ? $this->request->query['year'] : date('Y');
        $tempMonth          = isset($this->request->query['month']) ? $this->request->query['month'] : date('n');
        $tempDate           = $tempYear.'-'.$tempMonth .'-1';
        $noOfDays           = date('t', strtotime($tempDate))+1;
        foreach ($projects as $project) { 
            $updatedTasks = $this->Tasks->find('latestTaskOfProject', ['project_id' => $project['id']])->toArray();

            if(count($updatedTasks) > 0) {         
                $project['updatedTasks'] = $updatedTasks;
            }
        }

        //create the calendar
        for ($day = 1; $day < $noOfDays; $day++) { 

            $tempDate = $tempYear.'-'.$tempMonth .'-'.$day;
            
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

                    $projectTitle = ' - '.$project->title;
                    array_push($dueProjects[$noOfWeeks][$dayOfTheWeek], $projectTitle);
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

                            $update = ' - '.$project->title.'<br>&nbsp;&nbsp;&nbsp;&nbsp;+  '.$latestMilestone->title;
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
            } else if($day == $noOfDays-1 && $dayOfTheWeek < 6){
                $noOfWeeks++;
            }
        }

        $calendar                       = [];
        $calendar['year']               = $tempYear;
        $calendar['month']              = date('F', strtotime($tempDate));
        $calendar['month-number']       = $tempMonth;
        $calendar['dayNames']           = 
            ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $calendar['noOfWeeks']          = $noOfWeeks;
        $calendar['days']               = $days;        
        $calendar['dueProjects']        = $dueProjects;
        $calendar['dueProjectIds']      = $dueProjectIds;
        $calendar['updates']            = $updates;
        $calendar['updatedProjectIds']  = $updatedProjectIds;
        $calendar['updatedTaskIds']     = $updatedTaskIds;
        $calendar['currentDay']         = date('Y') === $tempYear && date('n') === $tempMonth? date('d') : '';

        $this->set('calendar', $calendar);  

    }


}
