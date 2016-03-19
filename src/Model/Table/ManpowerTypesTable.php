<?php
namespace App\Model\Table;

use App\Model\Entity\ManpowerType;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * ManpowerTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $Manpower
 * @property \Cake\ORM\Association\HasMany $ManpowerGeneralInventories
 *
 */
class ManpowerTypesTable extends Table
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

        $this->table('manpower_types');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Manpower', [
            'foreignKey' => 'manpower_type_id'
        ]);

        $this->hasMany('ManpowerGeneralInventories', [
            'className' => 'Manpower',
            'foreignKey' => 'manpower_type_id',
            'conditions' => ['ManpowerGeneralInventories.project_id IS' => null]
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
            ->notEmpty('title')
            ->add('title', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['title']));
        return $rules;
    }

    public function findById(Query $query, array $options)
    {
        if((int)$options['id'] > 0)
            return $query->where(['ManpowerTypes.id' => $options['id']]);
        else
            return $query;
    }

    public function findByProjectId(Query $query, array $options)
    {
        if($options['project_id'] > 0)
            return $query->where(['Projects.id' => $options['project_id']]);
        return $query;
    }

    public function findByScheduleDateFrom(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->gte('Tasks.start_date', $options['schedule_date_from'], 'datetime'),
        ]);
    }

    public function findByScheduleDateTo(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->lt('Tasks.end_date', $options['schedule_date_to'], 'datetime')
        ]);
    }

    public function findManpowerTypesSchedule(Query $query, array $options)
    {
        return $query
            ->hydrate(false)
            ->select(TableRegistry::get('ManpowerTypes'))
            ->select(TableRegistry::get('Tasks'))
            ->select(TableRegistry::get('ManpowerTypesTasks'))
            ->select(TableRegistry::get('Projects'))
            ->select(TableRegistry::get('Milestones'))
            ->select(['quantity_available' => $query->func()->count('ManpowerGeneralInventories.id')])
            ->innerJoin(['ManpowerTypesTasks' => 'manpower_types_tasks'], ['ManpowerTypesTasks.manpower_type_id = ManpowerTypes.id'])
            ->innerJoin(['Tasks' => 'tasks'], ['Tasks.id = ManpowerTypesTasks.task_id'])
            ->leftJoin(['Milestones' => 'milestones'], ['Milestones.id = Tasks.milestone_id'])
            ->leftJoin(['Projects' => 'projects'], ['Projects.id = Milestones.project_id'])
            ->leftJoinWith('ManpowerGeneralInventories')
            ->group(['ManpowerTypesTasks.manpower_type_id', 'ManpowerTypesTasks.task_id']);
    }
}
