<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MaterialsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MaterialsTable Test Case
 */
class MaterialsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MaterialsTable
     */
    public $Materials;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        'app.project_statuses',
        'app.equipment_project_inventories',
        'app.equipment_task_inventories',
        'app.manpower',
        'app.manpower_types',
        'app.task_inventory',
        'app.milestones',
        'app.tasks',
        'app.equipment',
        'app.equipment_general_inventories',
        'app.equipment_inventories',
        'app.equipment_tasks',
        'app.manpower_tasks',
        'app.materials_tasks',
        'app.materials_task_inventories',
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
        $config = TableRegistry::exists('Materials') ? [] : ['className' => 'App\Model\Table\MaterialsTable'];
        $this->Materials = TableRegistry::get('Materials', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Materials);

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
     * Test findByName method
     *
     * @return void
     */
    public function testFindByName()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findGeneralInventorySummary method
     *
     * @return void
     */
    public function testFindGeneralInventorySummary()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findProjectInventorySummary method
     *
     * @return void
     */
    public function testFindProjectInventorySummary()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
