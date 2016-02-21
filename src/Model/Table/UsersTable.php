<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use ArrayObject;
use Cake\Event\Event;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $UserTypes
 * @property \Cake\ORM\Association\HasMany $Clients
 * @property \Cake\ORM\Association\HasMany $Employees
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UserTypes', [
            'foreignKey' => 'user_type_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Clients', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Employees', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('username', 'create')
            ->notEmpty('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['user_type_id'], 'UserTypes'));
        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if(!isset($data['user_type_id']) && isset($data['user_type_title'])){
            $user = TableRegistry::get('user_types')->find()
                ->select(['id'])
                ->where(['title' => $data['user_type_title']])
                ->firstOrFail();
            $data['user_type_id'] = $user->id;
        }
    }

    public function findByUsername(Query $query, array $options)
    {
        return $query->where($query->newExpr()->like('username', '%' . $options['username'] . '%'));
    }

    public function findByUserTypeId(Query $query, array $options)
    {
        if((int)$options['user_type_id'] > 0)
            return $query->where(['user_type_id' => $options['user_type_id']]);
        else
            return $query;
    }
}
