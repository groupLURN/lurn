<?php
namespace App\Model\Table;

use App\Model\Entity\Task;
use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tasks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Milestones
 * @property \Cake\ORM\Association\HasMany $EquipmentInventories
 * @property \Cake\ORM\Association\HasMany $Manpower
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

        $this->belongsTo('Milestones', [
            'foreignKey' => 'milestone_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('EquipmentInventories', [
            'foreignKey' => 'task_id'
        ]);
        $this->hasMany('Manpower', [
            'foreignKey' => 'task_id'
        ]);
        $this->hasMany('MaterialsTaskInventories', [
            'foreignKey' => 'task_id'
        ]);
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
}
