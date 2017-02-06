<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class IncidentReportComponent extends Component
{
	public $components = [];

	public function initialize(array $config)
	{
		$this->IncidentReportHeaders = TableRegistry::get('IncidentReportHeaders');
	}

	public function prepareIncidentReport($id)
	{	
		$personsInvolved	= [];
		$itemsLost			= [];

		$this->Employees 	= TableRegistry::get('Employees');
		$this->Manpower 	= TableRegistry::get('Manpower');
		$this->Tasks 		= TableRegistry::get('Tasks');

		$incidentReportHeader = $this->IncidentReportHeaders->get($id, [
			'contain' => ['Projects' => [
			'EmployeesJoin' => [
			'EmployeeTypes'
			]
			], 
			'IncidentReportDetails']
			]);

		foreach($incidentReportHeader->project->employees_join as $employee) {
			if($employee->employee_type->id == 3) {
				$incidentReportHeader['project_engineer'] = $employee;            
			}
		}

		for($i=0; $i < count($incidentReportHeader->incident_report_details); $i++) {
			$incidentReportDetail = $incidentReportHeader->incident_report_details[$i];
			if($incidentReportDetail->type == 'task') {
				$task = $this->Tasks->get($incidentReportDetail->value);
				if($task->id == $incidentReportDetail->value) {
					$incidentReportHeader->task = $task->title;
				}
			} else if($incidentReportDetail->type == 'incident_summary') {
				$incidentReportHeader->incident_summary = $incidentReportDetail->value;

			} else if($incidentReportDetail->type == 'location') {
				$incidentReportHeader->location = $incidentReportDetail->value;

			} else if($incidentReportDetail->type == 'item_lost') {
				$itemLost = ['name' => $incidentReportDetail->value, 'quantity' => $incidentReportDetail->attribute];
				array_push($itemsLost, $itemLost); 

			} else if($incidentReportDetail->type == 'persons_involved') {
				if(strpos($incidentReportDetail->value, 'Employee') !== false) {
					$occupation = preg_replace('/-[0-9]+/', '', $incidentReportDetail->value);
					$employeeId = str_replace('Employee-', '', $incidentReportDetail->value);
					$employee = $this->Employees->get($employeeId);
					$employee->occupation = $occupation;
					array_push($personsInvolved, $employee);
				} else {
					$occupation = preg_replace('/-[0-9]+/', '', $incidentReportDetail->value);
					$manpowerId = str_replace('Laborer-', '', $incidentReportDetail->value);
					$manpowerId = str_replace('Skilled Worker-', '', $manpowerId);
					$manpower = $this->Manpower->get($manpowerId);
					$manpower->occupation = $occupation;
					array_push($personsInvolved, $manpower);
				}
			}
		}

		$incidentReportHeader->items_lost		= $itemsLost;
		$incidentReportHeader->persons_involved = $personsInvolved;

		switch($incidentReportHeader->type) {
			case 'acc':
			case 'doc':
			case 'inj':

			break;
			case 'los':

			break;
		}

		switch($incidentReportHeader->type) {
			case 'acc':
			$incidentReportHeader->type_full = "Accident";
			break;
			case 'doc':
			$incidentReportHeader->type_full = "Dangerous Occurence";
			break;
			case 'inj':
			$incidentReportHeader->type_full = "Injury";
			break;
			case 'los':
			$incidentReportHeader->type_full = "Loss";
			break;
		}

		unset($incidentReportHeader->project['employees_join']);
		return $incidentReportHeader;
	}
}