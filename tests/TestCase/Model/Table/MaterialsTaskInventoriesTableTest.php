<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MaterialsTaskInventoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MaterialsTaskInventoriesTable Test Case
 */
class MaterialsTaskInventoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MaterialsTaskInventoriesTable
     */
    public $MaterialsTaskInventories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.materials_task_inventories',
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
        'app.milestones',
        'app.tasks',
        'app.equipment',
        'app.equipment_general_inventories',
        'app.equipment_project_inventories',
        'app.equipment_task_inventories',
        'app.equipment_tasks',
        'app.manpower',
        'app.manpower_types',
        'app.manpower_tasks',
        'app.materials_tasks',
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
        $config = TableRegistry::exists('MaterialsTaskInventories') ? [] : ['className' => 'App\Model\Table\MaterialsTaskInventoriesTable'];
        $this->MaterialsTaskInventories = TableRegistry::get('MaterialsTaskInventories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MaterialsTaskInventories);

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
