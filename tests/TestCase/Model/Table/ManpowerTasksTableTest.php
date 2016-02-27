<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ManpowerTasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ManpowerTasksTable Test Case
 */
class ManpowerTasksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ManpowerTasksTable
     */
    public $ManpowerTasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.manpower_tasks',
        'app.manpower',
        'app.manpower_types',
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
        'app.materials',
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
        $config = TableRegistry::exists('ManpowerTasks') ? [] : ['className' => 'App\Model\Table\ManpowerTasksTable'];
        $this->ManpowerTasks = TableRegistry::get('ManpowerTasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ManpowerTasks);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
