<?php
use Migrations\AbstractMigration;

class CreateManpowerTasks extends AbstractMigration
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
        $table = $this->table('manpower_tasks');
        $table->addColumn('manpower_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('task_id', 'string', [
            'default' => null,
            'limit' => 255,
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
		
        $table->addForeignKey('manpower_id', 'manpower');
        $table->addForeignKey('task_id', 'tasks');

        $table->create();
    }
}
