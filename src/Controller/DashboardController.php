<?php
namespace App\Controller;
    

use App\Controller\AppController;
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
        $projects = $this->Projects->find('all');

         if (isset($this->params['requested']))
        {
            return $projects;
        }
        else
        {
            // you already have the posts
            //$this->set('posts', $this->Portfolio->find('all'));
            $this->set ( 'projects', $projects );
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
