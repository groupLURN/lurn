<?php
use Migrations\AbstractMigration;

class CreateEmployees extends AbstractMigration
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
        $table->addColumn('employee_type_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('employment_date', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('termination_date', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addForeignKey('employee_type_id', 'employee_types');

        $table->addIndex([
            'name',
        ], [
            'name' => 'BY_NAME',
            'unique' => false,
        ]);
        $table->addIndex([
            'employment_date',
        ], [
            'name' => 'BY_EMPLOYMENT_DATE',
            'unique' => false,
        ]);
        $table->addIndex([
            'termination_date',
        ], [
            'name' => 'BY_TERMINATION_DATE',
            'unique' => false,
        ]);
        $table->create();
    }
}
