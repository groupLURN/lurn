<?php
use Migrations\AbstractMigration;

class AddClientIdToUsers extends AbstractMigration
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
        $table->addColumn('client_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
            'after' => 'id'
        ]);
        $table->addForeignKey('client_id', 'clients');
        $table->update();
    }
}
