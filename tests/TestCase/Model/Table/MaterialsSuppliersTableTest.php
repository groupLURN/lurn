<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MaterialsSuppliersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MaterialsSuppliersTable Test Case
 */
class MaterialsSuppliersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MaterialsSuppliersTable
     */
    public $MaterialsSuppliers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.materials_suppliers',
        'app.materials',
        'app.materials_general_inventories',
        'app.materials_project_inventories',
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
        'app.manpower_types',
        'app.manpower_general_inventories',
        'app.manpower_types_tasks',
        'app.materials_tasks',
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
        $config = TableRegistry::exists('MaterialsSuppliers') ? [] : ['className' => 'App\Model\Table\MaterialsSuppliersTable'];
        $this->MaterialsSuppliers = TableRegistry::get('MaterialsSuppliers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MaterialsSuppliers);

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
