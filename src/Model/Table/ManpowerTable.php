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
 * @property \Cake\ORM\Association\BelongsTo $ManpowerTypes
 * @property \Cake\ORM\Association\BelongsTo $TaskInventory
 * @property \Cake\ORM\Association\BelongsToMany $Tasks
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
        $this->belongsTo('ManpowerTypes', [
            'foreignKey' => 'manpower_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TaskInventory', [
            'className' => 'Tasks',
            'foreignKey' => 'task_id'
        ]);
        $this->belongsToMany('Tasks', [
            'foreignKey' => 'manpower_id',
            'targetForeignKey' => 'task_id',
            'joinTable' => 'manpower_tasks'
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
            return $query->matching('TaskInventory', function($query) use ($options)
            {
                return $query->where(['TaskInventory.milestone_id' => $options['milestone_id']]);
            });
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
