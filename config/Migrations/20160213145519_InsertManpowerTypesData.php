<?php
use Migrations\AbstractMigration;

class InsertManpowerTypesData extends AbstractMigration
{
    public function up()
    {
        $now = (new DateTime('now'))->format('Y-m-d H:i:s');

        $table = $this->table('manpower_types');
        $table->insert([
            [
                'title' => 'Skilled Worker',
                'created' => $now,
                'modified' => $now
            ],
            [
                'title' => 'Laborer',
                'created' => $now,
                'modified' => $now
            ]
        ]);
        $table->saveData();
    }

    public function down()
    {
        $this->execute("DELETE FROM manpower_types WHERE title IN('Skilled Worker', 'Laborer')");
    }
}
