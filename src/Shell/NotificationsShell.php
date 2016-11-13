<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Log\Log;
use Cake\Routing\Router;

/**
 * Simple console wrapper around Psy\Shell.
 */
class NotificationsShell extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Notifications');
        $this->loadModel('Projects');
        $this->loadModel('RentalReceiveHeaders');
    }

    public function main()
    {
        $projects   = $this->Projects->find('allWithTasks')->toArray();   
        $rentalReceiveHeaders = $this->RentalReceiveHeaders->find('all', [
            'contain' => ['RentalReceiveDetails.RentalRequestDetails.RentalRequestHeaders' => [
                'Projects', 'Suppliers'
            ], 'RentalReceiveDetails.RentalRequestDetails.Equipment']
        ])->toArray();


        $this->generateDueTasksNotifications($projects);
        $this->generateDelayedProjectsNotifications($projects);
        $this->generateDueRentNotifications($rentalReceiveHeaders);
        $this->generateOverdueRentNotifications($rentalReceiveHeaders);
    }   

    private function generateOverdueRentNotifications($rentalReceiveHeaders)
    {     
        $currentDate = new \DateTime();
        foreach ($rentalReceiveHeaders as $rentalReceiveHeader) {
            foreach ($rentalReceiveHeader->rental_receive_details as $rentalReceiveDetail){

                if($rentalReceiveDetail->end_date < $currentDate){
                    $equipment = $rentalReceiveDetail->rental_request_detail->equipment;

                    $projectId = $rentalReceiveDetail->rental_request_detail->rental_request_header->project_id;
                    $project = $this->Projects->find('byProjectId', ['project_id'=>$projectId])->first();
                    
                    $employees = [];

                    array_push($employees, $project->employee);

                    for ($i=0; $i < count($project->employees_join); $i++) { 
                        $employeeType = $project->employees_join[$i]->employee_type_id;
                        if($employeeType == 1 || $employeeType == 3) {
                            array_push($employees, $project->employees_join[$i]);
                        }
                    }

                    foreach ($employees as $employee) {
                        $notification = $this->Notifications->newEntity();

                        $link =  substr( Router::url(['controller' => 'rentalReceiveHeaders', 
                        'action' => 'view/'.$rentalReceiveHeader->id], false), 1);
                        $notification->link = $link;
                        $notification->message = '<b>'
                            .$equipment->name.'</b> is overdue.';
                        $notification->user_id = $employee->user_id;
                        $notification->project_id = $project->id;

                        $this->Notifications->save($notification);
                    }  
                }
            }
        }
    }

    private function generateDueRentNotifications($rentalReceiveHeaders)
    {      
        foreach ($rentalReceiveHeaders as $rentalReceiveHeader) {
            foreach ($rentalReceiveHeader->rental_receive_details as $rentalReceiveDetail){
                $duration = date_diff($rentalReceiveDetail->start_date,$rentalReceiveDetail->end_date);
                $duration = $duration->d;

                $dueDate = new \DateTime();

                if($duration >= 5){
                    $dueDate = new \DateTime('-2 days');
                } else {
                    $dueDate = new \DateTime('-1 days');
                }

                if($rentalReceiveDetail->end_date <= $dueDate){
                    $equipment = $rentalReceiveDetail->rental_request_detail->equipment;

                    $projectId = $rentalReceiveDetail->rental_request_detail->rental_request_header->project_id;
                    $project = $this->Projects->find('byProjectId', ['project_id'=>$projectId])->first();
                    
                    $employees = [];

                    array_push($employees, $project->employee);

                    for ($i=0; $i < count($project->employees_join); $i++) { 
                        $employeeType = $project->employees_join[$i]->employee_type_id;
                        if($employeeType == 1 || $employeeType == 3) {
                            array_push($employees, $project->employees_join[$i]);
                        }
                    }

                    foreach ($employees as $employee) {
                        $notification = $this->Notifications->newEntity();

                        $link =  substr( Router::url(['controller' => 'rentalReceiveHeaders', 
                        'action' => 'view/'.$rentalReceiveHeader->id], false), 1);
                        $notification->link = $link;
                        $notification->message = '<b>'
                            .$equipment->name.'</b> is due on <b>'
                            .date_format($rentalReceiveDetail->end_date,"F d, Y")
                            .'</b>.';
                        $notification->user_id = $employee->user_id;
                        $notification->project_id = $project->id;

                        if(!$this->isNotificationExisting($notification)){
                            $this->Notifications->save($notification);
                        }
                    }  
                }
            }
        }
    }

    private function generateDelayedProjectsNotifications($projects)
    {
        $currentDate = new \DateTime();

        foreach ($projects as $project) {
            foreach ($project->milestones as $milestone) {
                if($milestone->end_date < $currentDate){
                    $employees = [];

                    array_push($employees, $project->employee);
                    array_push($employees, $project->client);
                    for ($i=0; $i < count($project->employees_join); $i++) { 
                        $employeeType = $project->employees_join[$i]->employee_type_id;
                        if($employeeType == 1) {
                            array_push($employees, $project->employees_join[$i]);
                        }
                    }

                    foreach ($employees as $employee) {
                        $notification = $this->Notifications->newEntity();

                        $link =  substr( Router::url(['controller' => 'projects', 
                        'action' => 'view/'.$project->id], false), 1);
                        $notification->link = $link;
                        $notification->message = 'The milestone: <b>'.$milestone->title.'</b> from the project: <b>'.$project->title.'</b> is behind schedule.';
                        $notification->user_id = $employee->user_id;
                        $notification->project_id = $project->id;

                        $this->Notifications->save($notification);
                    }  
                }  
            }           
        }
    }

    private function generateDueTasksNotifications($projects)
    {    
        $dueDate    = new \DateTime('-7 days');

        foreach ($projects as $project) {
            foreach ($project->milestones as $milestone) {
                foreach ($milestone->tasks as $task) {
                    if(!$task->is_finished && $task->end_date < $dueDate){
                        $employees = [];

                        array_push($employees, $project->employee);
                        for ($i=0; $i < count($project->employees_join); $i++) { 
                            $employeeType = $project->employees_join[$i]->employee_type_id;
                            if($employeeType == 1) {
                                array_push($employees, $project->employees_join[$i]);
                            }
                        }

                        foreach ($employees as $employee) {
                            $notification = $this->Notifications->newEntity();

                            $link =  substr( Router::url(['controller' => 'tasks', 
                            'action' => 'view/'.$task->id], false), 1).'?project_id='.$project->id ;
                            $notification->link = $link;
                            $notification->message = '<b>'.$task->title.'</b> is due this week.';
                            $notification->user_id = $employee->user_id;
                            $notification->project_id = $project->id;

                            if(!$this->isNotificationExisting($notification)){
                               $this->Notifications->save($notification);
                            }
                        }
                    }
                } 
            }
        }        
    }

    private function isNotificationExisting($notification)
    {
        $notification = $this->Notifications->find('exactMatch', ['project_id' => $notification['project_id'],
            'user_id' => $notification['user_id'],
            'message' => $notification['message']])->first();
        
        return !is_null($notification);
    }
}
