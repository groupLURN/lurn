<?php
namespace App\Model\Table;

use App\Model\Entity\MaterialsProjectInventory;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MaterialsProjectInventories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Materials
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\HasMany   $MaterialsTaskInventories
 */
class MaterialsProjectInventoriesTable extends Table
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

        $this->table('materials_project_inventories');
        $this->displayField('material_id');
        $this->primaryKey(['material_id', 'project_id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Materials', [
            'foreignKey' => 'material_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('MaterialsTaskInventories', [
            'foreignKey' => ['material_id', 'project_id'],
            'bindingKey' => ['material_id', 'project_id']
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
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

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
        $rules->add($rules->existsIn(['material_id'], 'Materials'));
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        return $rules;
    }
}
