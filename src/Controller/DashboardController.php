<?php
namespace App\Controller;


use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Event\Event;
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
        $this->loadModel('Notifications');

        $this->paginate = [
        'contain' => ['Clients', 'Employees', 'Milestones' => ['Tasks']]
        ];

        $this->paginate += [
        'finder' =>
        array_merge(
            $this->createFinders($this->request->query)['finder'],
            [
            'ByAuthorization' => ['user_id' => $this->Auth->user('id')]
            ]
            )
        ];

        $projects = $this->paginate($this->Projects);
        foreach($projects as $project)
        {
            $this->Projects->computeProjectStatus($project);
            $milestones = new Collection($project->milestones);
            list($finishedTasks, $totalTasks) = $milestones->reduce(function($accumulated, $milestone)
            {
                $tasks = new Collection($milestone->tasks);

                list($finishedTasks, $totalTasks) = $tasks->reduce(function($accumulated, $task)
                {
                    return [$accumulated[0] + $task->is_finished, $accumulated[1] + 1];
                }, [0, 0]);

                return [$accumulated[0] + $finishedTasks, $accumulated[1] + $totalTasks];
            }, [0, 0]);
            if($totalTasks > 0)
                $project->progress = $finishedTasks / $totalTasks * 100;
            else
                $project->progress = 0;
        }

        $projectStatuses = $this->Projects->getProjectStatusList();  

        $notifications = $this->Notifications->find('byUserId', ['user_id' => $this->request->session()->read('Auth.User.id')])->toArray();

        $projects = $this->getProjectUpdates($projects);

        $calendar = $this->populateCalendar($projects);

        $this->set('projects', $projects); 

        $this->set('calendar', $calendar); 
        $this->set('notifications', $notifications);  

        $this->set(compact('projects', 'projectStatuses'));
        $this->set($this->request->query);
        $this->set('_serialize', ['projects']);

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



    public function afterFilter(Event $event)
    {   
        $this->markNotificationsAsRead();
        return parent::afterFilter($event);
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
                $updatedTasks  = $this->Tasks->find('latestTaskOfProject', ['project_id' => $project->id])->toArray();
                $endDate       = $project->end_date->year.'-'.$project->end_date->month.'-'.$project->end_date->day;

                    //add due projects to list
                if(strcmp($endDate, $tempDate) == 0){
                    if(!isset($events[$noOfWeeks][$dayOfTheWeek])){
                        $events[$noOfWeeks][$dayOfTheWeek] = [];
                    }
                    array_push($events[$noOfWeeks][$dayOfTheWeek], true);
                }
                
                for ($i=0; $i < count($updatedTasks); $i++) { 
                    $updatedDate        = $updatedTasks[$i]['modified']->year.'-'.$updatedTasks[$i]['modified']->month.'-'.$updatedTasks[$i]['modified']->day;
                    if(strcmp($updatedDate, $tempDate) == 0){
                        if(!isset($events[$noOfWeeks][$dayOfTheWeek])){
                            $events[$noOfWeeks][$dayOfTheWeek] = [];
                        }

                        array_push($events[$noOfWeeks][$dayOfTheWeek],  true);                
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

    private function getProjectUpdates($projects){        
        $this->loadModel('Milestones');
        $this->loadModel('Tasks');
        $tempIndex = 0;
        foreach ($projects as $project) {

            $latestTask         = $this->Tasks->find('latestTaskOfProject', ['project_id' => $project['id']])->toArray();

            if(count($latestTask) > 0) {
                $latestMilestone    = $this->Milestones->get($latestTask[0]['milestone_id']);

                $project['latestMilestone']    = $latestMilestone['title'];
                $project['latestTask']         = $latestTask[0]['title'];
                $project['latestTaskId']       = $latestTask[0]['id'];
                $project['updatedDate']        = $latestTask[0]['modified'];
            }


            
            $tempIndex++;
        }

        return $projects;
    }

    private function removeProjectsWithNoRecentUpdates(&$projects, &$noUpdates){        

        foreach ($noUpdates as $key => $value) {
            unset($projects[$value]);
        }
    }

    private function markNotificationsAsRead(){      
        $this->loadModel('Notifications');
        $notifications = $this->Notifications->find('byUserId', ['user_id' => $this->request->session()->read('Auth.User.id')])->toArray();  

        foreach ($notifications as $notification) {
            if($notification->unread){
                $notification->unread = false;
                $this->Notifications->save($notification);
            }
        }
    }
}
