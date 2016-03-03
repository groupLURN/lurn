<?php
use Migrations\AbstractMigration;

class RemoveBiddingDataFromProjectStatuses extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $biddingId = $this->fetchRow("SELECT id FROM project_statuses WHERE title = 'Bidding'")['id'];
        $ongoingId = $this->fetchRow("SELECT id FROM project_statuses WHERE title = 'Ongoing'")['id'];

        $this->execute("UPDATE projects SET project_status_id = $ongoingId WHERE project_status_id = $biddingId");
        $this->execute("DELETE FROM project_statuses WHERE id = $biddingId");
    }

    public function down()
    {
        $now = (new DateTime('now'))->format('Y-m-d H:i:s');

        $table = $this->table('project_statuses');

        $row = [
            'title' => 'Bidding',
            'created' => $now,
            'modified' => $now
        ];

        $table->insert($row);
        $table->saveData();

    }
}
