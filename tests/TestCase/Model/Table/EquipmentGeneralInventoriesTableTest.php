<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipmentGeneralInventoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipmentGeneralInventoriesTable Test Case
 */
class EquipmentGeneralInventoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipmentGeneralInventoriesTable
     */
    public $EquipmentGeneralInventories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipment_general_inventories',
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
        'app.equipment_tasks',
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
        $config = TableRegistry::exists('EquipmentGeneralInventories') ? [] : ['className' => 'App\Model\Table\EquipmentGeneralInventoriesTable'];
        $this->EquipmentGeneralInventories = TableRegistry::get('EquipmentGeneralInventories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EquipmentGeneralInventories);

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
