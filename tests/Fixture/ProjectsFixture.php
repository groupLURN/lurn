<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProjectsFixture
 *
 */
class ProjectsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'client_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'project_manager_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'project_status_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'start_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'end_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'BY_TITLE' => ['type' => 'index', 'columns' => ['title'], 'length' => []],
            'BY_START_DATE' => ['type' => 'index', 'columns' => ['start_date'], 'length' => []],
            'BY_END_DATE' => ['type' => 'index', 'columns' => ['end_date'], 'length' => []],
            'client_id' => ['type' => 'index', 'columns' => ['client_id'], 'length' => []],
            'project_manager_id' => ['type' => 'index', 'columns' => ['project_manager_id'], 'length' => []],
            'project_status_id' => ['type' => 'index', 'columns' => ['project_status_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'projects_ibfk_1' => ['type' => 'foreign', 'columns' => ['client_id'], 'references' => ['clients', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'projects_ibfk_2' => ['type' => 'foreign', 'columns' => ['project_manager_id'], 'references' => ['employees', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'projects_ibfk_3' => ['type' => 'foreign', 'columns' => ['project_status_id'], 'references' => ['project_statuses', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'client_id' => 1,
            'project_manager_id' => 1,
            'project_status_id' => 1,
            'title' => 'Lorem ipsum dolor sit amet',
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'start_date' => '2016-02-18 17:35:50',
            'end_date' => '2016-02-18 17:35:50',
            'created' => '2016-02-18 17:35:50',
            'modified' => '2016-02-18 17:35:50'
        ],
    ];
}
