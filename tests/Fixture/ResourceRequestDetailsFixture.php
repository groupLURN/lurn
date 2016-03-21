<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResourceRequestDetailsFixture
 *
 */
class ResourceRequestDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'resource_request_header_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'equipment_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'material_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'manpower_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantity' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'equipment_id' => ['type' => 'index', 'columns' => ['equipment_id'], 'length' => []],
            'material_id' => ['type' => 'index', 'columns' => ['material_id'], 'length' => []],
            'manpower_type_id' => ['type' => 'index', 'columns' => ['manpower_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'resource_request_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['equipment_id'], 'references' => ['equipment', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resource_request_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['material_id'], 'references' => ['materials', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resource_request_details_ibfk_3' => ['type' => 'foreign', 'columns' => ['manpower_type_id'], 'references' => ['manpower_types', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'resource_request_header_id' => 1,
            'equipment_id' => 1,
            'material_id' => 1,
            'manpower_type_id' => 1,
            'quantity' => 1,
            'created' => '2016-03-21 14:40:33',
            'modified' => '2016-03-21 14:40:33'
        ],
    ];
}
