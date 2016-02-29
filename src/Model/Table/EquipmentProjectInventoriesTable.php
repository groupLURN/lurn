<?php
namespace App\Model\Table;

use App\Model\Entity\EquipmentProjectInventory;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipmentProjectInventories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Equipment
 * @property \Cake\ORM\Association\BelongsTo $Projects
 */
class EquipmentProjectInventoriesTable extends Table
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

        $this->table('equipment_project_inventories');
        $this->displayField('equipment_id');
        $this->primaryKey(['equipment_id', 'project_id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Equipment', [
            'foreignKey' => 'equipment_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
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
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

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
        $rules->add($rules->existsIn(['equipment_id'], 'Equipment'));
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        return $rules;
    }
}
