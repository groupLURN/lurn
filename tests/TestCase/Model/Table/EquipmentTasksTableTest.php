<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipmentTasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipmentTasksTable Test Case
 */
class EquipmentTasksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipmentTasksTable
     */
    public $EquipmentTasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipment_tasks',
        'app.equipment',
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
        'app.manpower',
        'app.manpower_types',
        'app.manpower_tasks',
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
        $config = TableRegistry::exists('EquipmentTasks') ? [] : ['className' => 'App\Model\Table\EquipmentTasksTable'];
        $this->EquipmentTasks = TableRegistry::get('EquipmentTasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EquipmentTasks);

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
