<?php
use Cake\Auth\DefaultPasswordHasher;
use Migrations\AbstractMigration;

class AddEmployeeIdToUsers extends AbstractMigration
{
    private function insertDummyUser()
    {
        $now = new DateTime('now');

        $hasher = new DefaultPasswordHasher();

        $singleRow = [
            'employee_id' => null,
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

    public function up()
    {
        $count = $this->execute('DELETE FROM users');

        $table = $this->table('users');
        $table->addColumn('employee_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
            'after' => 'id'
        ]);

        $table->addForeignKey('employee_id', 'employees');

        $table->update();

        $this->insertDummyUser();
    }

    public function down()
    {
        $table = $this->table('users');
        $table->dropForeignKey('employee_id');
        $table->removeColumn('employee_id');
        $table->update();
    }
}
