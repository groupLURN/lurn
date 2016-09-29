<?php
namespace App\Model\Table;

use App\Model\Entity\Material;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
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
        $this->displayField('full_name');
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name', 'unit_measure']), null, ['errorField' => 'unit_measure', 'message' => 'This value is already in use.']);
        return $rules;
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

        if(isset($options['project_id']) && $options['project_id'] > 0)
            $query = $query->where(['MaterialsProjectInventories.project_id' => $options['project_id']]);

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
            ->leftJoin(['Projects' => 'projects'], ['Projects.id = MaterialsProjectInventories.project_id'])
            ->group('Materials.id');
    }

    public function findProjectInventorySummary(Query $query, array $options)
    {
        if (isset($options['start_date']) && isset($options['end_date'])):
            $available_quantity = $query->func()->coalesce(['MaterialsProjectInventories.quantity' => 'literal', 0]);
            $unavailable_quantity = $query->newExpr()->add(['SUM(COALESCE(MaterialsTaskInventories.quantity, 0))']);
            $total_quantity = $query->newExpr()->add(['COALESCE(MaterialsProjectInventories.quantity, 0) + SUM(COALESCE(MaterialsTaskInventories.quantity, 0))']);
        else:
            $available_quantity = $query->func()->coalesce(['MaterialsProjectInventories.quantity' => 'literal', 0]);
            $unavailable_quantity = $query->newExpr()->add(['SUM(COALESCE(MaterialsTaskInventories.quantity, 0))']);
            $total_quantity = $query->newExpr()->add(['COALESCE(MaterialsProjectInventories.quantity, 0) + SUM(COALESCE(MaterialsTaskInventories.quantity, 0))']);

        endif;  

        if(isset($options['id']))
            $query->where(['Materials.id' => $options['id']]);

        if(isset($options['milestone_id']) && $options['milestone_id'] > 0)
            $query
                ->leftJoinWith('MaterialsTaskInventories.Tasks')
                ->where(['Tasks.milestone_id' => $options['milestone_id']]);

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
            ->leftJoin(['Projects' => 'projects'], ['Projects.id = MaterialsProjectInventories.project_id'])
            ->group(['MaterialsProjectInventories.project_id', 'Materials.id']);
    }

    public function findByProjectId(Query $query, array $options)
    {
        if($options['project_id'] > 0)
            return $query->where(['Projects.id' => $options['project_id']]);
        return $query;
    }

    public function findByScheduleDateFrom(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->gte('Tasks.start_date', $options['schedule_date_from'], 'datetime'),
        ]);
    }

    public function findByScheduleDateTo(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->lt('Tasks.end_date', $options['schedule_date_to'], 'datetime')
        ]);
    }

    public function findMaterialsSchedule(Query $query, array $options)
    {
        return $query
            ->hydrate(false)
            ->select(TableRegistry::get('Materials'))
            ->select(TableRegistry::get('Tasks'))
            ->select(TableRegistry::get('MaterialsTasks'))
            ->select(TableRegistry::get('Projects'))
            ->select(TableRegistry::get('Milestones'))
            ->select(['quantity_available' => $query->func()->coalesce(['MaterialsGeneralInventories.quantity' => 'literal', 0])])
            ->innerJoin(['MaterialsTasks' => 'materials_tasks'], ['MaterialsTasks.material_id = Materials.id'])
            ->innerJoin(['Tasks' => 'tasks'], ['Tasks.id = MaterialsTasks.task_id'])
            ->leftJoin(['Milestones' => 'milestones'], ['Milestones.id = Tasks.milestone_id'])
            ->leftJoin(['Projects' => 'projects'], ['Projects.id = Milestones.project_id'])
            ->leftJoinWith('MaterialsGeneralInventories');
    }

    public function findByTaskAndSupplier(Query $query, array $options)
    {
        if((float)$options['task_id'] > -1 && (float)$options['supplier_id'] > -1){

            return $query
                ->join([
                    'mt' => [
                        'table' => 'materials_tasks',
                        'type' => 'INNER',
                        'conditions' => ['mt.material_id = Materials.id']],
                    'ms' => [
                        'table' => 'materials_suppliers',
                        'type' => 'INNER',
                        'conditions' => ['ms.material_id = mt.material_id']
                    ]
                ])
                ->where(['ms.supplier_id' => $options['supplier_id'],
                    'mt.task_id' => $options['task_id']]);
        } else {

            return $query;
        }
    }

}
