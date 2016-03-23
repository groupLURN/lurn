<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResourceTransferHeadersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResourceTransferHeadersTable Test Case
 */
class ResourceTransferHeadersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResourceTransferHeadersTable
     */
    public $ResourceTransferHeaders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.resource_transfer_headers',
        'app.resource_request_headers',
        'app.project_from',
        'app.clients',
        'app.users',
        'app.user_types',
        'app.employees',
        'app.employee_types',
        'app.projects',
        'app.project_statuses',
        'app.equipment_project_inventories',
        'app.equipment_task_inventories',
        'app.manpower',
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
        'app.in_house_equipment_inventories',
        'app.rented_equipment_inventories',
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
        'app.employees_projects',
        'app.project_to',
        'app.equipment_request_details',
        'app.manpower_request_details',
        'app.material_request_details',
        'app.equipment_transfer_details',
        'app.manpower_transfer_details',
        'app.material_transfer_details'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ResourceTransferHeaders') ? [] : ['className' => 'App\Model\Table\ResourceTransferHeadersTable'];
        $this->ResourceTransferHeaders = TableRegistry::get('ResourceTransferHeaders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResourceTransferHeaders);

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
