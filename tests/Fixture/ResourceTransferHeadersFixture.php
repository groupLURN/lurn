<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResourceTransferHeadersFixture
 *
 */
class ResourceTransferHeadersFixture extends TestFixture
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
        'from_project_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'to_project_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'received_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'resource_request_header_id' => ['type' => 'index', 'columns' => ['resource_request_header_id'], 'length' => []],
            'from_project_id' => ['type' => 'index', 'columns' => ['from_project_id'], 'length' => []],
            'to_project_id' => ['type' => 'index', 'columns' => ['to_project_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'resource_transfer_headers_ibfk_1' => ['type' => 'foreign', 'columns' => ['resource_request_header_id'], 'references' => ['resource_request_headers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resource_transfer_headers_ibfk_2' => ['type' => 'foreign', 'columns' => ['from_project_id'], 'references' => ['projects', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resource_transfer_headers_ibfk_3' => ['type' => 'foreign', 'columns' => ['to_project_id'], 'references' => ['projects', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'from_project_id' => 1,
            'to_project_id' => 1,
            'received_date' => '2016-03-21 22:00:03',
            'created' => '2016-03-21 22:00:03',
            'modified' => '2016-03-21 22:00:03'
        ],
    ];
}
