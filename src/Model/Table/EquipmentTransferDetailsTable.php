<?php
namespace App\Model\Table;

use App\Model\Entity\EquipmentTransferDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipmentTransferDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ResourceTransferHeaders
 * @property \Cake\ORM\Association\BelongsTo $EquipmentInventories
 */
class EquipmentTransferDetailsTable extends Table
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

        $this->table('equipment_transfer_details');
        $this->displayField('resource_transfer_header_id');
        $this->primaryKey(['resource_transfer_header_id', 'equipment_inventory_id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('ResourceTransferHeaders', [
            'foreignKey' => 'resource_transfer_header_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('EquipmentInventories', [
            'foreignKey' => 'equipment_inventory_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['resource_transfer_header_id'], 'ResourceTransferHeaders'));
        $rules->add($rules->existsIn(['equipment_inventory_id'], 'EquipmentInventories'));
        return $rules;
    }
}
