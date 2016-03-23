<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipmentTransferDetailsFixture
 *
 */
class EquipmentTransferDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'resource_transfer_header_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'equipment_inventory_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'equipment_inventory_id' => ['type' => 'index', 'columns' => ['equipment_inventory_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['resource_transfer_header_id', 'equipment_inventory_id'], 'length' => []],
            'equipment_transfer_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['resource_transfer_header_id'], 'references' => ['resource_transfer_headers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'equipment_transfer_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['equipment_inventory_id'], 'references' => ['equipment_inventories', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'equipment_inventory_id' => 1,
            'created' => '2016-03-22 14:36:34',
            'modified' => '2016-03-22 14:36:34'
        ],
    ];
}
