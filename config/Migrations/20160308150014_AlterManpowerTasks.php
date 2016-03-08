<?php
use Migrations\AbstractMigration;

class AlterManpowerTasks extends AbstractMigration
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
        $table->dropForeignKey('manpower_id');
        $table->renameColumn('manpower_id', 'manpower_type_id');
        $this->execute("DELETE FROM manpower_tasks");
        $table->addForeignKey('manpower_type_id', 'manpower_types');
        $table->update();
    }
}
