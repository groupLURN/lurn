<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PurchaseReceiveDetailsFixture
 *
 */
class PurchaseReceiveDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'purchase_receive_header_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'purchase_order_detail_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantity' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'purchase_receive_header_id' => ['type' => 'index', 'columns' => ['purchase_receive_header_id'], 'length' => []],
            'purchase_order_detail_id' => ['type' => 'index', 'columns' => ['purchase_order_detail_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'purchase_receive_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['purchase_receive_header_id'], 'references' => ['purchase_receive_headers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'purchase_receive_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['purchase_order_detail_id'], 'references' => ['purchase_order_details', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'purchase_receive_header_id' => 1,
            'purchase_order_detail_id' => 1,
            'quantity' => 1,
            'created' => '2016-03-23 17:07:33',
            'modified' => '2016-03-23 17:07:33'
        ],
    ];
}
