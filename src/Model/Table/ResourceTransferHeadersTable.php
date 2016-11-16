<?php
namespace App\Model\Table;

use App\Model\Entity\ResourceTransferHeader;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Routing\Router;

/**
 * ResourceTransferHeaders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ResourceRequestHeaders
 * @property \Cake\ORM\Association\BelongsTo $ProjectFrom
 * @property \Cake\ORM\Association\BelongsTo $ProjectTo
 * @property \Cake\ORM\Association\BelongsToMany $EquipmentInventories
 * @property \Cake\ORM\Association\BelongsToMany $Manpower
 * @property \Cake\ORM\Association\BelongsToMany $Materials
 * @property \Cake\ORM\Association\HasMany $EquipmentTransferDetails
 * @property \Cake\ORM\Association\HasMany $ManpowerTransferDetails
 * @property \Cake\ORM\Association\HasMany $MaterialTransferDetails
 */
class ResourceTransferHeadersTable extends Table
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

        $this->table('resource_transfer_headers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ResourceRequestHeaders', [
            'foreignKey' => 'resource_request_header_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProjectFrom', [
            'className' => 'Projects',
            'foreignKey' => 'from_project_id'
        ]);
        $this->belongsTo('ProjectTo', [
            'className' => 'Projects',
            'foreignKey' => 'to_project_id'
        ]);
        $this->belongsToMany('EquipmentInventories', [
            'foreignKey' => 'resource_transfer_header_id',
            'targetForeignKey' => 'equipment_inventory_id',
            'joinTable' => 'equipment_transfer_details'
        ]);
        $this->belongsToMany('Manpower', [
            'foreignKey' => 'resource_transfer_header_id',
            'targetForeignKey' => 'manpower_id',
            'joinTable' => 'manpower_transfer_details'
        ]);
        $this->belongsToMany('Materials', [
            'foreignKey' => 'resource_transfer_header_id',
            'targetForeignKey' => 'material_id',
            'joinTable' => 'material_transfer_details'
        ]);
        $this->hasMany('EquipmentTransferDetails', [
            'foreignKey' => 'resource_transfer_header_id'
        ]);
        $this->hasMany('ManpowerTransferDetails', [
            'foreignKey' => 'resource_transfer_header_id'
        ]);
        $this->hasMany('MaterialTransferDetails', [
            'foreignKey' => 'resource_transfer_header_id'
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
        $rules->add($rules->existsIn(['resource_request_header_id'], 'ResourceRequestHeaders'));
        $rules->add($rules->existsIn(['from_project_id'], 'ProjectFrom'));
        $rules->add($rules->existsIn(['to_project_id'], 'ProjectTo'));
        return $rules;
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $resourceTransferHeader = $this->get($entity->id, [
            'contain' => ['ProjectTo', 'EquipmentTransferDetails',
                'ManpowerTransferDetails', 'MaterialTransferDetails']
        ]);

        foreach($resourceTransferHeader->equipment_transfer_details as $detail)
        {
            $equipmentInventory = TableRegistry::get('EquipmentInventories')->get($detail->equipment_inventory_id);
            $equipmentInventory->project_id = $resourceTransferHeader->project_to->id;
            TableRegistry::get('EquipmentInventories')->save($equipmentInventory);
        }

        foreach($resourceTransferHeader->manpower_transfer_details as $detail)
        {
            $manpower = TableRegistry::get('Manpower')->get($detail->manpower_id);
            $manpower->project_id = $resourceTransferHeader->project_to->id;
            TableRegistry::get('Manpower')->save($manpower);
        }

        foreach($resourceTransferHeader->material_transfer_details as $detail)
        {
            $materialGeneralInventory = TableRegistry::get('MaterialsGeneralInventories')
                ->get($detail->material_id);
            $materialGeneralInventory->quantity -= $detail->quantity;

            TableRegistry::get('MaterialsGeneralInventories')->save($materialGeneralInventory);

            try
            {
                $materialProjectInventory = TableRegistry::get('MaterialsProjectInventories')
                    ->get([
                        'material_id' => $detail->material_id,
                        'project_id' => $resourceTransferHeader->project_to->id
                    ], ['contain' => ['Materials']]);
                $materialProjectInventory->quantity += $detail->quantity;

                $material =  $materialProjectInventory->material;

                if( $materialGeneralInventory->quantity <= 30) {   

                    $employees = [];

                    $project = TableRegistry::get('Projects')->get($resourceTransferHeader->project_to->id, [
                        'contain' => ['Employees', 'EmployeesJoin' => ['EmployeeTypes']]]);

                    array_push($employees, $project->employee);
                    for ($i=0; $i < count($project->employees_join); $i++) { 
                        $employeeType = $project->employees_join[$i]->employee_type_id;
                        if($employeeType == 3 || $employeeType == 4) {
                            array_push($employees, $project->employees_join[$i]);
                        }
                    }

                    foreach ($employees as $employee) {                 
                        $notification = TableRegistry::get('Notifications')
                            ->newEntity();
                        $link =  str_replace(Router::url('/', false), "", Router::url(['controller' => 'materials-general-inventories', 'action' => 'view/'. $material->id ], false));
                        $notification->link = $link;
                        $plural = substr($material->name, -1) === 's' ? '':'s';
                        $notification->message = '<b>'.$material->name.'\''.$plural.'</b> quantity has reached critical levels.';
                        $notification->user_id = $employee['user_id'];
                        $notification->project_id = $resourceTransferHeader->project_to->id;
                        TableRegistry::get('Notifications')->save($notification);
                    }
                }

            }
            catch(RecordNotFoundException $e)
            {
                $materialProjectInventory = TableRegistry::get('MaterialsProjectInventories')->newEntity([
                    'material_id' => $detail->material_id,
                    'project_id' => $resourceTransferHeader->project_to->id,
                    'quantity' => $detail->quantity
                ]);
            }
            finally
            {
                TableRegistry::get('MaterialsProjectInventories')->save($materialProjectInventory);
            }
        }
    }

    public function findByProjectId(Query $query, array $options)
    {
        if($options['project_id'] > 0)
            return $query->where(['ResourceTransferHeaders.to_project_id' => $options['project_id']]);
        return $query;
    }

    public function findByTransferDateFrom(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->gte('ResourceTransferHeaders.created', $options['transfer_date_from'], 'datetime'),
        ]);
    }

    public function findByTransferDateTo(Query $query, array $options)
    {
        return $query->where([
            $query->newExpr()->lt('ResourceTransferHeaders.created', $options['transfer_date_to'], 'datetime')
        ]);
    }
}
