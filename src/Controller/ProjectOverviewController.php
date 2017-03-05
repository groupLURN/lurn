<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * ProjectPlanning Controller
 *
 */
class ProjectOverviewController extends AppController
{

    public function beforeFilter(Event $event)
    {
        if(empty($this->request->params['pass'])){
           return $this->redirect(['controller' => 'dashboard']);
        }
        $this->loadModel('Projects');
        
        $this->viewBuilder()->layout('project_management');

        $projectId = $this->request->params['pass'][0];
        $this->set('projectId', $projectId );
        
        $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();
        
        $this->set('isFinished', $project->is_finished );
        return parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];

        $isAdmin = $user['employee']['employee_type_id'] == 0;

        $isProjectManager = $this->Projects->Employees->find()
        ->contain(['Users'])
        ->where(['Users.id' => $user['id']])
        ->matching('EmployeeTypes', function($query){
            return $query->where(['EmployeeTypes.id' => 2]);
        })->first() !== null;

        $projectId = $this->request->params['pass'][0];

        $isUserAssigned = $this->Projects->find()
        ->matching('EmployeesJoin', function($query) use ($user) {
            return $query->where(['EmployeesJoin.user_id' => $user['id']]);
        })
        ->where(['Projects.id' => $projectId])
        ->first() !== null;
        
        return ($isUserAssigned && $isProjectManager) || $isUserAssigned || $isAdmin;
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index($projectId = null)
    {  
        $this->loadModel('ProjectPhases');

        $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();

        $projectPhases = $this->ProjectPhases->find('list')->toArray();

        $this->Projects->computeProjectStatus($project);

        $this->set(compact('project', 'projectPhases'));
        $this->set('_serialize', ['project']);
    }

    public function finishProject($projectId = null){
        if ($this->request->is(array('post', 'put'))) {
            $this->loadModel('Tasks');
            $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();

            $tasks = $this->Tasks->find('byProject', ['project_id' => $projectId])->toArray();

            $finished = 0;

            foreach ($tasks as $task) {
                if($task->is_finished == 1) {
                    $finished += 1;
                }
            }

            if($finished != count($tasks)) {
                $this->Flash->error(__('Not all of this project\'s tasks are finished.'));
                return $this->redirect(['action' => 'index', $projectId]);
            }

            $project->is_finished = 1;

            if ($this->Projects->save($project))
            {
                $this->loadModel('Notifications');

                foreach ($project['employees_join'] as $employee) {
                    $notification = $this->Notifications->newEntity();
                    $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'project-overview'], false)).'/index/'.$project->id ;
                    $notification->link = $link;
                    $notification->message = '<b>'.$project->title.'</b> is now finished. Summary reports can now be generated.';
                    $notification->user_id = $employee['user_id'];
                    $notification->project_id = $project->id;
                    $this->Notifications->save($notification);
                }

                $this->Flash->success(__('The project has been marked as finished.'));
                return $this->redirect(['action' => 'index', $projectId]);

            } else {
                $this->Flash->error(__('The project could not be marked as finished. Please, try again.'));
            }
        }
    }

    public function changePhase($projectId = null){
        if ($this->request->is(array('post', 'put'))) {
            $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();
            $postData = $this->request->data;

            $project->phase = $postData['phase'];


            if ($this->Projects->save($project))
            {
                $this->loadModel('Notifications');

                foreach ($project['employees_join'] as $employee) {
                    $notification = $this->Notifications->newEntity();
                    $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'project-overview'], false)).'/index/'.$project->id ;
                    $notification->link = $link;
                    $notification->message = '<b>'.$project->title.'</b> has changed phase.';
                    $notification->user_id = $employee['user_id'];
                    $notification->project_id = $project->id;
                    $this->Notifications->save($notification);
                }

                $this->Flash->success(__('The project has changed phase'));
                return $this->redirect(['action' => 'index', $projectId]);

            } else {
                $this->Flash->error(__('The project could not change phase.'));
            }
        }
    }

    private function isProjectDone(){

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
