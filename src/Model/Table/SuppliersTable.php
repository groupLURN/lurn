<?php
namespace App\Model\Table;

use App\Model\Entity\Supplier;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Suppliers Model
 *
 */
class SuppliersTable extends Table
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

        $this->table('suppliers');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('contact_number', 'create')
            ->notEmpty('contact_number');

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

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
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }

    public function findByName(Query $query, array $options)
    {
        return $query->where(function($exp) use ($options){
            return $exp->like('name', '%' . $options['name'] . '%');
        });
    }

    public function findByMaterial(Query $query, array $options)
    {
        if((int)$options['material_id'] > 0){
            return $query
                ->join([
                    'ms' => [
                        'table' => 'materials_suppliers',
                        'type' => 'INNER',
                        'conditions' => ['ms.material_id' => $options['material_id'],
                        'ms.supplier_id = Suppliers.id']
                    ]
                ])
                ->where('Suppliers.id = supplier_id');
        } else {
            return $query;
        }
    }
}
