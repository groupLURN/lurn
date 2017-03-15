<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ManpowerTasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ManpowerTasksTable Test Case
 */
class ManpowerTasksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ManpowerTasksTable
     */
    public $ManpowerTasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.manpower_tasks',
        'app.manpower',
        'app.projects',
        'app.clients',
        'app.users',
        'app.user_types',
        'app.employees',
        'app.employee_types',
        'app.employees_projects',
        'app.materials_project_inventories',
        'app.materials',
        'app.materials_general_inventories',
        'app.materials_task_inventories',
        'app.tasks',
        'app.milestones',
        'app.equipment_inventories',
        'app.equipment',
        'app.equipment_general_inventories',
        'app.rental_receive_details',
        'app.rental_receive_headers',
        'app.rental_request_details',
        'app.rental_request_headers',
        'app.suppliers',
        'app.materials_suppliers',
        'app.equipment_suppliers',
        'app.equipment_transfer_details',
        'app.resource_transfer_headers',
        'app.resource_request_headers',
        'app.project_from',
        'app.projects_files',
        'app.notifications',
        'app.employees_join',
        'app.project_phases',
        'app.project_to',
        'app.equipment_request_details',
        'app.manpower_types',
        'app.manpower_general_inventories',
        'app.manpower_request_details',
        'app.material_request_details',
        'app.manpower_transfer_details',
        'app.material_transfer_details',
        'app.in_house_equipment_inventories',
        'app.rented_equipment_inventories',
        'app.equipment_tasks',
        'app.manpower_types_tasks',
        'app.materials_tasks',
        'app.equipment_replenishment_details',
        'app.manpower_type_replenishment_details',
        'app.material_replenishment_details'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ManpowerTasks') ? [] : ['className' => 'App\Model\Table\ManpowerTasksTable'];
        $this->ManpowerTasks = TableRegistry::get('ManpowerTasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ManpowerTasks);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
