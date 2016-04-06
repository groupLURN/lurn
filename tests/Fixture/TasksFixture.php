<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TasksFixture
 *
 */
class TasksFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'milestone_id' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'is_finished' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'start_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'end_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'comments' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'BY_TITLE' => ['type' => 'index', 'columns' => ['title'], 'length' => []],
            'BY_IS_FINISHED' => ['type' => 'index', 'columns' => ['is_finished'], 'length' => []],
            'BY_START_DATE' => ['type' => 'index', 'columns' => ['start_date'], 'length' => []],
            'BY_END_DATE' => ['type' => 'index', 'columns' => ['end_date'], 'length' => []],
            'milestone_id' => ['type' => 'index', 'columns' => ['milestone_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tasks_ibfk_1' => ['type' => 'foreign', 'columns' => ['milestone_id'], 'references' => ['milestones', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'id' => '3ba98fc1-e334-409f-a793-a6842a3e6c60',
            'milestone_id' => 'Lorem ipsum dolor sit amet',
            'title' => 'Lorem ipsum dolor sit amet',
            'is_finished' => 1,
            'start_date' => '2016-03-28 00:00:25',
            'end_date' => '2016-03-28 00:00:25',
            'created' => '2016-03-28 00:00:25',
            'modified' => '2016-03-28 00:00:25',
            'comments' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
