<?php
use Migrations\AbstractMigration;

class CreateReports extends AbstractMigration
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
        $table = $this->table('reports');
        $table->addColumn('reports_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('report_type', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
         $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);


        $table->create();

        
    }
}
