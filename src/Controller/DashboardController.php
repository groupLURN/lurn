<?php
namespace App\Controller;
    

use App\Controller\AppController;
use Cake\Collection\Collection;
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
        $this->loadModel('Milestones');

        $projects = $this->Projects->find('all');
        $milesstoneslist = $this->Milestones->find('all');
        $duestoday = $this->Projects->find('all', 
                   array('conditions'=>array('Projects.id'>0,
                                            'DATE(Projects.end_date)'=>'CURDATE()')));

         if (isset($this->params['requested']))
        {
            return $projects;
        }
        else
        {
            // you already have the posts
            //$this->set('posts', $this->Portfolio->find('all'));
            $this->set ( 'projects', $projects );
            $this->set ( 'milestoneslist', $milesstoneslist);   
            $this->set ( 'duestoday', $duestoday);
        }

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
    
}
