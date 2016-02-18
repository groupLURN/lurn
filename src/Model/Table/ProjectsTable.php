<?php
namespace App\Model\Table;

use App\Model\Entity\Project;
use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projects Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clients
 * @property \Cake\ORM\Association\BelongsTo $Employees
 * @property \Cake\ORM\Association\BelongsTo $ProjectStatuses
 * @property \Cake\ORM\Association\BelongsToMany $EmployeesJoin
 */
class ProjectsTable extends Table
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

        $this->table('projects');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Employees', [
            'foreignKey' => 'project_manager_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProjectStatuses', [
            'foreignKey' => 'project_status_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('EmployeesJoin', [
            'className' => 'Employees',
            'foreignKey' => 'project_id',
            'targetForeignKey' => 'employee_id',
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->dateTime('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');

        $validator
            ->dateTime('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');

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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['project_manager_id'], 'Employees'));
        $rules->add($rules->existsIn(['project_status_id'], 'ProjectStatuses'));
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

    public function findByTitle(Query $query, array $options)
    {
        return $query->where($query->newExpr()->like('Projects.title', '%' . $options['title'] . '%'));
    }

    public function findByProjectStatusId(Query $query, array $options)
    {
        if((int)$options['project_status_id'] > 0)
            return $query->where(['Projects.project_status_id' => $options['project_status_id']]);
        else
            return $query;
    }

    public function findByStartDateFrom(Query $query, array $options)
    {
        return $query->where($query->newExpr()->gte('Projects.start_date', $options['start_date_from'], 'datetime'));
    }

    public function findByStartDateTo(Query $query, array $options)
    {
        return $query->where($query->newExpr()->lt('Projects.start_date', $options['start_date_to'], 'datetime'));
    }

    public function findByEndDateFrom(Query $query, array $options)
    {
        return $query->where($query->newExpr()->gte('Projects.end_date', $options['end_date_from'], 'datetime'));
    }

    public function findByEndDateTo(Query $query, array $options)
    {
        return $query->where($query->newExpr()->lt('Projects.end_date', $options['end_date_to'], 'datetime'));
    }

}
