<?php
use Migrations\AbstractMigration;

class AlterTasksAndMilestones extends AbstractMigration
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
        $table = $this->table('tasks');
        $table->dropForeignKey('milestone_id');
        $table->changeColumn('id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->changeColumn('milestone_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $this->changeMilestones();
        $table->addForeignKey('milestone_id', 'milestones');
        $table->update();
    }

    public function changeMilestones()
    {
        $table = $this->table('milestones');
        $table->changeColumn('id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->update();
    }
}
