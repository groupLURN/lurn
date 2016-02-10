<?php
use Migrations\AbstractMigration;

class InsertUserTypesData extends AbstractMigration
{
    public function up()
    {
        $now = new DateTime('now');

        // inserting multiple rows
        $rows = [
            [
                'name'    => 'Employee',
                'created'  => $now->format('Y-m-d H:i:s'),
                'modified'  => $now->format('Y-m-d H:i:s')
            ],
            [
                'name'    => 'Client',
                'created'  => $now->format('Y-m-d H:i:s'),
                'modified'  => $now->format('Y-m-d H:i:s')
            ]
        ];

        $table = $this->table('user_types');
        $table->insert($rows);
        $table->saveData();
    }

    public function down()
    {
        $this->execute("DELETE FROM user_types WHERE name IN('Client', 'Employee')");
    }


}
