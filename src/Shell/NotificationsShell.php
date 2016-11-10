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
        $this->loadModel('Tasks');
    }

    public function main()
    {
        $projects   = $this->Projects->find('allWithTasks')->toArray();    

        $this->generateDueTasksNotifications($projects);
    }   

    private function generateRentDueNotifications()
    {

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
                            $notification->message = $task->title.' is due this week.';
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
        $flag = $this->Notifications->find('exactMatch', ['project_id' => $notification['project_id'],
            'user_id' => $notification['user_id'],
            'message' => $notification['message']])->first();
        
        return !is_null($flag);
    }
}
