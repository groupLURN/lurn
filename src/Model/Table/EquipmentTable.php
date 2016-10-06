<?php
namespace App\Model\Table;

use App\Model\Entity\Equipment;
use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Equipment Model
 *
 * @property \Cake\ORM\Association\HasMany $EquipmentGeneralInventories
 * @property \Cake\ORM\Association\HasMany $EquipmentInventories
 * @property \Cake\ORM\Association\HasMany $InHouseEquipmentInventories
 * @property \Cake\ORM\Association\HasMany $RentedEquipmentInventories
 * @property \Cake\ORM\Association\BelongsToMany $Tasks
 */
class EquipmentTable extends Table
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

        $this->table('equipment');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('EquipmentGeneralInventories', [
            'className' => 'EquipmentInventories',
            'foreignKey' => 'equipment_id',
            'conditions' => ['EquipmentGeneralInventories.project_id IS' => null]
        ]);

        $this->hasMany('EquipmentInventories', [
            'foreignKey' => 'equipment_id'
        ]);

        $this->hasMany('InHouseEquipmentInventories', [
            'className' => 'EquipmentInventories',
            'foreignKey' => 'equipment_id',
            'conditions' => ['InHouseEquipmentInventories.rental_receive_detail_id IS' => null]
        ]);

        $this->hasMany('RentedEquipmentInventories', [
            'className' => 'EquipmentInventories',
            'foreignKey' => 'equipment_id',
            'conditions' => ['RentedEquipmentInventories.rental_receive_detail_id IS NOT' => null]
        ]);

        $this->belongsToMany('Tasks', [
            'foreignKey' => 'equipment_id',
            'targetForeignKey' => 'task_id',
            'joinTable' => 'equipment_tasks'
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

        return $validator;
    }

    public function adjustInHouseInventory(Equipment $equipment, $quantity)
    {
        return $this->connection()->transactional(function() use ($equipment, $quantity)
        {
            $this->EquipmentInventories->deleteAll([
                'rental_receive_detail_id IS' => null,
                'equipment_id' => $equipment->id
            ]);

            $datum = [
                'equipment_id' => $equipment->id
            ];

            $data = array_fill(0, $quantity, $datum);
            $equipmentInventories = $this->EquipmentInventories->newEntities($data);

            foreach($equipmentInventories as $equipmentInventory)
                $this->EquipmentInventories->save($equipmentInventory, ['atomic' => false]);
            return true;
        });
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        foreach (['created', 'modified'] as $key) {
            if (isset($data[$key]) && is_string($data[$key])) {
                $data[$key] = Time::parseDateTime($data[$key], 'yyyy/MM/dd');
            }
        }
    }

    public function findByName(Query $query, array $options)
    {
        return $query->where(function($exp) use ($options){
            return $exp->like('name', '%' . $options['name'] . '%');
        });
    }

    public function findByProjectId(Query $query, array $options)
    {
        if(!empty($options['project_id']))
            return $query->having(['project_id' => $options['project_id']]);
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
    public function findByEquipmentType(Query $query, array $options)
    {
        $equipmentTypes = array_flip(Equipment::getTypes());

        $hasInHouse = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add('rental_receive_detail_id IS NULL'), 1
            )
        );

        $hasRented = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add([
                    'rental_receive_detail_id IS NOT NULL',
                    'RentalReceiveDetails.id IS NOT NULL'
                ]), 1
            )
        );

        $query->select(['_hasInHouse' => $hasInHouse, '_hasRented' => $hasRented]);
        $query->leftJoinWith('EquipmentInventories.RentalReceiveDetails');
        if((int)$options['equipment_type'] === $equipmentTypes['In-House'])
            $query->having(['_hasInHouse > 0']);
        else if((int)$options['equipment_type'] === $equipmentTypes['Rented'])
            $query->having(['_hasRented > 0']);
        return $query;
    }

    public function findBySupplierId(Query $query, array $options)
    {
        if($options['supplier_id'] > 0)
        {
            $hasSupplier = $query->func()->sum(
                $query->newExpr()->addCase(
                    $query->newExpr()->add(['RentalRequestHeaders.supplier_id' => $options['supplier_id']]), 1
                )
            );

            $query->select(['_hasSupplier' => $hasSupplier])
                ->leftJoinWith('EquipmentInventories.RentalReceiveDetails.RentalRequestDetails.RentalRequestHeaders')
                ->having('_hasSupplier > 0');
        }
        return $query;
    }

    public function findEquipmentSchedule(Query $query, array $options)
    {
        return $query
            ->hydrate(false)
            ->select(TableRegistry::get('Equipment'))
            ->select(TableRegistry::get('Tasks'))
            ->select(TableRegistry::get('EquipmentTasks'))
            ->select(TableRegistry::get('Projects'))
            ->select(TableRegistry::get('Milestones'))
            ->select(['quantity_available' => $query->func()->count('EquipmentGeneralInventories.id')])
            ->innerJoin(['EquipmentTasks' => 'equipment_tasks'], ['EquipmentTasks.equipment_id = Equipment.id'])
            ->innerJoin(['Tasks' => 'tasks'], ['Tasks.id = EquipmentTasks.task_id'])
            ->leftJoin(['Milestones' => 'milestones'], ['Milestones.id = Tasks.milestone_id'])
            ->leftJoin(['Projects' => 'projects'], ['Projects.id = Milestones.project_id'])
            ->leftJoinWith('EquipmentGeneralInventories')
            ->group(['EquipmentTasks.equipment_id', 'EquipmentTasks.task_id']);
    }

    public function findGeneralInventorySummary(Query $query, array $options)
    {
        $available_in_house_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add([
                    'AND' =>
                        [
                            'EquipmentInventories.project_id IS' => null,
                            'EquipmentInventories.rental_receive_detail_id IS' => null,
                        ]
                ]),
                1,
                'integer'
            )
        );

        $available_rented_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add([
                    'AND' =>
                        [
                            'EquipmentInventories.project_id IS' => null,
                            'EquipmentInventories.rental_receive_detail_id IS NOT' => null,
                            'RentalReceiveDetails.id IS NOT' => null
                        ]
                ]),
                1,
                'integer'
            )
        );

        $unavailable_in_house_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add([
                    'AND' =>
                        [
                            'EquipmentInventories.project_id IS NOT' => null,
                            'EquipmentInventories.rental_receive_detail_id IS' => null,
                        ]
                ]),
                1,
                'integer'
            )
        );

        $unavailable_rented_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add([
                    'AND' =>
                        [
                            'EquipmentInventories.project_id IS NOT' => null,
                            'EquipmentInventories.rental_receive_detail_id IS NOT' => null,
                            'RentalReceiveDetails.id IS NOT' => null
                        ]
                ]),
                1,
                'integer'
            )
        );

        $total_quantity = $query->func()->sum(
            $query->newExpr()->addCase(
                $query->newExpr()->add([
                    'OR' =>
                        [
                            'EquipmentInventories.rental_receive_detail_id IS' => null,
                            'AND' => [
                                'EquipmentInventories.rental_receive_detail_id IS NOT' => null,
                                'RentalReceiveDetails.id IS NOT' => null
                            ]
                        ]
                ]),
                1,
                'integer'
            )
        );

        if(isset($options['id']))
            $query = $query->where(['Equipment.id' => $options['id']]);

        return $query->select(['Equipment.id', 'Equipment.name', 'last_modified' => 'EquipmentInventories.modified',
            'available_in_house_quantity' => $available_in_house_quantity,
            'available_rented_quantity' => $available_rented_quantity,
            'unavailable_in_house_quantity' => $unavailable_in_house_quantity,
            'unavailable_rented_quantity' => $unavailable_rented_quantity,
            'total_quantity' => $total_quantity,
            'project_id' => 'EquipmentInventories.project_id'])
            ->leftJoinWith('EquipmentInventories.RentalReceiveDetails')
            ->group('Equipment.id');
    }

    public function findByTaskAndSupplier(Query $query, array $options)
    {
        if((float)$options['task_id'] > -1 && (float)$options['supplier_id'] > -1){

            return $query
                ->join([
                    'et' => [
                        'table' => 'equipment_tasks',
                        'type' => 'INNER',
                        'conditions' => ['et.equipment_id = Equipment.id']],
                    'es' => [
                        'table' => 'equipment_suppliers',
                        'type' => 'INNER',
                        'conditions' => ['es.equipment_id = et.equipment_id']
                    ]
                ])
                ->where(['es.supplier_id' => $options['supplier_id'],
                    'et.task_id' => $options['task_id']]);
        } else {

            return $query;
        }
    }

}
