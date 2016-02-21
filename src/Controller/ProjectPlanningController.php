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

    public function createGanttChart($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            list($milestones, $tasks) = $this->__ganttBackEndAdapter($this->request->data, $id);

            // Patch Tasks first to retain the previous value for is_finished.
            $taskEntities = $this->__patchTasks($tasks);

            foreach($taskEntities as $entity)
            {
                $entityJson = json_decode($entity, true);
                unset($entityJson['created'], $entityJson['modified']);
                $milestones[$entity->parent_uid]['tasks'][] = $entityJson;
            }

            $milestoneEntities = $this->__patchMilestones($milestones);

            $isSuccessful = TableRegistry::get('Milestones')->connection()->transactional(
                function() use ($milestoneEntities, $taskEntities){
                    $isSuccessful = true;
                    foreach($milestoneEntities as $entity)
                        $isSuccessful = $isSuccessful && TableRegistry::get('Milestones')->save($entity, ['atomic' => false]);
                    return $isSuccessful;
                }
            );

            if ($isSuccessful) {
                $this->Flash->success(__('The gantt chart has been saved.'));
                return $this->redirect(['action' => 'createGanttChart', $id]);
            } else {
                $this->Flash->error(__('The gantt chart could not be saved. Please, try again.'));
            }
        }
        else
        {
            $query = TableRegistry::get('Milestones')->find()
                ->contain('Tasks')
                ->where(['project_id' => $id]);

            $this->set('ganttData', json_encode($this->__ganttFrontEndAdapter($query)));
        }
    }

    public function manageTasksAndResources($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

        }
        else
        {

        }

        list($kanbanColumns, $kanbanData) = $this->__kanbanFrontEndAdapter($id);
        $kanbanColumns = json_encode($kanbanColumns);
        $kanbanData = json_encode($kanbanData);
        $this->set(compact('kanbanColumns', 'kanbanData'));
        $this->set('projectId', $id);
    }


//////////////////// Private methods

    private function __kanbanCreateCondition($status, $query, $conditions = [])
    {
        $clone = clone $query;
        return $clone->matching('Tasks', function($query) use ($conditions)
        {
            return $query->where($conditions);
        })->select(['status' => $query->func()->concat([$status])])
            ->select(TableRegistry::get('Milestones'))->all();
    }

    private function __kanbanFrontEndAdapter($projectId)
    {
        $query = TableRegistry::get('Milestones')->find()
            ->contain('Tasks')
            ->where(['Milestones.project_id' => $projectId]);

        // Pending
        $pending = $this->__kanbanCreateCondition('Pending', $query,
            ['Tasks.is_finished' => 0, 'Tasks.start_date >' => new DateTime('now')]);

        // In Progress
        $inProgress = $this->__kanbanCreateCondition('In Progress', $query,
            ['Tasks.is_finished' => 0, 'Tasks.start_date <=' => new DateTime('now'),
                'Tasks.end_date >=' => new DateTime('now')]);

        // Done
        $done = $this->__kanbanCreateCondition('Done', $query,
            ['Tasks.is_finished' => 1]);

        // Overdue
        $overdue = $this->__kanbanCreateCondition('Overdue', $query,
            ['Tasks.is_finished' => 0, 'Tasks.end_date <' => new DateTime('now')]);

        $kanbanColumns = [
            ['header' => 'Pending'],
            ['header' => 'In Progress'],
            ['header' => 'Done'],
            ['header' => 'Overdue']
        ];

        $kanbanData = [];
        $iterator = 0;
        foreach([$pending, $inProgress, $done, $overdue] as $collection)
        {
            if(count($collection) === 0)
                $kanbanColumns[$iterator]['body'] = [
                    'view' => 'kanbanlist'
                ];
            else
                $kanbanColumns[$iterator]['body'] = [
                    'view' => 'tabview',
                    'tabbar' => ['topOffset' => 2],
                    'cells' => []
                ];

            $hashUniqueMilestones = [];
            foreach($collection as $milestone)
            {
                if(!isset($hashUniqueMilestones[$milestone->id]))
                    $hashUniqueMilestones[$milestone->id] = [
                        'header' => $milestone->title,
                        'body' => [
                            'view' => 'kanbanlist',
                            'status' => [
                                'team' => $milestone->id,
                                'status' => $milestone->status
                            ]
                        ]
                    ];

                foreach($milestone['tasks'] as $task)
                {
                    $kanbanData[] = [
                        'id' => $task->id,
                        'team' => $milestone->id,
                        'status' => $milestone->status,
                        'text' => $task->title
                    ];
                }
            }
            $kanbanColumns[$iterator]['body']['cells'] = array_values($hashUniqueMilestones);
            $iterator++;
        }

        return [$kanbanColumns, $kanbanData];
    }

    private function __ganttBackEndAdapter($requestData, $projectId)
    {
        $serializedJson = json_decode($requestData['data'], true);
        $milestones = $tasks = [];
        foreach($serializedJson['data'] as $row)
        {
            // This is a milestone.
            if($row['parent'] === 0)
                $milestones[(string)$row['id']] = [
                    'id' => (string) $row['id'],
                    'project_id' => (int)$projectId,
                    'title' => $row['text'],
                    'start_date' => (new DateTime($row['start_date']))->format('Y-m-d H:i:s'),
                    'end_date' => (new DateTime($row['end_date']))->format('Y-m-d H:i:s')
                ];
            else
                $tasks[(string)$row['id']] = [
                    'id' => (string) $row['id'],
                    'milestone_id' => (int) $row['parent'],
                    'title' => $row['text'],
                    'start_date' => (new DateTime($row['start_date']))->format('Y-m-d H:i:s'),
                    'end_date' => (new DateTime($row['end_date']))->format('Y-m-d H:i:s'),
                    'parent_uid' => (string) $row['parent']
                ];
        }
        return [$milestones, $tasks];
    }

    private function __ganttFrontEndAdapter($query)
    {
        $data = [];
        foreach($query as $milestone)
        {
            $data[] = [
                'id' => $milestone->id,
                'parent' => 0,
                'text' => $milestone->title,
                'start_date' => $milestone->start_date->format('d-m-Y'),
                'end_date' => $milestone->end_date->format('d-m-Y')
            ];

            if(isset($milestone['tasks']))
                foreach($milestone['tasks'] as $task)
                    $data[] = [
                        'id' => $task->id,
                        'parent' => $milestone->id,
                        'text' => $task->title,
                        'start_date' => $task->start_date->format('d-m-Y'),
                        'end_date' => $task->end_date->format('d-m-Y')
                    ];
        }
        return ['data' => $data, 'link' => []];
    }

    private function __patchMilestones($milestones)
    {
        $milestoneEntities = [];
        foreach($milestones as $milestone)
        {
            try
            {
                $entity = TableRegistry::get('Milestones')->get($milestone['id'], [
                    'contain' => ['Tasks']
                ]);

                $milestoneEntities[] = TableRegistry::get('Milestones')->patchEntity($entity, $milestone, [
                    'associated' => ['Tasks']
                ]);
            }
            catch(\Cake\Datasource\Exception\RecordNotFoundException $e)
            {
                $milestoneEntities[] = TableRegistry::get('Milestones')->newEntity($milestone, [
                    'associated' => ['Tasks']
                ]);
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
                $entity = TableRegistry::get('Tasks')->newEntity($task);
                $entity->set('is_finished', false);
                $taskEntities[] = $entity;
            }
        }
        return $taskEntities;
    }
}
