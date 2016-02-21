<?php
use Migrations\AbstractMigration;

class ModifyDummyDataInUser extends AbstractMigration
{
    public function up()
    {
        $now = (new DateTime('now'))->format('Y-m-d H:i:s');

        // Set user_type_id of 'admin' User to Employee.
        $id = $this->fetchRow('SELECT id FROM user_types WHERE title = \'Employee\'')['id'];
        $this->execute("UPDATE users SET user_type_id = " . $id);

        // Delete admin dummy User Type.
        $this->execute('DELETE FROM user_types WHERE title = \'admin\'');

        // Create Employee 'Owner' Entry.
        $id = $this->fetchRow('SELECT id FROM employee_types WHERE title = \'Admin/Company Owner\'')['id'];

        $employeesTable = $this->table('employees');

        $employeesTable->insert([
            'employee_type_id' => $id,
            'name' => 'Owner',
            'employment_date' => $now,
            'termination_date' => null,
            'created' => $now,
            'modified' => $now
        ]);

        $employeesTable->saveData();

        // Update Users 'admin' foreign key to the new Employees entry.
        $id = $this->fetchRow('SELECT id FROM employees WHERE name = \'Owner\'')['id'];
        $this->execute('UPDATE users SET employee_id = ' . $id . ' WHERE username = \'admin\'');
    }

    public function down()
    {
        $now = new DateTime('now');

        $singleRow = [
            'title'    => 'admin',
            'created'  => $now->format('Y-m-d H:i:s'),
            'modified'  => $now->format('Y-m-d H:i:s')
        ];

        $table = $this->table('user_types');
        $table->insert($singleRow);
        $table->saveData();

        $this->execute("UPDATE users SET user_type_id = " .
            $this->fetchRow('SELECT id FROM user_types WHERE title = \'admin\'')['id'] .
        ', employee_id = NULL WHERE username = \'admin\'');

        $this->execute("DELETE FROM employees WHERE name = 'Owner'");
    }

}
