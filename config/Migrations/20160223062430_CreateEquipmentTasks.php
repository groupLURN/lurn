<?php
use Migrations\AbstractMigration;

class CreateEquipmentTasks extends AbstractMigration
{

    public $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('equipment_tasks');
        $table->addColumn('equipment_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('task_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('quantity', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addPrimaryKey([
            'equipment_id',
            'task_id',
        ]);

        $table->addForeignKey('equipment_id', 'equipment');
        $table->addForeignKey('task_id', 'tasks');
        $table->create();
    }
}
