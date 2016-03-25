<?php
namespace App\Model\Table;

use App\Model\Entity\Project;
use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Projects Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clients
 * @property \Cake\ORM\Association\BelongsTo $Employees
 * @property \Cake\ORM\Association\BelongsTo $ProjectStatuses
 * @property \Cake\ORM\Association\HasMany $EquipmentProjectInventories
 * @property \Cake\ORM\Association\HasMany $EquipmentTaskInventories
 * @property \Cake\ORM\Association\HasMany $Manpower
 * @property \Cake\ORM\Association\HasMany $MaterialsProjectInventories
 * @property \Cake\ORM\Association\HasMany $MaterialsTaskInventories
 * @property \Cake\ORM\Association\HasMany $Milestones
 * @property \Cake\ORM\Association\BelongsToMany $EmployeesJoin
 */
class ProjectsTable extends Table
{

    const STATUS_PLANNING_PHASE = 'Planning Phase';
    const STATUS_ON_GOING = 'Ongoing';
    const STATUS_DELAYED = 'Delayed';
    const STATUS_COMPLETED = 'Completed';
    const STATUS_CLOSED = 'Closed';

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
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Employees', [
            'foreignKey' => 'project_manager_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('ProjectStatuses', [
            'foreignKey' => 'project_status_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('EquipmentProjectInventories', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('EquipmentTaskInventories', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('Manpower', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('MaterialsProjectInventories', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('MaterialsTaskInventories', [
            'foreignKey' => 'project_id'
        ]);
        $this->hasMany('Milestones', [
            'foreignKey' => 'project_id'
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

    public function getProjectStatusList()
    {
        return
            [
                self::STATUS_PLANNING_PHASE => self::STATUS_PLANNING_PHASE,
                self::STATUS_ON_GOING => self::STATUS_ON_GOING,
                self::STATUS_DELAYED => self::STATUS_DELAYED,
                self::STATUS_COMPLETED => self::STATUS_COMPLETED,
                self::STATUS_CLOSED => self::STATUS_CLOSED
            ];
    }

    public function findByTitle(Query $query, array $options)
    {
        return $query->where($query->newExpr()->like('Projects.title', '%' . $options['title'] . '%'));
    }

    public function findByProjectStatusId(Query $query, array $options)
    {
        if($options['project_status_id'] !== "0")
            return $query->having(['status' => $options['project_status_id']]);
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

    public function findProjectStatus(Query $query, array $options)
    {
        $projectStatus = $query->newExpr()->add([sprintf("
        IF(
		    CURDATE() < Projects.`start_date`,
		    '%s',
		    IF(
			    SUM(IF(Tasks.`is_finished` =  1, 1, 0)) = COUNT(Tasks.`id`) AND
			    CURDATE() > DATE_ADD(Projects.`end_date`, INTERVAL 1 YEAR),
			    '%s',
                IF(
                    SUM(IF(Tasks.`is_finished` =  1, 1, 0)) = COUNT(Tasks.`id`),
                    '%s',
                        IF(
                            SUM(IF(Tasks.`is_finished` =  0 AND CURDATE() > Tasks.`end_date`, 1, 0)) > 0,
                            '%s',
                            '%s'
                        )
                )
            )
	    )", self::STATUS_PLANNING_PHASE, self::STATUS_CLOSED, self::STATUS_COMPLETED, self::STATUS_DELAYED, self::STATUS_ON_GOING
        )]);


        return $query
            ->select(['status' => $projectStatus])
            ->select($this)
            ->leftJoinWith('Milestones.Tasks')
            ->group('Projects.id');
    }

    public function findByAuthorization(Query $query, array $options)
    {
        $resultSet = TableRegistry::get('employees')->find()
            ->select(['id' => 'Employees.user_id'])
            ->matching('EmployeeTypes', function($query){
                return $query->where(['EmployeeTypes.title' => 'Project Manager/Project Supervisor']);
            });

        $projectManagerUserIds = [];
        foreach($resultSet as $entity)
            $projectManagerUserIds[] = $entity->id;

        if(in_array($options['user_id'], $projectManagerUserIds))
            return $query;
        else
            return $query
                ->matching('EmployeesJoin', function($query) use ($options) {
                    return $query->where(['EmployeesJoin.user_id' => $options['user_id']]);
                });
    }

    public function computeProjectStatus($project)
    {
        $query = $this->find()->where(['Projects.id' => $project->id]);
        $query = $this->findProjectStatus($query, []);
        $project->status = $query->first()->status;
    }
}
