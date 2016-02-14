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
        'app.manpower_types'
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
}
