<?php
use Migrations\AbstractMigration;

class AddAgeAddressContactToManpower extends AbstractMigration
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
        $table = $this->table('manpower');
		
        $table->addColumn('address', 'string', [
            'default' => null,
            'null' => true,
        ]);
		
        $table->addColumn('age', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
		
        $table->addColumn('contact-number', 'string', [
            'default' => null,
            'null' => true,
        ]);
		
        $table->update();
    }
}
