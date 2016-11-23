<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * ProjectPlanning Controller
 *
 */
class ProjectOverviewController extends AppController
{

    public function beforeFilter(Event $event)
    {
        if(empty($this->request->params['pass']))
            return $this->redirect(['controller' => 'dashboard']);

        $this->viewBuilder()->layout('project_management');
        $this->set('projectId', $this->request->params['pass'][0]);
        return parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index($projectId = null)
    {   

        $this->loadModel('Projects');
        $project = $this->Projects->get($projectId, [
            'contain' => ['Clients', 'Employees', 'EmployeesJoin' => [
            'EmployeeTypes'
            ]]
        ]);

        if ($this->request->is('post')) {
            $project->is_finished = true;
            // if ($this->Projects->save($project))
            // {
            //     $this->loadModel('Notifications');

            //     foreach ($project['employees_join'] as $employee) {
            //         $notification = $this->Notifications->newEntity();
            //         $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'project-overview', 
            //             'action' => 'index'], false)).'/'.$project->id ;
            //         $notification->link = $link;
            //         $notification->message = '<b>'.$project->title.'</b> is now finished.';
            //         $notification->user_id = $employee['user_id'];
            //         $notification->project_id = $project->id;
            //         $this->Notifications->save($notification);
            //     }

            //     $this->Flash->success(__('The project has been marked as finished.'));
            //     return $this->redirect(['action' => 'index']);

            // } else {
            //     $this->Flash->error(__('The project could not be marked as finished. Please, try again.'));
            // }
        }

        $this->Projects->computeProjectStatus($project);

        $this->set('project', $project);
        $this->set('_serialize', ['project']);
    }



    public function isProjectDone(){

        $response = [];
        if(!isset($this->request->query['project_id'])){            

            $response['status'] = 'failed';
            $response['data']   = 'project_id is not given';
        } else {
            $projectId          = $this->request->query['project_id'];
            $tasks              = $this->Tasks->find('byProject', ['project_id' => $projectId])->toArray();
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

            $response['status'] = 'success';
            $response['data']   = ['done' => $progress === 100 ? true : false];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}
