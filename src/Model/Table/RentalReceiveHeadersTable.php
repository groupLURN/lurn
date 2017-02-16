<?php
namespace App\Model\Table;

use App\Model\Entity\RentalReceiveHeader;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RentalReceiveHeaders Model
 *
 * @property \Cake\ORM\Association\HasMany $RentalReceiveDetails
 */
class RentalReceiveHeadersTable extends Table
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

        $this->table('rental_receive_headers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('RentalReceiveDetails', [
            'foreignKey' => 'rental_receive_header_id'
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
            ->dateTime('receive_date')
            ->requirePresence('receive_date', 'create')
            ->notEmpty('receive_date');

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        foreach (['receive_date'] as $key) {
            if (isset($data[$key]) && is_string($data[$key])) {
                $data[$key] = Time::parseDateTime($data[$key], 'yyyy/MM/dd');
            }
        }
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $rentalReceiveHeader = $this->get($entity->id, [
            'contain' => ['RentalReceiveDetails.RentalRequestDetails.Equipment']
        ]);

        foreach($rentalReceiveHeader->rental_receive_details as $rentalReceiveDetail)
        {
            $datum = [
                'equipment_id' => $rentalReceiveDetail->rental_request_detail->equipment->id,
                'rental_receive_detail_id' => $rentalReceiveDetail->id
            ];

            $data = array_fill(0, $rentalReceiveDetail->quantity, $datum);

            $equipmentInventories = $this->RentalReceiveDetails->EquipmentInventories->newEntities($data);

            foreach($equipmentInventories as $equipmentInventory)
                $this->RentalReceiveDetails->EquipmentInventories->save($equipmentInventory);
        }
    }

    public function findRentalReceives(Query $query, array $options)
    {
        return $query
            ->select($this)
            ->select($this->RentalReceiveDetails)
            ->select($this->RentalReceiveDetails->RentalRequestDetails)
            ->select($this->RentalReceiveDetails->RentalRequestDetails->RentalRequestHeaders)
            ->select($this->RentalReceiveDetails->RentalRequestDetails->RentalRequestHeaders->Projects)
            ->select($this->RentalReceiveDetails->RentalRequestDetails->RentalRequestHeaders->Suppliers)
            ->leftJoinWith('RentalReceiveDetails.RentalRequestDetails.RentalRequestHeaders.Projects')
            ->innerJoinWith('RentalReceiveDetails.RentalRequestDetails.RentalRequestHeaders.Suppliers')
            ->group('RentalReceiveHeaders.id');
    }
    
    public function findById(Query $query, array $options)
    {
        if($options['id'] > 0)
            return $query
                ->where(['id' => $options['id']])
                ->contain([
                    'RentalReceiveDetails.RentalRequestDetails.RentalRequestHeaders' => [
                        'Projects', 'Suppliers'
                    ], 
                    'RentalReceiveDetails.RentalRequestDetails.Equipment']);
        return $query;
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

    public function findByReceiveDateFrom(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->gte('RentalReceiveHeaders.created', $options['receive_date_from'], 'datetime'),
        ]);
    }

    public function findByReceiveDateTo(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->lt('RentalReceiveHeaders.created', $options['receive_date_to'], 'datetime')
        ]);
    }
}
