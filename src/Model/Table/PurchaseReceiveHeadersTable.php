<?php
namespace App\Model\Table;

use App\Model\Entity\PurchaseReceiveHeader;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseReceiveHeaders Model
 *
 * @property \Cake\ORM\Association\HasMany $PurchaseReceiveDetails
 */
class PurchaseReceiveHeadersTable extends Table
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

        $this->table('purchase_receive_headers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('PurchaseReceiveDetails', [
            'foreignKey' => 'purchase_receive_header_id'
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
            ->dateTime('received_date')
            ->requirePresence('received_date', 'create')
            ->notEmpty('received_date');

        return $validator;
    }

    public function findPurchaseReceives(Query $query, array $options)
    {
        return $query
            ->select($this)
            ->select($this->PurchaseReceiveDetails)
            ->select($this->PurchaseReceiveDetails->PurchaseOrderDetails)
            ->select($this->PurchaseReceiveDetails->PurchaseOrderDetails->PurchaseOrderHeaders)
            ->select($this->PurchaseReceiveDetails->PurchaseOrderDetails->PurchaseOrderHeaders->Projects)
            ->select($this->PurchaseReceiveDetails->PurchaseOrderDetails->PurchaseOrderHeaders->Suppliers)
            ->leftJoinWith('PurchaseReceiveDetails.PurchaseOrderDetails.PurchaseOrderHeaders.Projects')
            ->innerJoinWith('PurchaseReceiveDetails.PurchaseOrderDetails.PurchaseOrderHeaders.Suppliers')
            ->group('PurchaseReceiveHeaders.id');
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

    public function findByReceiveDateFrom(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->gte('PurchaseReceiveHeaders.created', $options['receive_date_from'], 'datetime'),
        ]);
    }

    public function findByReceiveDateTo(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->lt('PurchaseReceiveHeaders.created', $options['receive_date_to'], 'datetime')
        ]);
    }
}
