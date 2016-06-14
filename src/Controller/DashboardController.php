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
