<?php
namespace App\Model\Table;

use App\Model\Entity\PurchaseOrderDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseOrderDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $PurchaseOrderHeaders
 * @property \Cake\ORM\Association\BelongsTo $Materials
 * @property \Cake\ORM\Association\HasMany $PurchaseReceiveDetails
 */
class PurchaseOrderDetailsTable extends Table
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

        $this->table('purchase_order_details');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PurchaseOrderHeaders', [
            'foreignKey' => 'purchase_order_header_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Materials', [
            'foreignKey' => 'material_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('PurchaseReceiveDetails', [
            'foreignKey' => 'purchase_order_detail_id'
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
        $rules->add($rules->existsIn(['purchase_order_header_id'], 'PurchaseOrderHeaders'));
        $rules->add($rules->existsIn(['material_id'], 'Materials'));
        return $rules;
    }
}
