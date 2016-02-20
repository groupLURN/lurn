<?php
use Migrations\AbstractMigration;

class CreateMilestones extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('milestones');
        $table->addColumn('project_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('start_date', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('end_date', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addForeignKey('project_id', 'projects');

        $table->addIndex([
            'title',
        ], [
            'name' => 'BY_TITLE',
            'unique' => false,
        ]);
        $table->addIndex([
            'start_date',
        ], [
            'name' => 'BY_START_DATE',
            'unique' => false,
        ]);
        $table->addIndex([
            'end_date',
        ], [
            'name' => 'BY_END_DATE',
            'unique' => false,
        ]);
        $table->create();
    }
}
