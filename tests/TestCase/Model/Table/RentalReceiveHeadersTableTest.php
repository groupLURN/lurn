<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RentalReceiveHeadersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RentalReceiveHeadersTable Test Case
 */
class RentalReceiveHeadersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RentalReceiveHeadersTable
     */
    public $RentalReceiveHeaders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rental_receive_headers',
        'app.rental_request_headers',
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
        'app.tasks',
        'app.milestones',
        'app.equipment_inventories',
        'app.equipment',
        'app.equipment_general_inventories',
        'app.equipment_tasks',
        'app.materials_task_inventories',
        'app.materials',
        'app.materials_general_inventories',
        'app.materials_project_inventories',
        'app.materials_tasks',
        'app.manpower_types',
        'app.manpower_general_inventories',
        'app.manpower_types_tasks',
        'app.employees_join',
        'app.suppliers',
        'app.rental_request_details',
        'app.rental_receive_details'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RentalReceiveHeaders') ? [] : ['className' => 'App\Model\Table\RentalReceiveHeadersTable'];
        $this->RentalReceiveHeaders = TableRegistry::get('RentalReceiveHeaders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RentalReceiveHeaders);

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
