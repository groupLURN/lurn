<?php
use Migrations\AbstractMigration;

class AlterUserTypes extends AbstractMigration
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
        $table = $this->table('user_types');
        $table->renameColumn('name', 'title');
        $table->update();
    }
}
