<?php
use Migrations\AbstractMigration;

class InsertProjectPhasesData extends AbstractMigration
{
    public function up()
    {

        $table = $this->table('project_phases');
        $table->insert([
            [
                'name' => 'Planning'
            ],
            [
                'name' => 'Implementation'
            ],
            [
                'name' => 'Monitoring'
            ],
            [
                'name' => 'Closing '
            ]
        ]);
        $table->saveData();
    }

    public function down()
    {
    }
}
