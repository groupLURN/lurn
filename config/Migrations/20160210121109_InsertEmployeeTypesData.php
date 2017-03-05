<?php
use Migrations\AbstractMigration;

class InsertEmployeeTypesData extends AbstractMigration
{
    private function finalizeData($employeeTypes)
    {
        $now = new DateTime('now');

        $commonFields = [
            'created'  => $now->format('Y-m-d H:i:s'),
            'modified'  => $now->format('Y-m-d H:i:s')
        ];

        $data = [];
        foreach($employeeTypes as $value)
        {
            $data[] = array_merge(['title' => $value], $commonFields);
        }

        return $data;
    }

    public function up()
    {
        $employeeTypes = [
            'System Administrator', 'Admin/Company Owner', 'Project Manager/Project Supervisor', 'Project Engineer', 'Warehouse Keeper',
            'Skilled Worker'];

        $table = $this->table('employee_types');
        $table->insert($this->finalizeData($employeeTypes));
        $table->saveData();
    }

    public function down()
    {
        $employeeTypes = [
            'System Administrator', 'Admin/Company Owner', 'Project Manager/Project Supervisor', 'Project Engineer', 'Warehouse Keeper',
            'Skilled Worker'];

        $this->execute(
            sprintf("DELETE FROM employee_types WHERE title IN(%s)", implode("," ,
                    array_map(function($value) {
                        return '\'' . $value . '\'';
                    }, $employeeTypes)))
        );
    }


}
