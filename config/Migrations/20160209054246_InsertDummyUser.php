<?php
use Migrations\AbstractMigration;
use Cake\Auth\DefaultPasswordHasher;

class InsertDummyUser extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $now = new DateTime('now');

        $singleRow = [
            'name'    => 'admin',
            'created'  => $now->format('Y-m-d H:i:s'),
            'modified'  => $now->format('Y-m-d H:i:s')
        ];

        $table = $this->table('user_types');
        $table->insert($singleRow);
        $table->saveData();

        $hasher = new DefaultPasswordHasher();

        $singleRow = [
            'username'    => 'admin',
            'password' => $hasher->hash('admin'),
            'user_type' => $this->fetchRow('SELECT id FROM user_types')['id'],
            'created'  => $now->format('Y-m-d H:i:s'),
            'modified'  => $now->format('Y-m-d H:i:s')
        ];

        // this is a handy shortcut
        $table = $this->table('users');
        $table->insert($singleRow);
        $table->saveData();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM user_types WHERE name = \'admin\'');
        $this->execute('DELETE FROM users WHERE name = \'admin\'');
    }
}
