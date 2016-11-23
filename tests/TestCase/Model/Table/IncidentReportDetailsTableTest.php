<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IncidentReportDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IncidentReportDetailsTable Test Case
 */
class IncidentReportDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\IncidentReportDetailsTable
     */
    public $IncidentReportDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.incident_report_details',
        'app.incident_report_headers',
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
        'app.equipment_replenishment_details',
        'app.manpower_type_replenishment_details',
        'app.material_replenishment_details',
        'app.employees_join'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('IncidentReportDetails') ? [] : ['className' => 'App\Model\Table\IncidentReportDetailsTable'];
        $this->IncidentReportDetails = TableRegistry::get('IncidentReportDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IncidentReportDetails);

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
