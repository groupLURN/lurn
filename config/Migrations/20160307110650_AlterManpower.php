<?php
use Migrations\AbstractMigration;

class AlterManpower extends AbstractMigration
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

        $table->removeIndex('name');
        $table->addIndex([
            'name',
        ], [
            'name' => 'BY_NAME',
            'unique' => true,
        ]);
        $table->update();
    }
}
