<?php
namespace App\Model\Table;

use App\Model\Entity\ResourceTransferHeader;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResourceTransferHeaders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ResourceRequestHeaders
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\HasMany $EquipmentTransferDetails
 * @property \Cake\ORM\Association\HasMany $ManpowerTransferDetails
 * @property \Cake\ORM\Association\HasMany $MaterialTransferDetails
 */
class ResourceTransferHeadersTable extends Table
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

        $this->table('resource_transfer_headers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ResourceRequestHeaders', [
            'foreignKey' => 'resource_request_header_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'from_project_id'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'to_project_id'
        ]);
        $this->hasMany('EquipmentTransferDetails', [
            'foreignKey' => 'resource_transfer_header_id'
        ]);
        $this->hasMany('ManpowerTransferDetails', [
            'foreignKey' => 'resource_transfer_header_id'
        ]);
        $this->hasMany('MaterialTransferDetails', [
            'foreignKey' => 'resource_transfer_header_id'
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
        $rules->add($rules->existsIn(['resource_request_header_id'], 'ResourceRequestHeaders'));
        $rules->add($rules->existsIn(['from_project_id'], 'Projects'));
        $rules->add($rules->existsIn(['to_project_id'], 'Projects'));
        return $rules;
    }
}
