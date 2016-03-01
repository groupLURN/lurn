<?php
use Migrations\AbstractMigration;

class AddTaskIdToManpower extends AbstractMigration
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
        $table = $this->table('manpower');
        $table->addColumn('task_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'after' => 'project_id'
        ]);
        $table->addForeignKey('task_id', 'tasks');
        $table->update();
    }
}
