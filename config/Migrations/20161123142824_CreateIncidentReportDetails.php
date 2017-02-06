<?php

use Phinx\Migration\AbstractMigration;

class CreateIncidentReportDetails extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('incident_report_details');
        $table->addColumn('incident_report_header_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('type', 'string', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('value', 'string', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('attribute', 'string', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addForeignKey('incident_report_header_id', 'incident_report_headers');
        $table->create();
    }
}
