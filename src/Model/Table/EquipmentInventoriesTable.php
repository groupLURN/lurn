<?php
namespace App\Model\Table;

use App\Model\Entity\EquipmentInventory;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipmentInventories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 * @property \Cake\ORM\Association\BelongsTo $Equipment
 */
class EquipmentInventoriesTable extends Table
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

        $this->table('equipment_inventories');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id'
        ]);
        $this->belongsTo('Equipment', [
            'foreignKey' => 'equipment_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));
        $rules->add($rules->existsIn(['equipment_id'], 'Equipment'));
        return $rules;
    }

    public function findByName(Query $query, array $options)
    {
        return $query->where(['name LIKE' => '%' . $options['name'] . '%']);
    }

    public function findGeneralInventorySummary(Query $query, array $options)
    {
        $available_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add(['EquipmentInventories.project_id IS' => null]),
                1,
                'integer'
            )
        );

        $unavailable_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add(['EquipmentInventories.project_id IS NOT' => null]),
                1,
                'integer'
            )
        );

        $total_quantity = $query->func()->count('EquipmentInventories.id');

        if(isset($options['id']))
            $query = $query->where(['Equipment.id' => $options['id']]);

        return $query->select(['Equipment.id', 'Equipment.name', 'last_modified' => 'EquipmentInventories.modified',
            'available_quantity' => $available_quantity,
            'unavailable_quantity' => $unavailable_quantity,
            'total_quantity' => $total_quantity])
            ->contain(['Equipment'])
            ->group('Equipment.id');
    }

    public function findProjectInventorySummary(Query $query, array $options)
    {
        $available_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add(['EquipmentInventories.project_id IS NOT' => null, 'EquipmentInventories.task_id IS' => null]),
                1,
                'integer'
            )
        );

        $unavailable_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add(['EquipmentInventories.project_id IS NOT' => null, 'EquipmentInventories.task_id IS NOT' => null]),
                1,
                'integer'
            )
        );

        $total_quantity = $query->func()->count('EquipmentInventories.id');

        if(isset($options['id']))
            $query = $query->where(['Equipment.id' => $options['id']]);

        return $query->select(['Equipment.id', 'Equipment.name', 'last_modified' => 'EquipmentInventories.modified',
            'available_quantity' => $available_quantity,
            'unavailable_quantity' => $unavailable_quantity,
            'total_quantity' => $total_quantity])
            ->contain(['Equipment'])
            ->where(['EquipmentInventories.project_id' => $options['project_id']])
            ->group(['Equipment.id']);
    }
}
