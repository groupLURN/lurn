<?php
use Migrations\AbstractMigration;

class AddAgeAddressContactToEmployee extends AbstractMigration
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
        $table = $this->table('employees');
		
        $table->addColumn('address', 'string', [
            'default' => null,
            'null' => true,
        ]);
		
        $table->addColumn('age', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
		
        $table->addColumn('contact_number', 'string', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
