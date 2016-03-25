<?php
use Migrations\AbstractMigration;

class RemoveProjectStatusIdFromProjects extends AbstractMigration
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
        $table = $this->table('projects');
        $table->dropForeignKey('project_status_id');
        $table->removeColumn('project_status_id');
        $table->update();
    }
}
