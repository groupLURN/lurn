<?php
use Migrations\AbstractMigration;

class AlterRentalRequestHeaders extends AbstractMigration
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
        $this->execute('ALTER TABLE rental_request_headers AUTO_INCREMENT = 1000000');
        $table = $this->table('rental_request_headers');
        $table->changeColumn('project_id', 'integer', [
            'null' => true,
            'default' => null,
            'limit' => 11
        ]);
        $table->update();
    }
}
