<?php
use Migrations\AbstractMigration;

class AddUserIdToEmployees extends AbstractMigration
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
        $table = $this->table('employees');
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
            'after' => 'id'
        ]);
        $table->update();

        $id = $this->fetchRow("SELECT id FROM users WHERE username = 'admin'")['id'];

        $this->execute("UPDATE employees SET user_id = " . $id);

        $table->addForeignKey('user_id', 'users');
        $table->update();
    }
}
