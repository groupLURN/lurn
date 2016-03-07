<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipmentTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipmentTable Test Case
 */
class EquipmentTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipmentTable
     */
    public $Equipment;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipment',
        'app.equipment_general_inventories',
        'app.equipment_inventories',
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
        'app.tasks',
        'app.milestones',
        'app.equipment_tasks',
        'app.manpower',
        'app.manpower_types',
        'app.task_inventory',
        'app.manpower_tasks',
        'app.materials',
        'app.materials_general_inventories',
        'app.materials_project_inventories',
        'app.materials_task_inventories',
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
        $config = TableRegistry::exists('Equipment') ? [] : ['className' => 'App\Model\Table\EquipmentTable'];
        $this->Equipment = TableRegistry::get('Equipment', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Equipment);

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
}
