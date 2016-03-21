<?php
use Migrations\AbstractMigration;

class CreateManpowerTransferDetails extends AbstractMigration
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
        $table = $this->table('manpower_transfer_details');
        $table->addColumn('resource_transfer_header_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('resource_request_detail_id', 'integer', [
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
        $table->addForeignKey('resource_transfer_header_id', 'resource_transfer_headers');
        $table->addForeignKey('resource_request_detail_id', 'resource_request_details');
        $table->addForeignKey('manpower_id', 'manpower');
        $table->create();
    }
}
