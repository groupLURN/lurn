<?php
namespace App\Model\Table;

use App\Model\Entity\PurchaseOrderHeader;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseOrderHeaders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Suppliers
 * @property \Cake\ORM\Association\HasMany $PurchaseOrderDetails
 */
class PurchaseOrderHeadersTable extends Table
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

        $this->table('purchase_order_headers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('PurchaseOrderDetails', [
            'foreignKey' => 'purchase_order_header_id'
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
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'));
        return $rules;
    }

    public function findByProjectId(Query $query, array $options)
    {
        if($options['project_id'] > 0)
            return $query->where(['PurchaseOrderHeaders.project_id' => $options['project_id']]);
        return $query;
    }

    public function findBySupplierId(Query $query, array $options)
    {
        if($options['supplier_id'] > 0)
            return $query->where(['PurchaseOrderHeaders.supplier_id' => $options['supplier_id']]);
        return $query;
    }

    public function findByOrderDateFrom(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->gte('PurchaseOrderHeaders.created', $options['order_date_from'], 'datetime'),
        ]);
    }

    public function findByOrderDateTo(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->lt('PurchaseOrderHeaders.created', $options['order_date_to'], 'datetime')
        ]);
    }
}
