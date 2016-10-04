<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipmentSuppliers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Equipment
 * @property \Cake\ORM\Association\BelongsTo $Suppliers
 *
 * @method \App\Model\Entity\EquipmentSupplier get($primaryKey, $options = [])
 * @method \App\Model\Entity\EquipmentSupplier newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EquipmentSupplier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EquipmentSupplier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipmentSupplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EquipmentSupplier[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EquipmentSupplier findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EquipmentSuppliersTable extends Table
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

        $this->table('equipment_suppliers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Equipment', [
            'foreignKey' => 'equipment_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
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
        $rules->add($rules->existsIn(['equipment_id'], 'Equipment'));
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'));

        return $rules;
    }
}
