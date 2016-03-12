<?php
use Migrations\AbstractMigration;

class AlterRentalReceiveHeaders extends AbstractMigration
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
        $this->execute('ALTER TABLE rental_receive_headers AUTO_INCREMENT = 1000000');
    }
}
