<?php
use Migrations\AbstractMigration;

class CreateMaterialTransferDetails extends AbstractMigration
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
        $table = $this->table('material_transfer_details');
        $table->addColumn('resource_transfer_header_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('material_id', 'integer', [
            'default' => null,
            'limit' => 11,
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
            'resource_transfer_header_id',
            'material_id',
        ]);

        $table->addForeignKey('resource_transfer_header_id', 'resource_transfer_headers');
        $table->addForeignKey('material_id', 'materials');

        $table->create();
    }
}
