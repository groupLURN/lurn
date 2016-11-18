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
        $this->Projects->computeProjectStatus($project);
        $this->set('project', $project);
        $this->set('_serialize', ['project']);
    }
}
