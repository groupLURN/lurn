<?php
use Migrations\AbstractMigration;

class AlterUsers extends AbstractMigration
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
        $table->renameColumn('user_type', 'user_type_id');
        $table->changeColumn('user_type_id', 'integer', [
            'after' => 'employee_id'
        ]);
        $table->update();
    }
}
