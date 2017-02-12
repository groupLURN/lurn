<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectPhasesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectPhasesTable Test Case
 */
class ProjectPhasesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectPhasesTable
     */
    public $ProjectPhases;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.project_phases'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProjectPhases') ? [] : ['className' => 'App\Model\Table\ProjectPhasesTable'];
        $this->ProjectPhases = TableRegistry::get('ProjectPhases', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProjectPhases);

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
