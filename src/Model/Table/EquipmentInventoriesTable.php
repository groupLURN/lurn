<?php
namespace App\Model\Table;

use App\Model\Entity\Equipment;
use App\Model\Entity\EquipmentInventory;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipmentInventories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 * @property \Cake\ORM\Association\BelongsTo $Equipment
 * @property \Cake\ORM\Association\BelongsTo $RentalReceiveDetails
 */
class EquipmentInventoriesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('equipment_inventories');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id'
        ]);
        $this->belongsTo('Equipment', [
            'foreignKey' => 'equipment_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RentalReceiveDetails', [
            'foreignKey' => 'rental_receive_detail_id',
            'conditions' => ['RentalReceiveDetails.end_date >= CURDATE()']
        ]);

        $this->hasMany('EquipmentTransferDetails', [
            'foreignKey' => 'equipment_inventory_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->integer('id')
            ->allowEmpty('id', 'create');

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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));
        $rules->add($rules->existsIn(['equipment_id'], 'Equipment'));
        $rules->add($rules->existsIn(['rental_receive_detail_id'], 'RentalReceiveDetails'));
        return $rules;
    }

    public function findByName(Query $query, array $options)
    {
        return $query->where(['name LIKE' => '%' . $options['name'] . '%']);
    }

    public function findByProjectId(Query $query, array $options)
    {
        if(!empty($options['project_id']))
            return $query
                ->contain(['Equipment'])
                ->where(['project_id' => $options['project_id']]);
        return $query;
    }

    public function findByTaskId(Query $query, array $options)
    {
        if(!empty($options['task_id']))
            return $query
                ->contain(['Equipment'])
                ->where(['task_id' => $options['task_id']]);
        return $query;
    }

    public function findByMilestoneId(Query $query, array $options)
    {
        if(!empty($options['milestone_id']))
            return $query->select('Tasks.milestone_id')->leftJoinWith('Tasks')
                ->having(['Tasks.milestone_id' => $options['milestone_id']]);
        return $query;
    }

    public function findBySupplierId(Query $query, array $options)
    {
        if($options['supplier_id'] > 0)
        {
            $hasSupplier = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add(['RentalRequestHeaders.supplier_id' => $options['supplier_id']]), 1
                )
            );

            $query->select(['_hasSupplier' => $hasSupplier])
                ->leftJoinWith('RentalReceiveDetails.RentalRequestDetails.RentalRequestHeaders')
                ->having('_hasSupplier > 0');
        }
        return $query;
    }

    public function findByEquipmentType(Query $query, array $options)
    {
        $equipmentTypes = array_flip(Equipment::getTypes());

        $hasInHouse = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add('rental_receive_detail_id IS NULL'), 1
            )
        );

        $hasRented = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add([
                    'rental_receive_detail_id IS NOT NULL',
                    'RentalReceiveDetails.id IS NOT NULL'
                ]), 1
            )
        );

        $query->select(['_hasInHouse' => $hasInHouse, '_hasRented' => $hasRented]);
        $query->leftJoinWith('RentalReceiveDetails');
        if((int)$options['equipment_type'] === $equipmentTypes['In-House'])
            $query->having(['_hasInHouse > 0']);
        else if((int)$options['equipment_type'] === $equipmentTypes['Rented'])
            $query->having(['_hasRented > 0']);
        return $query;
    }

    public function findProjectInventorySummary(Query $query, array $options)
    {
        if (isset($options['start_date']) && isset($options['end_date'])):
            $available_in_house_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'OR' =>
                            [
                                'EquipmentInventories.task_id IS' => null,
                                'AND' =>
                                    [
                                        'EquipmentInventories.task_id IS NOT' => null,
                                        'EquipmentInventories.task_id = Tasks.id',
                                        'Tasks.end_date <' => $options['start_date'],                                
                                    ]
                            ],
                        'AND' =>
                            [
                                'EquipmentInventories.rental_receive_detail_id IS' => null
                            ]
                    ]),
                    1,
                    'integer'
                )
            );

            $available_rented_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'OR' =>
                            [
                                'EquipmentInventories.task_id IS' => null,
                                'AND' =>
                                    [
                                        'EquipmentInventories.task_id IS NOT' => null,
                                        'EquipmentInventories.task_id = Tasks.id',
                                        'Tasks.end_date <' => $options['start_date'],                                
                                    ]
                            ],
                        'AND' =>
                            [
                                'EquipmentInventories.rental_receive_detail_id IS NOT' => null,
                                'RentalReceiveDetails.id IS NOT' => null,
                            ]
                    ]),
                    1,
                    'integer'
                )
            );

            $unavailable_in_house_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'AND' =>
                            [
                                'EquipmentInventories.task_id IS NOT' => null,
                                'EquipmentInventories.rental_receive_detail_id IS' => null,
                                'Tasks.start_date <=' => $options['end_date'],
                                'OR' => 
                                    [
                                        'Tasks.start_date <=' => $options['start_date'],
                                        'Tasks.end_date <=' => $options['end_date'],
                                    ],
                                'OR' =>
                                    [
                                        'Tasks.start_date >=' => $options['start_date'],
                                        'Tasks.end_date <=' => $options['end_date'],
                                    ],
                                'OR' =>
                                    [
                                        'Tasks.start_date >=' => $options['start_date'],
                                        'Tasks.end_date >=' => $options['end_date'],
                                    ]
                            ]
                    ]),
                    1,
                    'integer'
                )
            );

            $unavailable_rented_quantity = $query->leftJoinWith('Tasks')->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'AND' =>
                            [
                                'EquipmentInventories.task_id IS NOT' => null,
                                'EquipmentInventories.rental_receive_detail_id IS NOT' => null,
                                'RentalReceiveDetails.id IS NOT' => null,
                                'Tasks.start_date <=' => $options['end_date'],
                                'OR' => 
                                    [
                                        'Tasks.start_date <=' => $options['start_date'],
                                        'Tasks.end_date <=' => $options['end_date'],
                                    ],
                                'OR' =>
                                    [
                                        'Tasks.start_date >=' => $options['start_date'],
                                        'Tasks.end_date <=' => $options['end_date'],
                                    ],
                                'OR' =>
                                    [
                                        'Tasks.start_date >=' => $options['start_date'],
                                        'Tasks.end_date >=' => $options['end_date'],
                                    ]
                            ]
                    ]),
                    1,
                    'integer'
                )
            );

            $total_quantity = $query->leftJoinWith('Tasks')->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'OR' =>
                            [
                                'EquipmentInventories.rental_receive_detail_id IS' => null,
                                'AND' => [
                                    'EquipmentInventories.rental_receive_detail_id IS NOT' => null,
                                    'RentalReceiveDetails.id IS NOT' => null
                                ]
                            ],
                        'OR' =>
                            [
                                'AND' =>
                                    [
                                        'EquipmentInventories.task_id IS' => null,
                                    ],
                                'AND' =>
                                    [
                                        'EquipmentInventories.task_id IS NOT' => null,
                                        'Tasks.start_date <=' => $options['end_date'],
                                        'OR' => 
                                            [
                                                'Tasks.start_date <=' => $options['start_date'],
                                                'Tasks.end_date <=' => $options['end_date'],
                                            ],
                                        'OR' =>
                                            [
                                                'Tasks.start_date >=' => $options['start_date'],
                                                'Tasks.end_date <=' => $options['end_date'],
                                            ],
                                        'OR' =>
                                            [
                                                'Tasks.start_date >=' => $options['start_date'],
                                                'Tasks.end_date >=' => $options['end_date'],
                                            ]
                                    ]
                            ]
                    ]),
                    1,
                    'integer'
                )
            );
        else:
            $available_in_house_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'AND' =>
                            [
                                'EquipmentInventories.task_id IS' => null,
                                'EquipmentInventories.rental_receive_detail_id IS' => null,
                            ]
                    ]),
                    1,
                    'integer'
                )
            );

            $available_rented_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'AND' =>
                            [
                                'EquipmentInventories.task_id IS' => null,
                                'EquipmentInventories.rental_receive_detail_id IS NOT' => null,
                                'RentalReceiveDetails.id IS NOT' => null
                            ]
                    ]),
                    1,
                    'integer'
                )
            );

            $unavailable_in_house_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'AND' =>
                            [
                                'EquipmentInventories.task_id IS NOT' => null,
                                'EquipmentInventories.rental_receive_detail_id IS' => null,
                            ]
                    ]),
                    1,
                    'integer'
                )
            );

            $unavailable_rented_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'AND' =>
                            [
                                'EquipmentInventories.task_id IS NOT' => null,
                                'EquipmentInventories.rental_receive_detail_id IS NOT' => null,
                                'RentalReceiveDetails.id IS NOT' => null,
                            ]
                    ]),
                    1,
                    'integer'
                )
            );

            $total_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'OR' =>
                            [
                                'EquipmentInventories.rental_receive_detail_id IS' => null,
                                'AND' => [
                                    'EquipmentInventories.rental_receive_detail_id IS NOT' => null,
                                    'RentalReceiveDetails.id IS NOT' => null
                                ]
                            ]
                    ]),
                    1,
                    'integer'
                )
            );
        endif;

        if(isset($options['id']))
            $query = $query->where(['Equipment.id' => $options['id']]);

        return $query->select(['Equipment.id', 'Equipment.name', 'last_modified' => 'EquipmentInventories.modified',
                'available_in_house_quantity' => $available_in_house_quantity,
                'available_rented_quantity' => $available_rented_quantity,
                'unavailable_in_house_quantity' => $unavailable_in_house_quantity,
                'unavailable_rented_quantity' => $unavailable_rented_quantity,
                'total_quantity' => $total_quantity])
                ->contain(['Equipment'])
                ->leftJoinWith('RentalReceiveDetails')
                ->where(['EquipmentInventories.project_id' => $options['project_id']])
                ->group(['Equipment.id']);
    }
}
