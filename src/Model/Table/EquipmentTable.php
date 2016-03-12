<?php
namespace App\Model\Table;

use App\Model\Entity\Equipment;
use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Equipment Model
 *
 * @property \Cake\ORM\Association\HasMany $EquipmentGeneralInventories
 * @property \Cake\ORM\Association\HasMany $EquipmentInventories
 * @property \Cake\ORM\Association\HasMany $EquipmentProjectInventories
 * @property \Cake\ORM\Association\HasMany $EquipmentTaskInventories
 * @property \Cake\ORM\Association\BelongsToMany $Tasks
 */
class EquipmentTable extends Table
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

        $this->table('equipment');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('EquipmentGeneralInventories', [
            'foreignKey' => 'equipment_id'
        ]);
        $this->hasMany('EquipmentInventories', [
            'foreignKey' => 'equipment_id'
        ]);
        $this->hasMany('EquipmentProjectInventories', [
            'foreignKey' => 'equipment_id'
        ]);
        $this->hasMany('EquipmentTaskInventories', [
            'foreignKey' => 'equipment_id'
        ]);
        $this->belongsToMany('Tasks', [
            'foreignKey' => 'equipment_id',
            'targetForeignKey' => 'task_id',
            'joinTable' => 'equipment_tasks'
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

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        foreach (['created', 'modified'] as $key) {
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
}
