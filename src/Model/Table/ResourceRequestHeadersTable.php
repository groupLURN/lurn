<?php
namespace App\Model\Table;

use App\Model\Entity\ResourceRequestHeader;
use ArrayObject;
use Cake\Collection\Collection;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResourceRequestHeaders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ProjectFrom
 * @property \Cake\ORM\Association\BelongsTo $ProjectTo
 * @property \Cake\ORM\Association\BelongsToMany $Equipment
 * @property \Cake\ORM\Association\BelongsToMany $ManpowerTypes
 * @property \Cake\ORM\Association\BelongsToMany $Materials
 * @property \Cake\ORM\Association\HasMany $EquipmentRequestDetails
 * @property \Cake\ORM\Association\HasMany $ManpowerRequestDetails
 * @property \Cake\ORM\Association\HasMany $MaterialRequestDetails
 * @property \Cake\ORM\Association\HasMany $ResourceTransferHeaders
 */
class ResourceRequestHeadersTable extends Table
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

        $this->table('resource_request_headers');
        $this->displayField('number');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProjectFrom', [
            'className' => 'Projects',
            'foreignKey' => 'from_project_id'
        ]);
        $this->belongsTo('ProjectTo', [
            'className' => 'Projects',
            'foreignKey' => 'to_project_id'
        ]);
        $this->belongsToMany('Equipment', [
            'foreignKey' => 'resource_request_header_id',
            'targetForeignKey' => 'equipment_id',
            'joinTable' => 'equipment_request_details'
        ]);
        $this->belongsToMany('ManpowerTypes', [
            'foreignKey' => 'resource_request_header_id',
            'targetForeignKey' => 'manpower_type_id',
            'joinTable' => 'manpower_request_details'
        ]);
        $this->belongsToMany('Materials', [
            'foreignKey' => 'resource_request_header_id',
            'targetForeignKey' => 'material_id',
            'joinTable' => 'material_request_details'
        ]);
        $this->hasMany('EquipmentRequestDetails', [
            'foreignKey' => 'resource_request_header_id'
        ]);
        $this->hasMany('ManpowerRequestDetails', [
            'foreignKey' => 'resource_request_header_id'
        ]);
        $this->hasMany('MaterialRequestDetails', [
            'foreignKey' => 'resource_request_header_id'
        ]);
        $this->hasMany('ResourceTransferHeaders', [
            'foreignKey' => 'resource_request_header_id'
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
            ->dateTime('required_date')
            ->requirePresence('required_date', 'create')
            ->notEmpty('required_date');

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
        $rules->add($rules->existsIn(['from_project_id'], 'ProjectFrom'));
        $rules->add($rules->existsIn(['to_project_id'], 'ProjectTo'));
        return $rules;
    }

    public function findByProjectId(Query $query, array $options)
    {
        if($options['project_id'] > 0)
            return $query->where(['ResourceRequestHeaders.from_project_id' => $options['project_id']]);
        return $query;
    }

    public function findByRequestDateFrom(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->gte('ResourceRequestHeaders.created', $options['request_date_from'], 'datetime'),
        ]);
    }

    public function findByRequestDateTo(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->lt('ResourceRequestHeaders.created', $options['request_date_to'], 'datetime')
        ]);
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        foreach (['required_date'] as $key) {
            if (isset($data[$key]) && is_string($data[$key])) {
                $data[$key] = Time::parseDateTime($data[$key], 'yyyy/MM/dd');
            }
        }
    }

    public function computeQuantityRemaining($resourceRequestHeader)
    {
        // First, build a hash map for easier access on the total quantity transferred per equipment, manpower_type and
        // material.
        $equipmentTransferredHash = [];
        $manpowerTypeTransferredHash = [];
        $materialTransferredHash = [];

        foreach($resourceRequestHeader->resource_transfer_headers as $resourceTransferHeader)
        {
            foreach($resourceTransferHeader->equipment_transfer_details as $equipmentTransferDetail)
            {
                $ref = &$equipmentTransferredHash[$equipmentTransferDetail->equipment_inventory->equipment_id];
                $ref = isset($ref)? $ref['quantity_transferred'] + 1: 1;
            }
            foreach($resourceTransferHeader->manpower_transfer_details as $manpowerTransferDetail)
            {
                $ref = &$manpowerTypeTransferredHash[$manpowerTransferDetail->manpower->manpower_type_id];
                $ref = isset($ref)? $ref['quantity_transferred'] + 1: 1;
            }
            foreach($resourceTransferHeader->material_transfer_details as $materialTransferDetail)
            {
                $ref = &$materialTransferredHash[$materialTransferDetail->material_id];
                $ref = isset($ref)? $ref['quantity_transferred'] + $materialTransferDetail->quantity: $materialTransferDetail->quantity;
            }
        }

        // Should be all quantity_remaining === 0 to be NoRemaining.
        $noRemaining = true;

        foreach($resourceRequestHeader->equipment_request_details as &$equipmentRequestDetail)
            if(isset($equipmentTransferredHash[$equipmentRequestDetail->equipment_id]))
            {
                $equipmentRequestDetail->quantity_remaining = $equipmentRequestDetail->quantity -
                    $equipmentTransferredHash[$equipmentRequestDetail->equipment_id];
                $noRemaining = $noRemaining && $equipmentRequestDetail->quantity_remaining === 0;
            }
            else
                $noRemaining = false;

        foreach($resourceRequestHeader->manpower_request_details as &$manpowerRequestDetail)
            if(isset($manpowerTypeTransferredHash[$manpowerRequestDetail->manpower_id]))
            {
                $manpowerRequestDetail->quantity_remaining = $manpowerRequestDetail->quantity -
                    $manpowerTypeTransferredHash[$manpowerRequestDetail->manpower_id];
                $noRemaining = $noRemaining && $manpowerRequestDetail->quantity_remaining === 0;
            }
            else
                $noRemaining = false;

        foreach($resourceRequestHeader->material_request_details as &$materialRequestDetail)
            if(isset($materialTransferredHash[$materialRequestDetail->material_id]))
            {
                $materialRequestDetail->quantity_remaining = $materialRequestDetail->quantity -
                    $materialTransferredHash[$materialRequestDetail->material_id];
                $noRemaining = $noRemaining && $materialRequestDetail->quantity_remaining === 0;
            }
            else
                $noRemaining = false;

        $resourceRequestHeader->all_quantity_transferred = $noRemaining;

        return $this;
    }
}
