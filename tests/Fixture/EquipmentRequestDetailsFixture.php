<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipmentRequestDetailsFixture
 *
 */
class EquipmentRequestDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'resource_request_header_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'equipment_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantity' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'equipment_id' => ['type' => 'index', 'columns' => ['equipment_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['resource_request_header_id', 'equipment_id'], 'length' => []],
            'equipment_request_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['resource_request_header_id'], 'references' => ['resource_request_headers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'equipment_request_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['equipment_id'], 'references' => ['equipment', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'equipment_id' => 1,
            'quantity' => 1,
            'created' => '2016-03-21 17:55:03',
            'modified' => '2016-03-21 17:55:03'
        ],
    ];
}
