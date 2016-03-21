<?php
namespace App\Model\Table;

use App\Model\Entity\ResourceRequestHeader;
use ArrayObject;
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
}
