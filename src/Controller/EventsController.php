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

        $projects = $this->Projects->find('all')->toArray();

        $calendar = [];

        $calendar['year']       = date('Y');
        $calendar['month']      = date('F');
        $calendar['dayNames']   = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $days       = [];
        $deadlines  = [];
        $noOfWeeks  = 0;

        for ($day = 1; $day < date('t')+1; $day++) { 

            $tempDate = date('Y').'-'.date('n').'-'.$day;
            
            $dayOfTheWeek = date('w', strtotime($tempDate));

            foreach ($projects as $project) {
                $endDate= $project->end_date->year.'-'.$project->end_date->month.'-'.$project->end_date->day;

                if(strcmp($endDate, $tempDate) == 0){
                    if(!isset($deadlines[$noOfWeeks][$dayOfTheWeek])){
                        $deadlines[$noOfWeeks][$dayOfTheWeek] = [];
                    }
                    array_push($deadlines[$noOfWeeks][$dayOfTheWeek], $project->title);
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

        $calendar['noOfWeeks']  = $noOfWeeks;
        $calendar['days']       = $days;        
        $calendar['deadlines']  = $deadlines;
        $calendar['currentDay'] = date('d');

        $this->set('calendar', $calendar);  

    }


}
