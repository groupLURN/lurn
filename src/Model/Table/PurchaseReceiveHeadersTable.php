<?php
namespace App\Model\Table;

use App\Model\Entity\PurchaseReceiveHeader;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
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

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        foreach (['received_date'] as $key) {
            if (isset($data[$key]) && is_string($data[$key])) {
                $data[$key] = Time::parseDateTime($data[$key], 'yyyy/MM/dd');
            }
        }
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $purchaseReceiveHeader = $this->get($entity->id, [
            'contain' => ['PurchaseReceiveDetails.PurchaseOrderDetails.Materials']
        ]);

        foreach($purchaseReceiveHeader->purchase_receive_details as $purchaseReceiveDetail)
        {
            try
            {
                $materialGeneralInventory = TableRegistry::get('MaterialsGeneralInventories')
                    ->get($purchaseReceiveDetail->purchase_order_detail->material_id);

                $materialGeneralInventory->quantity += $purchaseReceiveDetail->quantity;
            }
            catch(RecordNotFoundException $e)
            {
                $materialGeneralInventory = TableRegistry::get('MaterialsGeneralInventories')->newEntity([
                    'material_id' => $purchaseReceiveDetail->purchase_order_detail->material_id,
                    'quantity' => $purchaseReceiveDetail->quantity
                ]);
            }
            finally
            {
                TableRegistry::get('MaterialsGeneralInventories')->save($materialGeneralInventory);
            }
        }
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
    public function findById(Query $query, array $options)
    {
        if($options['id'] > 0)
            return $query
                ->where(['id' => $options['id']])
                ->contain(['PurchaseReceiveDetails.PurchaseOrderDetails.PurchaseOrderHeaders' => 
                    ['Projects', 'Suppliers']
                ]);
        return $query;
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
