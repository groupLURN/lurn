<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipmentTaskInventoriesFixture
 *
 */
class EquipmentTaskInventoriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'equipment_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'project_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'task_id' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'quantity' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'project_id' => ['type' => 'index', 'columns' => ['project_id'], 'length' => []],
            'task_id' => ['type' => 'index', 'columns' => ['task_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['equipment_id', 'project_id', 'task_id'], 'length' => []],
            'equipment_task_inventories_ibfk_1' => ['type' => 'foreign', 'columns' => ['equipment_id'], 'references' => ['equipment', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'equipment_task_inventories_ibfk_2' => ['type' => 'foreign', 'columns' => ['project_id'], 'references' => ['projects', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'equipment_task_inventories_ibfk_3' => ['type' => 'foreign', 'columns' => ['task_id'], 'references' => ['tasks', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'equipment_id' => 1,
            'project_id' => 1,
            'task_id' => 'b8bce2c7-5fe3-4abd-90c0-f316a64f9645',
            'quantity' => 1,
            'created' => '2016-03-01 21:38:58',
            'modified' => '2016-03-01 21:38:58'
        ],
    ];
}
