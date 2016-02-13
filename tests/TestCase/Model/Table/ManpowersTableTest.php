<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ManpowersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ManpowersTable Test Case
 */
class ManpowersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ManpowersTable
     */
    public $Manpowers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.manpowers',
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
        $config = TableRegistry::exists('Manpowers') ? [] : ['className' => 'App\Model\Table\ManpowersTable'];
        $this->Manpowers = TableRegistry::get('Manpowers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Manpowers);

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
