<?php
use Migrations\AbstractMigration;

class RemoveClientIdFromUsers extends AbstractMigration
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
        $table->dropForeignKey('client_id');
        $table->removeColumn('client_id');
        $table->update();
    }
}
