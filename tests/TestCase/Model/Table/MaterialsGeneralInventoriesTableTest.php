<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MaterialsGeneralInventoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MaterialsGeneralInventoriesTable Test Case
 */
class MaterialsGeneralInventoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MaterialsGeneralInventoriesTable
     */
    public $MaterialsGeneralInventories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.materials_general_inventories',
        'app.materials',
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
        'app.employees_join',
        'app.equipment',
        'app.equipment_general_inventories',
        'app.equipment_project_inventories',
        'app.equipment_task_inventories',
        'app.equipment_tasks',
        'app.manpower',
        'app.manpower_types',
        'app.manpower_tasks',
        'app.materials_tasks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MaterialsGeneralInventories') ? [] : ['className' => 'App\Model\Table\MaterialsGeneralInventoriesTable'];
        $this->MaterialsGeneralInventories = TableRegistry::get('MaterialsGeneralInventories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MaterialsGeneralInventories);

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
