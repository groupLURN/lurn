<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ManpowerFixture
 *
 */
class ManpowerFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'manpower';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'project_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'manpower_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'task_id' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'BY_NAME' => ['type' => 'index', 'columns' => ['name'], 'length' => []],
            'manpower_type_id' => ['type' => 'index', 'columns' => ['manpower_type_id'], 'length' => []],
            'project_id' => ['type' => 'index', 'columns' => ['project_id'], 'length' => []],
            'task_id' => ['type' => 'index', 'columns' => ['task_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'manpower_ibfk_1' => ['type' => 'foreign', 'columns' => ['manpower_type_id'], 'references' => ['manpower_types', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'manpower_ibfk_2' => ['type' => 'foreign', 'columns' => ['project_id'], 'references' => ['projects', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'manpower_ibfk_3' => ['type' => 'foreign', 'columns' => ['task_id'], 'references' => ['tasks', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'project_id' => 1,
            'manpower_type_id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'created' => '2016-03-01 15:32:01',
            'modified' => '2016-03-01 15:32:01',
            'task_id' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
