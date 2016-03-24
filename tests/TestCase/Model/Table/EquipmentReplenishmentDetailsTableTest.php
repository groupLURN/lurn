<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipmentReplenishmentDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipmentReplenishmentDetailsTable Test Case
 */
class EquipmentReplenishmentDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipmentReplenishmentDetailsTable
     */
    public $EquipmentReplenishmentDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipment_replenishment_details',
        'app.tasks',
        'app.milestones',
        'app.projects',
        'app.clients',
        'app.users',
        'app.user_types',
        'app.employees',
        'app.employee_types',
        'app.employees_projects',
        'app.project_statuses',
        'app.equipment_project_inventories',
        'app.equipment_task_inventories',
        'app.manpower',
        'app.manpower_types',
        'app.manpower_general_inventories',
        'app.materials_project_inventories',
        'app.materials',
        'app.materials_general_inventories',
        'app.materials_task_inventories',
        'app.materials_tasks',
        'app.employees_join',
        'app.equipment_inventories',
        'app.equipment',
        'app.equipment_general_inventories',
        'app.rental_receive_details',
        'app.rental_receive_headers',
        'app.rental_request_details',
        'app.rental_request_headers',
        'app.suppliers',
        'app.in_house_equipment_inventories',
        'app.rented_equipment_inventories',
        'app.equipment_tasks',
        'app.manpower_type_replenishment_details',
        'app.material_replenishment_details',
        'app.manpower_types_tasks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EquipmentReplenishmentDetails') ? [] : ['className' => 'App\Model\Table\EquipmentReplenishmentDetailsTable'];
        $this->EquipmentReplenishmentDetails = TableRegistry::get('EquipmentReplenishmentDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EquipmentReplenishmentDetails);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
