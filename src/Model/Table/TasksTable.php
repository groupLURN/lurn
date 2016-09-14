<?php
namespace App\Model\Table;

use App\Model\Entity\Task;
use ArrayObject;
use Cake\Collection\Collection;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Tasks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Milestones
 * @property \Cake\ORM\Association\HasMany $EquipmentInventories
 * @property \Cake\ORM\Association\HasMany $EquipmentReplenishmentDetails
 * @property \Cake\ORM\Association\HasMany $Manpower
 * @property \Cake\ORM\Association\HasMany $ManpowerTypeReplenishmentDetails
 * @property \Cake\ORM\Association\HasMany $MaterialReplenishmentDetails
 * @property \Cake\ORM\Association\HasMany $MaterialsTaskInventories
 * @property \Cake\ORM\Association\BelongsToMany $Equipment
 * @property \Cake\ORM\Association\BelongsToMany $ManpowerTypes
 * @property \Cake\ORM\Association\BelongsToMany $Materials
 */
class TasksTable extends Table
{
    public $status = [
        'All' => 0,
        'Pending' => 1,
        'In Progress' => 2,
        'Done' => 3,
        'Overdue' => 4
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('tasks');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        // Projects
        $this->belongsTo('Projects', [
            'className'     => 'Milestones',
            'foreignKey'    => 'project_id',
            'joinType'      => 'INNEER'
        ]);

        // Milestone
        $this->belongsTo('Milestones', [
            'foreignKey'    => 'milestone_id',
            'joinType'      => 'LEFT'
        ]);

        // Task Inventories
        $this->hasMany('EquipmentInventories', [
            'foreignKey' => 'task_id'
        ]);
        $this->hasMany('Manpower', [
            'foreignKey' => 'task_id'
        ]);
        $this->hasMany('MaterialsTaskInventories', [
            'foreignKey' => 'task_id'
        ]);

        // Resources Needed
        $this->belongsToMany('Equipment', [
            'foreignKey' => 'task_id',
            'targetForeignKey' => 'equipment_id',
            'joinTable' => 'equipment_tasks'
        ]);
        $this->belongsToMany('ManpowerTypes', [
            'foreignKey' => 'task_id',
            'targetForeignKey' => 'manpower_type_id',
            'joinTable' => 'manpower_types_tasks'
        ]);
        $this->belongsToMany('Materials', [
            'foreignKey' => 'task_id',
            'targetForeignKey' => 'material_id',
            'joinTable' => 'materials_tasks'
        ]);

        // Record of Replenishment
        $this->hasMany('EquipmentReplenishmentDetails', [
            'foreignKey' => 'task_id'
        ]);

        $this->hasMany('ManpowerTypeReplenishmentDetails', [
            'foreignKey' => 'task_id'
        ]);
        $this->hasMany('MaterialReplenishmentDetails', [
            'foreignKey' => 'task_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->boolean('is_finished')
            ->requirePresence('is_finished', 'create')
            ->notEmpty('is_finished');

        $validator
            ->dateTime('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');

        $validator
            ->dateTime('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');

        $validator
            ->allowEmpty('comments');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['milestone_id'], 'Milestones'));
        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        foreach (['start_date', 'end_date'] as $key) {
            if (isset($data[$key]) && is_string($data[$key])) {
                $data[$key] = Time::parseDateTime($data[$key], 'yyyy/MM/dd');
            }
        }
    }

    public function findByProject(Query $query, array $options)
    {
        if((int)$options['project_id'] > -1)
            return $query
                ->join([
                    'm' => [
                        'table' => 'milestones',
                        'type' => 'INNER',
                        'conditions' => ['m.project_id' => (int)$options['project_id'],
                            'm.id = milestone_id']
                    ]
                ]);
        else
            return $query;
    }

    public function findByProjectAndMilestone(Query $query, array $options)
    {
        if((int)$options['milestone_id'] > -1 && (int)$options['project_id'] > -1)
            return $query
                ->where(['milestone_id' => $options['milestone_id']])
                ->join([
                    'm' => [
                        'table' => 'milestones',
                        'type' => 'INNER',
                        'conditions' => ['m.project_id' => (int)$options['project_id'],
                            'm.id = milestone_id']
                    ]
                ])
                ;
        else
            return $query;
    }

    public function computeForTaskReplenishmentUsingMilestones($milestones)
    {
        foreach($milestones as $milestone)
            foreach($milestone->tasks as &$task)
            {
                $this->computeForTaskReplenishment($task);
            }
    }

    public function computeForTaskReplenishment($task)
    {
        // Compute for the in-stock quantity by SUM-ming.
        $collection = new Collection($task->equipment_replenishment_details);
        $equipmentDetails = $collection->reduce(function($accumulated, $detail)
        {
            if(isset($accumulated[$detail->equipment_id]))
                $accumulated[$detail->equipment_id] += $detail->quantity;
            else
                $accumulated[$detail->equipment_id] = $detail->quantity;

            return $accumulated;
        }, []);

        // Compute for the in-stock quantity by SUM-ming.
        $collection = new Collection($task->manpower_type_replenishment_details);
        $manpowerTypeDetails = $collection->reduce(function($accumulated, $detail)
        {
            if(isset($accumulated[$detail->manpower_type_id]))
                $accumulated[$detail->manpower_type_id] += $detail->quantity;
            else
                $accumulated[$detail->manpower_type_id] = $detail->quantity;

            return $accumulated;
        }, []);

        // Compute for the in-stock quantity by SUM-ming.
        $collection = new Collection($task->material_replenishment_details);
        $materialDetails = $collection->reduce(function($accumulated, $detail)
        {
            if(isset($accumulated[$detail->material_id]))
                $accumulated[$detail->material_id] += $detail->quantity;
            else
                $accumulated[$detail->material_id] = $detail->quantity;

            return $accumulated;
        }, []);

        // Add in-stock quantity.
        foreach($task->equipment as $equipment)
        {
            $equipment['_joinData']['in_stock_quantity'] = isset($equipmentDetails[$equipment['id']])?
                $equipmentDetails[$equipment['id']]: 0;
            $equipment['_joinData']['quantity_remaining'] = $equipment['_joinData']['quantity'] -
                $equipment['_joinData']['in_stock_quantity'];
        }


        foreach($task->manpower_types as $manpowerType)
        {
            $manpowerType['_joinData']['in_stock_quantity'] = isset($manpowerTypeDetails[$manpowerType['id']])?
                $manpowerTypeDetails[$manpowerType['id']]: 0;
            $manpowerType['_joinData']['quantity_remaining'] = $manpowerType['_joinData']['quantity'] -
                $manpowerType['_joinData']['in_stock_quantity'];
        }


        foreach($task->materials as $material)
        {
            $material['_joinData']['in_stock_quantity'] = isset($materialDetails[$material['id']])?
                $materialDetails[$material['id']]: 0;
            $material['_joinData']['quantity_remaining'] = $material['_joinData']['quantity'] -
                $material['_joinData']['in_stock_quantity'];
        }

        // Lastly, compute for total percentage of the current stock versus what is needed.
        $ratio = [0, 0];
        $collection = new Collection($task->equipment);
        $ratio = $collection->reduce(function($accumulated, $detail)
        {
            return [
                $accumulated[0] + $detail['_joinData']['in_stock_quantity'],
                $accumulated[1] + $detail['_joinData']['quantity']
            ];
        }, $ratio);

        $collection = new Collection($task->manpower_types);
        $ratio = $collection->reduce(function($accumulated, $detail)
        {
            return [
                $accumulated[0] + $detail['_joinData']['in_stock_quantity'],
                $accumulated[1] + $detail['_joinData']['quantity']
            ];
        }, $ratio);

        $collection = new Collection($task->materials);
        $ratio = $collection->reduce(function($accumulated, $detail)
        {
            return [
                $accumulated[0] + $detail['_joinData']['in_stock_quantity'],
                $accumulated[1] + $detail['_joinData']['quantity']
            ];
        }, $ratio);

        if($ratio[1] > 0)
            $task->replenishment = ($ratio[0]/$ratio[1]) * 100;
        else
            $task->replenishment = 0;
    }

    public function replenish($task)
    {
        return
            $this->connection()->transactional(function() use ($task)
            {
                foreach($task->equipment as $resource)
                {
                    $equipmentInventories = TableRegistry::get('EquipmentInventories')->find()
                        ->where([
                            'project_id' => $task->milestone->project_id,
                            'task_id IS NULL',
                            'equipment_id' => $resource->id
                        ])
                        ->toArray();
                    $size = count($equipmentInventories);
                    $quantityTransferred = 0;
                    for($i = 0; $i < $size && $i < $resource['_joinData']['quantity_remaining']; $i++)
                    {
                        $entity = $equipmentInventories[$i];
                        $entity->task_id = $task->id;
                        TableRegistry::get('EquipmentInventories')->save($entity, ['atomic' => false]);
                        $quantityTransferred++;
                    }

                    $entity = TableRegistry::get('EquipmentReplenishmentDetails')->newEntity([
                        'task_id' => $task->id,
                        'equipment_id' => $resource->id,
                        'quantity' => $quantityTransferred
                    ]);
                    TableRegistry::get('EquipmentReplenishmentDetails')->save($entity, ['atomic' => false]);
                }

                foreach($task->manpower_types as $resource)
                {
                    $manpowerInventories = TableRegistry::get('Manpower')->find()
                        ->where([
                            'project_id' => $task->milestone->project_id,
                            'task_id IS NULL',
                            'manpower_type_id' => $resource->id
                        ])
                        ->toArray();
                    $size = count($manpowerInventories);
                    $quantityTransferred = 0;
                    for($i = 0; $i < $size && $i < $resource['_joinData']['quantity_remaining']; $i++)
                    {
                        $entity = $manpowerInventories[$i];
                        $entity->task_id = $task->id;
                        TableRegistry::get('Manpower')->save($entity, ['atomic' => false]);
                        $quantityTransferred++;
                    }

                    $entity = TableRegistry::get('ManpowerTypeReplenishmentDetails')->newEntity([
                        'task_id' => $task->id,
                        'manpower_type_id' => $resource->id,
                        'quantity' => $quantityTransferred
                    ]);
                    TableRegistry::get('ManpowerTypeReplenishmentDetails')->save($entity, ['atomic' => false]);
                }

                foreach($task->materials as $resource)
                {
                    $materialInventory = TableRegistry::get('MaterialsProjectInventories')->find()
                        ->where([
                            'material_id' => $resource->id,
                            'project_id' => $task->milestone->project_id
                        ])
                        ->first();

                    if($materialInventory === null)
                        continue;

                    if($materialInventory->quantity < $resource['_joinData']['quantity_remaining'])
                        $quantityTransferred = $materialInventory->quantity;
                    else
                        $quantityTransferred = $resource['_joinData']['quantity_remaining'];

                    $materialInventory->quantity -= $quantityTransferred;
                    TableRegistry::get('MaterialsProjectInventories')->save($materialInventory, ['atomic' => false]);

                    $materialInventory = TableRegistry::get('MaterialsTaskInventories')->find()
                        ->where([
                            'material_id' => $resource->id,
                            'project_id' => $task->milestone->project_id,
                            'task_id' => $task->id
                        ])
                        ->first();

                    if($materialInventory !== null)
                        $materialInventory->quantity += $quantityTransferred;
                    else
                        $materialInventory = TableRegistry::get('MaterialsTaskInventories')->newEntity([
                            'material_id' => $resource->id,
                            'project_id' => $task->milestone->project_id,
                            'task_id' => $task->id,
                            'quantity' => $quantityTransferred
                        ]);
                    TableRegistry::get('MaterialsTaskInventories')->save($materialInventory, ['atomic' => false]);

                    $entity = TableRegistry::get('MaterialReplenishmentDetails')->newEntity([
                        'task_id' => $task->id,
                        'material_id' => $resource->id,
                        'quantity' => $quantityTransferred
                    ]);
                    TableRegistry::get('MaterialReplenishmentDetails')->save($entity, ['atomic' => false]);
                }
                return true;
            });
    }

    public function returnToProjectInventory($task, $materials)
    {
        return
            $this->connection()->transactional(function() use ($task, $materials)
            {
                // Return all equipment to project inventory.
                $equipmentInventories = TableRegistry::get('EquipmentInventories')->find()
                    ->where([
                        'project_id' => $task->milestone->project_id,
                        'task_id' => $task->id
                    ])
                    ->toArray();
                foreach($equipmentInventories as $equipmentInventory)
                {
                    $equipmentInventory->task_id = null;
                    TableRegistry::get('EquipmentInventories')->save($equipmentInventory, ['atomic' => false]);
                }

                // Return all manpower to project inventory.
                $manpower = TableRegistry::get('Manpower')->find()
                    ->where([
                        'project_id' => $task->milestone->project_id,
                        'task_id' => $task->id
                    ])
                    ->toArray();
                foreach($manpower as $manpower_)
                {
                    $manpower_->task_id = null;
                    TableRegistry::get('Manpower')->save($manpower_, ['atomic' => false]);
                }

                // Return selectively materials to project inventory.
                foreach($materials as $material)
                {
                    $materialInventory = TableRegistry::get('MaterialsTaskInventories')->find()
                        ->where([
                            'material_id' => $material['id'],
                            'project_id' => $task->milestone->project_id,
                            'task_id' => $task->id
                        ])
                        ->first();

                    if($materialInventory === null)
                        continue;

                    $materialInventory->quantity = $material['in_stock_quantity'] - $material['quantity_used'];
                    TableRegistry::get('MaterialsTaskInventories')->save($materialInventory, ['atomic' => false]);

                    $materialInventory = TableRegistry::get('MaterialsProjectInventories')->find()
                        ->where([
                            'material_id' => $material['id'],
                            'project_id' => $task->milestone->project_id
                        ])
                        ->first();

                    $materialInventory->quantity += $material['quantity_used'];
                    TableRegistry::get('MaterialsProjectInventories')->save($materialInventory, ['atomic' => false]);
                }
                return true;
            });
    }
}
