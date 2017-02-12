<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectPhases Model
 *
 * @method \App\Model\Entity\ProjectPhase get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectPhase newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectPhase[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectPhase|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectPhase patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectPhase[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectPhase findOrCreate($search, callable $callback = null)
 */
class ProjectPhasesTable extends Table
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

        $this->table('project_phases');
        $this->displayField('name');
        $this->primaryKey('id');
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
