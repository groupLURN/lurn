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
            'foreignKey' => 'milestone_id'
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
        return $query
            ->contain('Tasks')
            ->where(['Milestones.project_id' => $options['project_id']]);
    }

    public function findByTitle(Query $query, array $options)
    {
        return $query
            ->matching('Tasks')
            ->where(function($exp) use ($options){
                return $exp->like('Tasks.title', '%' . $options['title'] . '%');
            }
        );
    }

    public function findByStatus(Query $query, array $options)
    {
        $now = (new DateTime())->format('Y-m-d H:i:s');

        switch((int)$options['status'])
        {
            case $this->Tasks->status['Pending']:
                return $query->where(['Tasks.is_finished' => 0, 'Tasks.start_date >' => $now]);
            case $this->Tasks->status['In Progress']:
                return $query->where(['Tasks.is_finished' => 0, 'Tasks.start_date <=' => $now, 'Tasks.end_date >=' => $now]);
            case $this->Tasks->status['Done']:
                return $query->where(['Tasks.is_finished' => 1]);
            case $this->Tasks->status['Overdue']:
                return $query->where(['Tasks.is_finished' => 0, 'Tasks.end_date <' => $now]);
            default:
                return $query;
        }
    }
}
