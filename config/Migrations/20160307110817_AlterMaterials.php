<?php
use Migrations\AbstractMigration;

class AlterMaterials extends AbstractMigration
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
        $table = $this->table('materials');

        $table->addIndex([
            'name',
            'unit_measure'
        ], [
            'name' => 'BY_NAME_UNIT_MEASURE',
            'unique' => true,
        ]);

        $table->update();
    }
}
