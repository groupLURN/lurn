<?php
use Migrations\AbstractMigration;

class AlterResourceTransferHeaders extends AbstractMigration
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
        $table->removeColumn('received_date');
        $table->update();
        $this->execute('ALTER TABLE resource_transfer_headers AUTO_INCREMENT = 3000000');
    }
}
