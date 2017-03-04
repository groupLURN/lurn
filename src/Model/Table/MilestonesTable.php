<?php
namespace App\Model\Table;

use App\Model\Entity\Milestone;
use Cake\Chronos\Date;
use DateTime;
use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Milestones Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\HasMany $Tasks
 */
class MilestonesTable extends Table
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

        $this->table('milestones');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'milestone_id',
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
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
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

    public function findByProjectId(Query $query, array $options)
    {
        if(-1 < (int)$options['project_id']) {
            return $query->where(['Milestones.project_id' => $options['project_id']]);
        } else {
            return $query;
        }
    }

    public function findByTitle(Query $query, array $options)
    {
        $expression = $query->newExpr()->like('Tasks.title', '%' . $options['title'] . '%');

        return $query
            ->contain(['Tasks' => function ($query) use ($expression){
                return $query->where($expression);
            }])
            ->matching('Tasks')->where($expression)
            ->group('Milestones.id');
    }

    public function findByStatus(Query $query, array $options)
    {
        $now = (new DateTime())->format('Y-m-d H:i:s');
        $conditions = [];

        switch((int)$options['status'])
        {
            case $this->Tasks->status['Pending']:
                $conditions = ['Tasks.is_finished' => 0, 'Tasks.start_date >' => $now];
                break;
            case $this->Tasks->status['In Progress']:
                $conditions = ['Tasks.is_finished' => 0, 'Tasks.start_date <=' => $now, 'Tasks.end_date >=' => $now];
                break;
            case $this->Tasks->status['Done']:
                $conditions = ['Tasks.is_finished' => 1];
                break;
            case $this->Tasks->status['Overdue']:
                $conditions = ['Tasks.is_finished' => 0, 'Tasks.end_date <' => $now];
                break;
            default:
                return $query;
        }

        return $query
            ->contain(['Tasks' => function ($query) use ($conditions){
                return $query->where($conditions);
            }])
            ->matching('Tasks')->where($conditions)
            ->group('Milestones.id');
    }
}
