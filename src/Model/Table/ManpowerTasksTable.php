<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ManpowerTasks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Manpower
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 *
 * @method \App\Model\Entity\ManpowerTask get($primaryKey, $options = [])
 * @method \App\Model\Entity\ManpowerTask newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ManpowerTask[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ManpowerTask|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ManpowerTask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ManpowerTask[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ManpowerTask findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ManpowerTasksTable extends Table
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

        $this->table('manpower_tasks');
        $this->displayField('manpower_id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Manpower', [
            'foreignKey' => 'manpower_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['manpower_id'], 'Manpower'));
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));

        return $rules;
    }

    public function findByTask(Query $query, array $options)
    {
        if($options['task_id'] > 0)
            return $query
                ->contain(['Manpower'])
                ->where(['project_id' => $options['project_id'], 'task_id' => $options['task_id']]);
        return $query;
    }
}
