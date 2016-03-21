<?php
use Migrations\AbstractMigration;

class CreateManpowerTransferDetails extends AbstractMigration
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
        $table = $this->table('manpower_transfer_details');
        $table->addColumn('resource_transfer_header_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('manpower_id', 'integer', [
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
            'manpower_id',
        ]);
        $table->addForeignKey('resource_transfer_header_id', 'resource_transfer_headers');
        $table->addForeignKey('manpower_id', 'manpower');
        $table->create();
    }
}
