<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ManpowerRequestDetailsFixture
 *
 */
class ManpowerRequestDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'resource_request_header_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'manpower_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantity' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'manpower_type_id' => ['type' => 'index', 'columns' => ['manpower_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['resource_request_header_id', 'manpower_type_id'], 'length' => []],
            'manpower_request_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['resource_request_header_id'], 'references' => ['resource_request_headers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'manpower_request_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['manpower_type_id'], 'references' => ['manpower_types', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'resource_request_header_id' => 1,
            'manpower_type_id' => 1,
            'quantity' => 1,
            'created' => '2016-03-21 17:55:16',
            'modified' => '2016-03-21 17:55:16'
        ],
    ];
}
