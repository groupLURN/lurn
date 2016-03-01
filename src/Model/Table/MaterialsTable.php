<?php
namespace App\Model\Table;

use App\Model\Entity\Material;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Materials Model
 *
 * @property \Cake\ORM\Association\HasMany $MaterialsGeneralInventories
 * @property \Cake\ORM\Association\HasMany $MaterialsProjectInventories
 * @property \Cake\ORM\Association\HasMany $MaterialsTaskInventories
 * @property \Cake\ORM\Association\BelongsToMany $Tasks
 */
class MaterialsTable extends Table
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

        $this->table('materials');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('MaterialsGeneralInventories', [
            'foreignKey' => 'material_id'
        ]);
        $this->hasMany('MaterialsProjectInventories', [
            'foreignKey' => 'material_id'
        ]);
        $this->hasMany('MaterialsTaskInventories', [
            'foreignKey' => 'material_id'
        ]);
        $this->belongsToMany('Tasks', [
            'foreignKey' => 'material_id',
            'targetForeignKey' => 'task_id',
            'joinTable' => 'materials_tasks'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('unit_measure', 'create')
            ->notEmpty('unit_measure');

        return $validator;
    }

    public function findByName(Query $query, array $options)
    {
        return $query->where(function($exp) use ($options){
            return $exp->like('name', '%' . $options['name'] . '%');
        });
    }

    public function findGeneralInventorySummary(Query $query, array $options)
    {
        $available_quantity = $query->func()->coalesce(['MaterialsGeneralInventories.quantity' => 'literal', 0]);

        $unavailable_quantity = $query->newExpr()->add([
            'SUM(COALESCE(MaterialsProjectInventories.quantity, 0)) + SUM(COALESCE(MaterialsTaskInventories.quantity, 0))'
        ]);

        $total_quantity = $query->newExpr()->add([
            'COALESCE(MaterialsGeneralInventories.quantity, 0) + SUM(COALESCE(MaterialsProjectInventories.quantity, 0)) + SUM(COALESCE(MaterialsTaskInventories.quantity, 0))'
        ]);

        if(isset($options['id']))
            $query = $query->where(['Materials.id' => $options['id']]);

        return $query->select(['Materials.id', 'Materials.name', 'Materials.unit_measure',
            'last_modified' => 'MaterialsGeneralInventories.modified', 'available_quantity' => $available_quantity,
            'unavailable_quantity' => $unavailable_quantity, 'total_quantity' => $total_quantity])
            ->leftJoin(['MaterialsGeneralInventories' => 'materials_general_inventories'], [
                'MaterialsGeneralInventories.material_id = Materials.id'
            ])
            ->leftJoin(['MaterialsProjectInventories' => 'materials_project_inventories'], [
                'MaterialsProjectInventories.material_id = Materials.id'
            ])
            ->leftJoin(['MaterialsTaskInventories' => 'materials_task_inventories'], [
                'MaterialsTaskInventories.material_id = Materials.id'
            ])
            ->group('Materials.id');
    }

    public function findProjectInventorySummary(Query $query, array $options)
    {
        $available_quantity = $query->func()->coalesce(['MaterialsProjectInventories.quantity' => 'literal', 0]);

        $unavailable_quantity = $query->newExpr()->add([
            'SUM(COALESCE(MaterialsTaskInventories.quantity, 0))'
        ]);

        $total_quantity = $query->newExpr()->add([
            'COALESCE(MaterialsProjectInventories.quantity, 0) + SUM(COALESCE(MaterialsTaskInventories.quantity, 0))'
        ]);

        if(isset($options['id']))
            $query = $query->where(['Materials.id' => $options['id']]);

        return $query->select(['Materials.id', 'Materials.name', 'Materials.unit_measure',
            'last_modified' => 'MaterialsProjectInventories.modified', 'available_quantity' => $available_quantity,
            'unavailable_quantity' => $unavailable_quantity, 'total_quantity' => $total_quantity])
            ->innerJoin(['MaterialsProjectInventories' => 'materials_project_inventories'], [
                'MaterialsProjectInventories.material_id = Materials.id',
                'MaterialsProjectInventories.project_id' => $options['project_id']
            ])
            ->leftJoin(['MaterialsTaskInventories' => 'materials_task_inventories'], [
                'MaterialsTaskInventories.material_id = Materials.id',
                'MaterialsTaskInventories.project_id' => $options['project_id']
            ])
            ->group(['MaterialsProjectInventories.project_id', 'Materials.id']);
    }
}
