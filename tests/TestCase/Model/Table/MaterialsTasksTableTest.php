<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MaterialsTasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MaterialsTasksTable Test Case
 */
class MaterialsTasksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MaterialsTasksTable
     */
    public $MaterialsTasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.materials_tasks',
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
        'app.equipment_tasks',
        'app.manpower',
        'app.manpower_types',
        'app.manpower_tasks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MaterialsTasks') ? [] : ['className' => 'App\Model\Table\MaterialsTasksTable'];
        $this->MaterialsTasks = TableRegistry::get('MaterialsTasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MaterialsTasks);

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
