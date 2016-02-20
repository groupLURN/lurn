<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;
use DateTime;

/**
 * ProjectPlanning Controller
 *
 */
class ProjectPlanningController extends ProjectOverviewController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    }

    private function __ganttDataAdapter($requestData, $projectId)
    {
        $serializedJson = json_decode($requestData['data'], true);
        $milestones = $tasks = [];
        foreach($serializedJson['data'] as $row)
        {
            // This is a milestone.
            if($row['parent'] === 0)
                $milestones[(string)$row['id']] = [
                    'id' => (int) $row['id'],
                    'project_id' => (int)$projectId,
                    'title' => $row['text'],
                    'start_date' => (new DateTime($row['start_date']))->format('Y-m-d H:i:s'),
                    'end_date' => (new DateTime($row['end_date']))->format('Y-m-d H:i:s')
                ];
            else
                $tasks[(string)$row['id']] = [
                    'id' => (int) $row['id'],
                    'milestone_id' => $row['parent'],
                    'title' => $row['text'],
                    'is_finished' => false,
                    'start_date' => (new DateTime($row['start_date']))->format('Y-m-d H:i:s'),
                    'end_date' => (new DateTime($row['end_date']))->format('Y-m-d H:i:s')
                ];
        }
        return [$milestones, $tasks];
    }

    private function __patchMilestones($milestones)
    {
        $milestoneEntities = [];
        foreach($milestones as $milestone)
        {
            try
            {
                $entity = TableRegistry::get('Milestones')->get($milestone['id']);
                $milestoneEntities[] = TableRegistry::get('Milestones')->patchEntity($entity, $milestone);
            }
            catch(\Cake\Datasource\Exception\RecordNotFoundException $e)
            {
                $milestoneEntities[] = TableRegistry::get('Milestones')->newEntity($milestone);
            }
        }
        return $milestoneEntities;
    }

    private function __patchTasks($tasks)
    {
        $taskEntities = [];
        foreach($tasks as $task)
        {
            try
            {
                $entity = TableRegistry::get('Tasks')->get($task['id']);
                $taskEntities[] = TableRegistry::get('Tasks')->patchEntity($entity, $task);
            }
            catch(\Cake\Datasource\Exception\RecordNotFoundException $e)
            {
                $taskEntities[] = TableRegistry::get('Tasks')->newEntity($task);
            }
        }
        return $taskEntities;
    }

    public function createGanttChart($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            $tasksTable = TableRegistry::get('Tasks');

            list($milestones, $tasks) = $this->__ganttDataAdapter($this->request->data, $id);

            $milestoneEntities = $this->__patchMilestones($milestones);
            $taskEntities = $this->__patchTasks($tasks);

            $isSuccessful = TableRegistry::get('Milestones')->connection()->transactional(
                function() use ($milestoneEntities, $taskEntities){
                    $isSuccessful = true;
                    foreach($milestoneEntities as $entity)
                        $isSuccessful = $isSuccessful && TableRegistry::get('Milestones')->save($entity, ['atomic' => false]);
                    debug($isSuccessful);

                    foreach($taskEntities as $entity)
                        $isSuccessful = $isSuccessful && TableRegistry::get('Tasks')->save($entity, ['atomic' => false]);
                    debug($isSuccessful);
                    return $isSuccessful && false;
                }
            );

            if ($isSuccessful) {
                $this->Flash->success(__('The gantt chart has been saved.'));
            } else {
                $this->Flash->error(__('The gantt chart could not be saved. Please, try again.'));
            }
        }
    }

}
