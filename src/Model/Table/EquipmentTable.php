<?php
namespace App\Model\Table;

use App\Model\Entity\Equipment;
use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Equipment Model
 *
 * @property \Cake\ORM\Association\HasMany $EquipmentGeneralInventories
 * @property \Cake\ORM\Association\HasMany $EquipmentInventories
 * @property \Cake\ORM\Association\HasMany $InHouseEquipmentInventories
 * @property \Cake\ORM\Association\HasMany $RentedEquipmentInventories
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
            'className' => 'EquipmentInventories',
            'foreignKey' => 'equipment_id',
            'conditions' => ['EquipmentGeneralInventories.project_id IS' => null]
        ]);

        $this->hasMany('EquipmentInventories', [
            'foreignKey' => 'equipment_id'
        ]);

        $this->hasMany('InHouseEquipmentInventories', [
            'className' => 'EquipmentInventories',
            'foreignKey' => 'equipment_id',
            'conditions' => ['InHouseEquipmentInventories.rental_receive_detail_id IS' => null]
        ]);

        $this->hasMany('RentedEquipmentInventories', [
            'className' => 'EquipmentInventories',
            'foreignKey' => 'equipment_id',
            'conditions' => ['RentedEquipmentInventories.rental_receive_detail_id IS NOT' => null]
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

    public function adjustInHouseInventory(Equipment $equipment, $quantity)
    {
        return $this->connection()->transactional(function() use ($equipment, $quantity)
        {
            $this->EquipmentInventories->deleteAll([
                'rental_receive_detail_id IS' => null,
                'equipment_id' => $equipment->id
            ]);

            $datum = [
                'equipment_id' => $equipment->id
            ];

            $data = array_fill(0, $quantity, $datum);
            $equipmentInventories = $this->EquipmentInventories->newEntities($data);

            foreach($equipmentInventories as $equipmentInventory)
                $this->EquipmentInventories->save($equipmentInventory, ['atomic' => false]);
            return true;
        });
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

    public function findEquipmentSchedule(Query $query, array $options)
    {
        return $query
            ->hydrate(false)
            ->select(TableRegistry::get('Equipment'))
            ->select(TableRegistry::get('Tasks'))
            ->select(TableRegistry::get('EquipmentTasks'))
            ->select(TableRegistry::get('Projects'))
            ->select(TableRegistry::get('Milestones'))
            ->select(['quantity_available' => $query->func()->count('EquipmentGeneralInventories.id')])
            ->innerJoin(['EquipmentTasks' => 'equipment_tasks'], ['EquipmentTasks.equipment_id = Equipment.id'])
            ->innerJoin(['Tasks' => 'tasks'], ['Tasks.id = EquipmentTasks.task_id'])
            ->leftJoin(['Milestones' => 'milestones'], ['Milestones.id = Tasks.milestone_id'])
            ->leftJoin(['Projects' => 'projects'], ['Projects.id = Milestones.project_id'])
            ->leftJoinWith('EquipmentGeneralInventories')
            ->group(['EquipmentTasks.equipment_id', 'EquipmentTasks.task_id']);
    }
}
