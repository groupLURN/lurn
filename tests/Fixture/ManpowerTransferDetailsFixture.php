<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ManpowerTransferDetailsFixture
 *
 */
class ManpowerTransferDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'resource_transfer_header_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'manpower_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'manpower_id' => ['type' => 'index', 'columns' => ['manpower_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['resource_transfer_header_id', 'manpower_id'], 'length' => []],
            'manpower_transfer_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['resource_transfer_header_id'], 'references' => ['resource_transfer_headers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'manpower_transfer_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['manpower_id'], 'references' => ['manpower', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'resource_transfer_header_id' => 1,
            'manpower_id' => 1,
            'created' => '2016-03-22 14:36:41',
            'modified' => '2016-03-22 14:36:41'
        ],
    ];
}
