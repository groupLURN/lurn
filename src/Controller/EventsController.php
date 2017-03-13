<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 */
class EventsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        $action = $this->request->params['action'];

        $this->loadModel('Projects');
        if ($action === 'project-calendar')
        {
            if(empty($this->request->params['pass'])) {
                return $this->redirect(['controller' => 'dashboard']);
            }
            $this->viewBuilder()->layout('project_management');
            $projectId = (int) $this->request->params['pass'][0];
            
            $this->set('projectId', $projectId);
            
            $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();
            
            $this->set('isFinished', $project->is_finished );

            $this->set('projectId', $projectId);
        }
        return parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        if ($action === 'projectCalendar')
        {

            $userTypeId = $user['employee']['employee_type_id'];
            $isAdmin = $userTypeId === 0;
            $isOwner = $userTypeId === 1;
            $projectId = $this->request->params['pass'][0];

            $isUserAssigned = $this->Projects->find()
            ->matching('EmployeesJoin', function($query) use ($user) {
                return $query->where(['EmployeesJoin.user_id' => $user['id']]);
            })
            ->where(['Projects.id' => $projectId])
            ->first() !== null;
            
            return $isUserAssigned || $isOwner || $isAdmin;

        }

        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $employeeTypeId = isset($this->Auth->user['employee']['employee_type_id'])
            ? $this->Auth->user['employee']['employee_type_id'] : '';
        $isAdmin = $employeeTypeId === 0;
        $isOwner = $employeeTypeId === 1;

        $projects = [];

        if ($isAdmin || $isOwner) 
        {
            $projects = $this->Projects->find('all')
                ->contain(
                    [
                        'Clients', 
                        'Milestones' => ['Tasks'], 
                        'Employees',  
                        'EmployeesJoin' => ['EmployeeTypes']
                    ]
                )   
                ->toArray();
        } else 
        {
            $projects = $this->Projects->find('byAuthorization', 
                    [
                        'user_id' => $this->Auth->user('id'),
                        'user_type_id' => $this->Auth->user('user_type_id')
                    ]
                )
                ->contain(
                    [
                        'Clients', 
                        'Milestones' => ['Tasks'], 
                        'Employees',  
                        'EmployeesJoin' => ['EmployeeTypes']
                    ]
                )   
                ->toArray();
        }
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

        //create the calendar
        for ($day = 1; $day < $noOfDays; $day++) { 

            $tempDate = $tempYear.'-'.$tempMonth .'-'.$day;
            
            $dayOfTheWeek = date('w', strtotime($tempDate));

            foreach ($projects as $project) {
                $pushFlag = false;
                $projectsUrl = Router::url(['controller' => 'projects', 'action' => 'view', $project->id ], false);
                $update = '<a href="'.$projectsUrl.'">x '.$project->title.'</a>';

                $endDate = $project->end_date->year.'-'.$project->end_date->month.'-'.$project->end_date->day;

                //add due projects to list
                if(strcmp($endDate, $tempDate) == 0){
                    if(!isset($dueProjects[$noOfWeeks][$dayOfTheWeek])){
                        $dueProjects[$noOfWeeks][$dayOfTheWeek] = [];
                    }

                    if(!isset($dueProjectIds[$noOfWeeks][$dayOfTheWeek])){
                        $dueProjectIds[$noOfWeeks][$dayOfTheWeek] = [];
                    }

                    $projectTitle = ' x '.$project->title;
                    array_push($dueProjects[$noOfWeeks][$dayOfTheWeek], $projectTitle);
                    array_push($dueProjectIds[$noOfWeeks][$dayOfTheWeek], $project->id);
                }



                //add updates to list
                foreach ($project->milestones as $milestone) {
                    $index = 0;
                    foreach ($milestone->tasks as $task) { 
                        $updatedDate        = $task['modified']->year.'-'.$task['modified']->month.'-'.$task['modified']->day;

                        if(strcmp($updatedDate, $tempDate) == 0){
                            ++$index;

                            if ($index === 1) {
                                $update .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$projectsUrl.'">+  '.$milestone->title.'</a>';
                            }

                            if(!isset($updates[$noOfWeeks][$dayOfTheWeek])){
                                $updates[$noOfWeeks][$dayOfTheWeek] = [];
                            }
                        
                            if(!isset($updatedProjectIds[$noOfWeeks][$dayOfTheWeek])){
                                $updatedProjectIds[$noOfWeeks][$dayOfTheWeek] = [];
                            }

                            if(!isset($updatedTaskIds[$noOfWeeks][$dayOfTheWeek])){
                                $updatedTaskIds[$noOfWeeks][$dayOfTheWeek] = [];
                            }

                            $taskUrl = Router::url(
                                ['controller' => 'tasks', 'action' => 'view', $task->id, '?' => ['project_id' => $project->id]]
                                , false);

                            $update     .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                . '<a href="'.$taskUrl .'">-  '.$task->title.'</a>';   

                            $pushFlag   = true;      
                        }
                    }
                }

                if ($pushFlag) 
                {
                    array_push($updates[$noOfWeeks][$dayOfTheWeek],  $update);
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
        $calendar['currentDay']         = date('Y') === $tempYear && date('n') === $tempMonth? date('d') : '';

        $this->set('calendar', $calendar);  

    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function projectCalendar($projectId)
    {
        $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();

        if ($project == null)
        {            
            $this->Flash->error(__('The project was not found.'));

            return $this->redirect(['controller' => 'dashboard', 'action' => 'index']);
        }

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

        //create the calendar
        for ($day = 1; $day < $noOfDays; $day++) { 

            $tempDate = $tempYear.'-'.$tempMonth .'-'.$day;
            
            $dayOfTheWeek = date('w', strtotime($tempDate));

            $pushFlag = false;
            $projectsUrl = Router::url(['controller' => 'projects', 'action' => 'view', $project->id ], false);
            $update = '<a href="'.$projectsUrl.'">x '.$project->title.'</a>';

            $endDate = $project->end_date->year.'-'.$project->end_date->month.'-'.$project->end_date->day;

            //add due projects to list
            if(strcmp($endDate, $tempDate) == 0){
                if(!isset($dueProjects[$noOfWeeks][$dayOfTheWeek])){
                    $dueProjects[$noOfWeeks][$dayOfTheWeek] = [];
                }

                if(!isset($dueProjectIds[$noOfWeeks][$dayOfTheWeek])){
                    $dueProjectIds[$noOfWeeks][$dayOfTheWeek] = [];
                }

                $projectTitle = ' x '.$project->title;
                array_push($dueProjects[$noOfWeeks][$dayOfTheWeek], $projectTitle);
                array_push($dueProjectIds[$noOfWeeks][$dayOfTheWeek], $project->id);
            }

            //add updates to list
            foreach ($project->milestones as $milestone) {
                $index = 0;
                foreach ($milestone->tasks as $task) { 
                    $updatedDate        = $task['modified']->year.'-'.$task['modified']->month.'-'.$task['modified']->day;

                    if(strcmp($updatedDate, $tempDate) == 0){
                        ++$index;

                        if ($index === 1) {
                            $update .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$projectsUrl.'">+  '.$milestone->title.'</a>';
                        }

                        if(!isset($updates[$noOfWeeks][$dayOfTheWeek])){
                            $updates[$noOfWeeks][$dayOfTheWeek] = [];
                        }
                    
                        if(!isset($updatedProjectIds[$noOfWeeks][$dayOfTheWeek])){
                            $updatedProjectIds[$noOfWeeks][$dayOfTheWeek] = [];
                        }

                        if(!isset($updatedTaskIds[$noOfWeeks][$dayOfTheWeek])){
                            $updatedTaskIds[$noOfWeeks][$dayOfTheWeek] = [];
                        }

                        $taskUrl = Router::url(
                            ['controller' => 'tasks', 'action' => 'view', $task->id, '?' => ['project_id' => $project->id]]
                            , false);

                        $update     .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            . '<a href="'.$taskUrl .'">-  '.$task->title.'</a>';   

                        $pushFlag   = true;      
                    }
                }
            }

            if ($pushFlag) 
            {
                array_push($updates[$noOfWeeks][$dayOfTheWeek],  $update);
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
        $calendar['currentDay']         = date('Y') === $tempYear && date('n') === $tempMonth? date('d') : '';

        $this->set('calendar', $calendar);  
        $this->viewBuilder()->template('index');

    }


}
