<?php
namespace App\Model\Table;

use App\Model\Entity\RentalRequestHeader;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RentalRequestHeaders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Suppliers
 * @property \Cake\ORM\Association\HasMany $RentalReceiveHeaders
 * @property \Cake\ORM\Association\HasMany $RentalRequestDetails
 */
class RentalRequestHeadersTable extends Table
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

        $this->table('rental_request_headers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('RentalReceiveHeaders', [
            'foreignKey' => 'rental_request_header_id'
        ]);
        $this->hasMany('RentalRequestDetails', [
            'foreignKey' => 'rental_request_header_id'
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
            return $query->where(['RentalRequestHeaders.project_id' => $options['project_id']]);
        return $query;
    }

    public function findBySupplierId(Query $query, array $options)
    {
        if($options['supplier_id'] > 0)
            return $query->where(['RentalRequestHeaders.supplier_id' => $options['supplier_id']]);
        return $query;
    }

    public function findByRequestDateFrom(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->gte('RentalRequestHeaders.created', $options['request_date_from'], 'datetime'),
        ]);
    }

    public function findByRequestDateTo(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->lt('RentalRequestHeaders.created', $options['request_date_to'], 'datetime')
        ]);
    }
}
