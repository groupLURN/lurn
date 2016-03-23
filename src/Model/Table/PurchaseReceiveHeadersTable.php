<?php
namespace App\Model\Table;

use App\Model\Entity\PurchaseReceiveHeader;
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
}
