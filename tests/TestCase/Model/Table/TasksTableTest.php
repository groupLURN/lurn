<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TasksTable Test Case
 */
class TasksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TasksTable
     */
    public $Tasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tasks',
        'app.milestones',
        'app.projects',
        'app.clients',
        'app.users',
        'app.user_types',
        'app.employees',
        'app.employee_types',
        'app.employees_projects',
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
        'app.manpower_types_tasks',
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
        $config = TableRegistry::exists('Tasks') ? [] : ['className' => 'App\Model\Table\TasksTable'];
        $this->Tasks = TableRegistry::get('Tasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tasks);

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

    /**
     * Test beforeMarshal method
     *
     * @return void
     */
    public function testBeforeMarshal()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test computeForTaskReplenishmentUsingMilestones method
     *
     * @return void
     */
    public function testComputeForTaskReplenishmentUsingMilestones()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test computeForTaskReplenishment method
     *
     * @return void
     */
    public function testComputeForTaskReplenishment()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test replenish method
     *
     * @return void
     */
    public function testReplenish()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test returnToProjectInventory method
     *
     * @return void
     */
    public function testReturnToProjectInventory()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
