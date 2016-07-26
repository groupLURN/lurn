<?php
namespace App\Model\Table;

use App\Model\Entity\Manpower;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Manpower Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 * @property \Cake\ORM\Association\BelongsTo $ManpowerTypes
 */
class ManpowerTable extends Table
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

        $this->table('manpower');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id'
        ]);
        $this->belongsTo('ManpowerTypes', [
            'foreignKey' => 'manpower_type_id',
            'joinType' => 'INNER'
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

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));
        $rules->add($rules->existsIn(['manpower_type_id'], 'ManpowerTypes'));
        return $rules;
    }

    public function findByName(Query $query, array $options)
    {
        return $query->where(function($exp) use ($options){
            return $exp->like('name', '%' . $options['name'] . '%');
        });
    }

    public function findByProjectId(Query $query, array $options)
    {
        if($options['project_id'] > 0)
            return $query->where(['project_id' => $options['project_id']]);
        return $query;
    }

    public function findByManpowerTypeId(Query $query, array $options)
    {
        if((int)$options['manpower_type_id'] > 0)
            return $query->where(['manpower_type_id' => $options['manpower_type_id']]);
        else
            return $query;
    }

    public function findByMilestoneId(Query $query, array $options)
    {
        if(!empty($options['milestone_id']))
            return $query->select('Tasks.milestone_id')->leftJoinWith('Tasks')
                ->having(['Tasks.milestone_id' => $options['milestone_id']]);
        return $query;
    }

    public function findGeneralInventorySummary(Query $query, array $options)
    {
        $available_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add(['Manpower.project_id IS' => null]),
                1,
                'integer'
            )
        );

        $unavailable_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add(['Manpower.project_id IS NOT' => null]),
                1,
                'integer'
            )
        );

        $total_quantity = $query->func()->count('Manpower.id');

        if(isset($options['id']))
            $query = $query->where(['ManpowerTypes.id' => $options['id']]);

        return $query->select(['ManpowerTypes.id', 'ManpowerTypes.title', 'last_modified' => 'Manpower.modified',
            'available_quantity' => $available_quantity,
            'unavailable_quantity' => $unavailable_quantity,
            'total_quantity' => $total_quantity])
            ->contain(['ManpowerTypes'])
            ->group('ManpowerTypes.id');
    }

    public function findProjectInventorySummary(Query $query, array $options)
    {
        if (isset($options['start_date']) && isset($options['end_date'])):
            $available_quantity = $query->leftJoinWith('Tasks')->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'OR' =>
                            [
                                'Manpower.task_id IS' => null,
                                'AND' =>
                                    [
                                        'Manpower.task_id IS NOT' => null,
                                        'Manpower.task_id = Tasks.id',
                                        'Tasks.end_date <' => $options['start_date'],                                
                                    ]
                            ],
                        'AND' =>
                            [
                                'Manpower.project_id IS NOT' => null,
                            ]
                    ]),
                    1,
                    'integer'
                )
            );

            $unavailable_quantity = $query->leftJoinWith('Tasks')->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add([
                        'AND' =>
                            [
                                'Manpower.project_id IS NOT' => null, 
                                'Manpower.task_id IS NOT' => null,
                                'Manpower.task_id = Tasks.id',
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
                                'Manpower.task_id IS' => null,
                                'AND' =>
                                    [
                                        'Manpower.task_id IS NOT' => null,
                                        'Manpower.task_id = Tasks.id',
                                        'Tasks.end_date <' => $options['start_date'],                                
                                    ],
                                'AND' =>
                                    [
                                        'Manpower.task_id IS NOT' => null,
                                        'Manpower.task_id = Tasks.id',
                                        'Tasks.start_date <=' => $options['end_date']
                                    ]
                            ],
                        'AND' =>
                            [
                                'Manpower.project_id IS NOT' => null,
                            ]
                    ]),
                    1,
                    'integer'
                )
            );
        else:
            $available_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add(['Manpower.project_id IS NOT' => null, 'Manpower.task_id IS' => null]),
                    1,
                    'integer'
                )
            );

            $unavailable_quantity = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add(['Manpower.project_id IS NOT' => null, 'Manpower.task_id IS NOT' => null]),
                    1,
                    'integer'
                )
            );

            $total_quantity = $query->func()->count('Manpower.id');
        endif;            

        if(isset($options['id']))
            $query = $query->where(['ManpowerTypes.id' => $options['id']]);

        return $query->select(['ManpowerTypes.id', 'ManpowerTypes.title', 'last_modified' => 'Manpower.modified',
            'available_quantity' => $available_quantity,
            'unavailable_quantity' => $unavailable_quantity,
            'total_quantity' => $total_quantity])
            ->contain(['ManpowerTypes'])
            ->where(['Manpower.project_id' => $options['project_id']])
            ->group(['ManpowerTypes.id']);
    }
}
