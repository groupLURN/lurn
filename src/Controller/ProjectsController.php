<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Collection\Collection;

/**
* Projects Controller
*
* @property \App\Model\Table\ProjectsTable $Projects
*/
class ProjectsController extends AppController
{

/**
* Index method
*
* @return \Cake\Network\Response|null
*/
public function index()
{
	$this->paginate = [
	'contain' => ['Clients', 'Employees', 'Milestones' => ['Tasks'], 'ProjectPhases']
	];

	$this->paginate += [
	'finder' =>
	array_merge(
		$this->createFinders($this->request->query)['finder'],
		[
		'ByAuthorization' => ['user_id' => $this->Auth->user('id')]
		]
		)
	];

	$projects = $this->paginate($this->Projects);
	foreach($projects as $project)
	{
		$this->Projects->computeProjectStatus($project);
		$milestones = new Collection($project->milestones);
		list($finishedTasks, $totalTasks) = $milestones->reduce(function($accumulated, $milestone)
		{
			$tasks = new Collection($milestone->tasks);

			list($finishedTasks, $totalTasks) = $tasks->reduce(function($accumulated, $task)
			{
				return [$accumulated[0] + $task->is_finished, $accumulated[1] + 1];
			}, [0, 0]);

			return [$accumulated[0] + $finishedTasks, $accumulated[1] + $totalTasks];
		}, [0, 0]);
		if($totalTasks > 0)
			$project->progress = $finishedTasks / $totalTasks * 100;
		else
			$project->progress = 0;
	}

	$projectStatuses = $this->Projects->getProjectStatusList();

	$this->set(compact('projects', 'projectStatuses'));
	$this->set($this->request->query);
	$this->set('_serialize', ['projects']);
}

/**
* View method
*
* @param string|null $id Project id.
* @return \Cake\Network\Response|null
* @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
*/
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

/**
* Add method
*
* @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
*/
public function add()
{
	$this->loadModel('Clients');
	$this->loadModel('Employees');

	$project 		= $this->Projects->newEntity();

	if ($this->request->is('post'))
	{	
		$loggedInUser 	= $this->Auth->user();
		$projectManager = $this->Employees->find('byUserId', ['user_id' => $loggedInUser['id']])->toArray();
		$companyOwner	= $this->Employees->find('byEmployeeTypeId', ['employee_type_id' => 1])->toArray();
		$postData = $this->request->data;
		$postData['employees_join']['_ids'] = [];
		array_push($postData['employees_join']['_ids'], $postData['project-engineer']);
		array_push($postData['employees_join']['_ids'], $postData['warehouse-keeper']);

		$project = $this->Projects->patchEntity($project, $postData);		

		$project['project_manager_id'] = $projectManager[0]['id'];
		
		array_push($project['employees_join'], $projectManager[0]);		
		array_push($project['employees_join'], $companyOwner[0]);

		if ($this->Projects->save($project))
		{
			$this->loadModel('Notifications');

			foreach ($project['employees_join'] as $employee) {
				$notification = $this->Notifications->newEntity();
				$link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'projects', 
					'action' => 'view/'.$project->id ], false));
				$notification->link = $link;
				$notification->message = 'You have been added to the <b>'.$project->title.'</b> project.';
				$notification->user_id = $employee['user_id'];
				$notification->project_id = $project->id;
				$this->Notifications->save($notification);
			}

			$this->Flash->success(__('The project has been saved.'));
			return $this->redirect(['action' => 'index']);

		} else {
			$this->Flash->error(__('The project could not be saved. Please, try again.'));
		}

	}

	$clients = $this->Clients->find('list', ['limit' => 200]);

	$projectEngineers = $this->Employees->find('list', [
		'conditions' => ['employee_type_id =' => 3],
		'limit' => 200

		])->toArray();

	$warehouseKeepers = $this->Employees->find('list', [
		'conditions' => ['employee_type_id =' => 4],
		'limit' => 200

		])->toArray();

	$skilledWorkers = $this->Employees->find('list', [
		'conditions' => ['employee_type_id =' => 5],
		'limit' => 200

		])->toArray();

	$employees = $this->Employees->find('list', ['limit' => 200]);
	$this->set(compact('project', 'clients', 'employees', 'projectEngineers', 'warehouseKeepers', 'skilledWorkers'));
	$this->set('_serialize', ['project']);
}

/**
* Edit method
*
* @param string|null $id Project id.
* @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
* @throws \Cake\Network\Exception\NotFoundException When record not found.
*/
public function edit($id = null)
{
	$project = $this->Projects->get($id, [
		'contain' => ['Employees', 'EmployeesJoin']
		]);
	if ($this->request->is(['patch', 'post', 'put'])) {
		$project = $this->Projects->patchEntity($project, $this->request->data);
		if ($this->Projects->save($project)) {
			$this->Flash->success(__('The project has been saved.'));
			return $this->redirect(['action' => 'index']);
		} else {
			$this->Flash->error(__('The project could not be saved. Please, try again.'));
		}
	}
	$clients = $this->Projects->Clients->find('list', ['limit' => 200]);
	$employees = $this->Projects->Employees->find('list', ['limit' => 200]);
	$employeesJoin = $this->Projects->EmployeesJoin->find('list', ['limit' => 200])->toArray();

	$currentEmployeesJoin = [];
	foreach($project->employees_join as $employee)
		$currentEmployeesJoin[] = $employee->id;

	$this->set(compact('project', 'clients', 'employees', 'employeesJoin', 'currentEmployeesJoin'));
	$this->set('_serialize', ['project']);
}

/**
* Delete method
*
* @param string|null $id Project id.
* @return \Cake\Network\Response|null Redirects to index.
* @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
*/
public function delete($id = null)
{
	$this->request->allowMethod(['post', 'delete']);
	$project = $this->Projects->get($id);
	if ($this->Projects->delete($project)) {
		$this->Flash->success(__('The project has been deleted.'));
	} else {
		$this->Flash->error(__('The project could not be deleted. Please, try again.'));
	}
	return $this->redirect(['action' => 'index']);
}


public function getProjectList()
{
	return $this->Project->findAll();
}


public function isAuthorized($user)
{
	$action = $this->request->params['action'];

	$isProjectManager = $this->Projects->Employees->find()
	->contain(['Users'])
	->where(['Users.id' => $user['id']])
	->matching('EmployeeTypes', function($query){
		return $query->where(['EmployeeTypes.title' => 'Project Manager/Project Supervisor']);
	})->first() !== null;

	if (in_array($action, ['edit', 'add', 'delete']))
		return $isProjectManager;
	else if (in_array($action, ['view']))
	{
		$projectId = $this->request->params['pass'][0];

		$isUserAssigned = $this->Projects->find()
		->matching('EmployeesJoin', function($query) use ($user) {
			return $query->where(['EmployeesJoin.user_id' => $user['id']]);
		})
		->where(['Projects.id' => $projectId])
		->first() !== null;

		return $isUserAssigned || $isProjectManager;
	}

	return parent::isAuthorized($user);
}
}
