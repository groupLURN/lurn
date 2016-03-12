<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RentalReceiveDetailsFixture
 *
 */
class RentalReceiveDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'rental_receive_header_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'rental_request_detail_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantity' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'start_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'end_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'rental_receive_header_id' => ['type' => 'index', 'columns' => ['rental_receive_header_id'], 'length' => []],
            'rental_request_detail_id' => ['type' => 'index', 'columns' => ['rental_request_detail_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'rental_receive_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['rental_receive_header_id'], 'references' => ['rental_receive_headers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'rental_receive_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['rental_request_detail_id'], 'references' => ['rental_request_details', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'rental_receive_header_id' => 1,
            'rental_request_detail_id' => 1,
            'quantity' => 1,
            'start_date' => '2016-03-12 23:04:35',
            'end_date' => '2016-03-12 23:04:35',
            'created' => '2016-03-12 23:04:35',
            'modified' => '2016-03-12 23:04:35'
        ],
    ];
}
