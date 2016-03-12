<?php
namespace App\Model\Table;

use App\Model\Entity\RentalReceiveDetail;
use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RentalReceiveDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $RentalReceiveHeaders
 * @property \Cake\ORM\Association\BelongsTo $RentalRequestDetails
 * @property \Cake\ORM\Association\HasMany $EquipmentInventories
 */
class RentalReceiveDetailsTable extends Table
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

        $this->table('rental_receive_details');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('RentalReceiveHeaders', [
            'foreignKey' => 'rental_receive_header_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RentalRequestDetails', [
            'foreignKey' => 'rental_request_detail_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('EquipmentInventories', [
            'foreignKey' => 'rental_receive_detail_id'
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
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->dateTime('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');

        $validator
            ->dateTime('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');

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
        $rules->add($rules->existsIn(['rental_receive_header_id'], 'RentalReceiveHeaders'));
        $rules->add($rules->existsIn(['rental_request_detail_id'], 'RentalRequestDetails'));
        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        foreach (['start_date', 'end_date'] as $key) {
            if (isset($data[$key]) && is_string($data[$key])) {
                $data[$key] = Time::parseDateTime($data[$key], 'yyyy/MM/dd');
            }
        }
    }
}
