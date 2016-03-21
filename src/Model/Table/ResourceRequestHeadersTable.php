<?php
namespace App\Model\Table;

use App\Model\Entity\ResourceRequestHeader;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResourceRequestHeaders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ProjectsFrom
 * @property \Cake\ORM\Association\BelongsTo $ProjectsTo
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
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProjectsFrom', [
            'className' => 'Projects',
            'foreignKey' => 'from_project_id'
        ]);
        $this->belongsTo('ProjectsTo', [
            'className' => 'Projects',
            'foreignKey' => 'to_project_id'
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
        $rules->add($rules->existsIn(['from_project_id'], 'Projects'));
        $rules->add($rules->existsIn(['to_project_id'], 'Projects'));
        return $rules;
    }
}
