<?php
use Migrations\AbstractMigration;

class AddRentalReceiveDetailIdToEquipmentInventory extends AbstractMigration
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
        $table = $this->table('equipment_inventories');
        $table->addColumn('rental_receive_detail_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
            'after' => 'equipment_id'
        ]);
        $table->addForeignKey('rental_receive_detail_id', 'rental_receive_details');
        $table->update();
    }
}
