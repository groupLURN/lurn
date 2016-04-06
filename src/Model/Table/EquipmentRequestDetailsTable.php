<?php
namespace App\Model\Table;

use App\Model\Entity\EquipmentRequestDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipmentRequestDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ResourceRequestHeaders
 * @property \Cake\ORM\Association\BelongsTo $Equipment
 */
class EquipmentRequestDetailsTable extends Table
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

        $this->table('equipment_request_details');
        $this->displayField('resource_request_header_id');
        $this->primaryKey(['resource_request_header_id', 'equipment_id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('ResourceRequestHeaders', [
            'foreignKey' => 'resource_request_header_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['resource_request_header_id'], 'ResourceRequestHeaders'));
        $rules->add($rules->existsIn(['equipment_id'], 'Equipment'));
        return $rules;
    }
}
