<?php
use Migrations\AbstractMigration;

class AddProjectIdToManpower extends AbstractMigration
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
        $table = $this->table('manpower');
        $table->addColumn('project_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
            'after' => 'id'
        ]);
        $table->addForeignKey('project_id', 'projects');
        $table->update();
    }
}
