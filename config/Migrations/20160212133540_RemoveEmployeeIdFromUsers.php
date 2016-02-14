<?php
use Migrations\AbstractMigration;

class RemoveEmployeeIdFromUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->dropForeignKey('employee_id');
        $table->removeColumn('employee_id');
        $table->update();
    }
}
