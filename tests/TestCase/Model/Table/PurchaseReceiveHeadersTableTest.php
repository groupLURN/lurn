<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchaseReceiveHeadersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchaseReceiveHeadersTable Test Case
 */
class PurchaseReceiveHeadersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchaseReceiveHeadersTable
     */
    public $PurchaseReceiveHeaders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.purchase_receive_headers',
        'app.purchase_receive_details'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PurchaseReceiveHeaders') ? [] : ['className' => 'App\Model\Table\PurchaseReceiveHeadersTable'];
        $this->PurchaseReceiveHeaders = TableRegistry::get('PurchaseReceiveHeaders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PurchaseReceiveHeaders);

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
