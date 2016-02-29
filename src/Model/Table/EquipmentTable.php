<?php
namespace App\Model\Table;

use App\Model\Entity\Equipment;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Equipment Model
 *
 * @property \Cake\ORM\Association\HasMany $EquipmentGeneralInventories
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

    public function findByName(Query $query, array $options)
    {
        return $query->where(function($exp) use ($options){
            return $exp->like('name', '%' . $options['name'] . '%');
        });
    }

    public function findGeneralInventorySummary(Query $query, array $options)
    {
        $available_quantity = $query->func()->coalesce(['EquipmentGeneralInventories.quantity' => 'literal', 0]);

        $unavailable_quantity = $query->newExpr()->add([
            'SUM(COALESCE(EquipmentProjectInventories.quantity, 0)) + SUM(COALESCE(EquipmentTaskInventories.quantity, 0))'
        ]);

        if(isset($options['id']))
            $query = $query->where(['Equipment.id' => $options['id']]);

        return $query->select(['Equipment.id', 'Equipment.name', 'last_modified' => 'EquipmentGeneralInventories.modified', 'available_quantity' => $available_quantity,
            'unavailable_quantity' => $unavailable_quantity])
            ->leftJoin(['EquipmentGeneralInventories' => 'equipment_general_inventories'], [
                'EquipmentGeneralInventories.equipment_id = Equipment.id'
            ])
            ->leftJoin(['EquipmentProjectInventories' => 'equipment_project_inventories'], [
                'EquipmentProjectInventories.equipment_id = Equipment.id'
            ])
            ->leftJoin(['EquipmentTaskInventories' => 'equipment_task_inventories'], [
                'EquipmentTaskInventories.equipment_id = Equipment.id'
            ]);
    }
}
