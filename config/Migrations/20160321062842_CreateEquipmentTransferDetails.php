<?php
use Migrations\AbstractMigration;

class CreateEquipmentTransferDetails extends AbstractMigration
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
        $table = $this->table('equipment_transfer_details');
        $table->addColumn('resource_transfer_header_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('equipment_inventory_id', 'integer', [
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
            'equipment_inventory_id',
        ]);

        $table->addForeignKey('resource_transfer_header_id', 'resource_transfer_headers');
        $table->addForeignKey('equipment_inventory_id', 'equipment_inventories');
        $table->create();
    }
}
