<?php
namespace App\Model\Table;

use App\Model\Entity\RentalReceiveHeader;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RentalReceiveHeaders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $RentalRequestHeaders
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

        $this->belongsTo('RentalRequestHeaders', [
            'foreignKey' => 'rental_request_header_id',
            'joinType' => 'INNER'
        ]);
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['rental_request_header_id'], 'RentalRequestHeaders'));
        return $rules;
    }
}
