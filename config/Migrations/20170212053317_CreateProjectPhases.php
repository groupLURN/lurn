<?php
use Migrations\AbstractMigration;

class CreateProjectPhases extends AbstractMigration
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
        $table = $this->table('project_phases');
        $table->addColumn('name', 'string', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
