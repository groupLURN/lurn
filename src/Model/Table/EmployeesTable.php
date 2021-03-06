<?php
namespace App\Model\Table;

use App\Model\Entity\Employee;
use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employees Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $EmployeeTypes
 * @property \Cake\ORM\Association\BelongsToMany $Projects
 */
class EmployeesTable extends Table
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

        $this->table('employees');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('EmployeeTypes', [
            'foreignKey' => 'employee_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Projects', [
            'foreignKey' => 'employee_id',
            'targetForeignKey' => 'project_id',
            'joinTable' => 'employees_projects'
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
            ->notEmpty('name');

        $validator
            ->dateTime('employment_date')
            ->requirePresence('employment_date', 'create')
            ->notEmpty('employment_date');

        $validator
            ->dateTime('termination_date')
            ->allowEmpty('termination_date');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['employee_type_id'], 'EmployeeTypes'));
        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        foreach (['employment_date', 'termination_date'] as $key) {
            if (isset($data[$key]) && is_string($data[$key])) {
                $data[$key] = Time::parseDateTime($data[$key], 'yyyy/MM/dd');
            }
        }
    }

    public function findByName(Query $query, array $options)
    {
        return $query->where(function($exp) use ($options){
            return $exp->like('name', '%' . $options['name'] . '%');
        });
    }

    public function findByUserId(Query $query, array $options)
    {
        if((int)$options['user_id'] > -1)
            return $query->where(['user_id' => $options['user_id']]);
        else
            return $query;
    }

    public function findByEmployeeTypeId(Query $query, array $options)
    {
        if((int)$options['employee_type_id'] > 0)
            return $query->where(['employee_type_id' => $options['employee_type_id']]);
        else
            return $query;
    }

    public function findByEmploymentDateFrom(Query $query, array $options)
    {
        return $query->where($query->newExpr()->gte('employment_date', $options['employment_date_from'], 'datetime'));
    }

    public function findByEmploymentDateTo(Query $query, array $options)
    {
        return $query->where($query->newExpr()->lt('employment_date', $options['employment_date_to'], 'datetime'));
    }

    public function findByTerminationDateFrom(Query $query, array $options)
    {
        return $query->where($query->newExpr()->gte('termination_date', $options['termination_date_from'], 'datetime'));
    }

    public function findByTerminationDateTo(Query $query, array $options)
    {
        return $query->where($query->newExpr()->lt('termination_date', $options['termination_date_to'], 'datetime'));
    }
}
