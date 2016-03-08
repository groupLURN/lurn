<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ManpowerTypesTasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ManpowerTypesTasksTable Test Case
 */
class ManpowerTypesTasksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ManpowerTypesTasksTable
     */
    public $ManpowerTypesTasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.manpower_types_tasks',
        'app.manpower_types',
        'app.manpower',
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
        'app.materials_project_inventories',
        'app.materials',
        'app.materials_general_inventories',
        'app.materials_task_inventories',
        'app.tasks',
        'app.milestones',
        'app.equipment_inventories',
        'app.equipment',
        'app.equipment_general_inventories',
        'app.equipment_tasks',
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
        $config = TableRegistry::exists('ManpowerTypesTasks') ? [] : ['className' => 'App\Model\Table\ManpowerTypesTasksTable'];
        $this->ManpowerTypesTasks = TableRegistry::get('ManpowerTypesTasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ManpowerTypesTasks);

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
