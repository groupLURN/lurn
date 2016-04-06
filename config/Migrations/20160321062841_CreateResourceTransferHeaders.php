<?php
use Migrations\AbstractMigration;

class CreateResourceTransferHeaders extends AbstractMigration
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
        $table = $this->table('resource_transfer_headers');

        $table->addColumn('resource_request_header_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('from_project_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('to_project_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('received_date', 'datetime', [
            'default' => null,
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

        $table->addForeignKey('resource_request_header_id', 'resource_request_headers');
        $table->addForeignKey('from_project_id', 'projects');
        $table->addForeignKey('to_project_id', 'projects');
        $table->create();

        $this->execute('ALTER TABLE resource_request_headers AUTO_INCREMENT = 3000000');
    }
}
