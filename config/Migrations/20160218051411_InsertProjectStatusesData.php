<?php
use Migrations\AbstractMigration;

class InsertProjectStatusesData extends AbstractMigration
{
    public function up()
    {
        $now = (new DateTime('now'))->format('Y-m-d H:i:s');

        $table = $this->table('project_statuses');

        $statuses = [
            'Bidding',
            'Ongoing',
            'On Hold',
            'Delayed',
            'Completed',
            'Closed'
        ];

        $rows = [];
        foreach($statuses as $status)
            $rows[] = [
                'title' => $status,
                'created' => $now,
                'modified' => $now
             ];

        $table->insert($rows);

        $table->saveData();
    }

    public function down()
    {
        $this->execute("DELETE FROM project_statuses");
    }
}
