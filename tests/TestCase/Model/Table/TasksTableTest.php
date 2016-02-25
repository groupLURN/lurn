<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TasksTable Test Case
 */
class TasksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TasksTable
     */
    public $Tasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('Tasks') ? [] : ['className' => 'App\Model\Table\TasksTable'];
        $this->Tasks = TableRegistry::get('Tasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tasks);
        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
//        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
//        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
//        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testTasksJoinTableEntity()
    {
        $id = '1456288551600';

        $data = [
            'equipment' => [
                [
                    'id' => 5,
                    '_joinData' => [
                        'quantity' => 3
                    ]
                ]
            ]
        ];

        $task = $this->Tasks->get($id, [
            'contain' => ['Equipment']
        ]);

        $task = $this->Tasks->patchEntity($task, $data, [
            'associated' => ['Equipment']
        ]);

        fwrite(STDERR, print_r($task, true));
    }
}
