<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ManpowerTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ManpowerTable Test Case
 */
class ManpowerTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ManpowerTable
     */
    public $Manpower;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        'app.equipment',
        'app.equipment_general_inventories',
        'app.equipment_inventories',
        'app.equipment_tasks',
        'app.manpower_tasks',
        'app.materials_tasks',
        'app.employees_join',
        'app.manpower_types',
        'app.task_inventory'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Manpower') ? [] : ['className' => 'App\Model\Table\ManpowerTable'];
        $this->Manpower = TableRegistry::get('Manpower', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Manpower);

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
     * Test findByManpowerTypeId method
     *
     * @return void
     */
    public function testFindByManpowerTypeId()
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
