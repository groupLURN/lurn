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
        $this->viewBuilder()->layout('project_management');
        $this->set('project_id', $this->request->params['pass'][0]);
        return parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    }
}
