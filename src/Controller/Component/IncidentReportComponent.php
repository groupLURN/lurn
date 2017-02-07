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

	public function prepareIncidentReportView($id)
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
					$employee->injured_summary = $this->getInjuredSummary($incidentReportDetail->value, 
						$incidentReportHeader->incident_report_details);
					array_push($personsInvolved, $employee);
				} else {
					$occupation = preg_replace('/-[0-9]+/', '', $incidentReportDetail->value);
					$manpowerId = str_replace('Laborer-', '', $incidentReportDetail->value);
					$manpowerId = str_replace('Skilled Worker-', '', $manpowerId);
					$manpower = $this->Manpower->get($manpowerId);
					$manpower->occupation = $occupation;
					$manpower->injured_summary = $this->getInjuredSummary($incidentReportDetail->value, 
						$incidentReportHeader->incident_report_details);
					array_push($personsInvolved, $manpower);
				}
			}
		}

		$incidentReportHeader->items_lost		= $itemsLost;
		$incidentReportHeader->persons_involved = $personsInvolved;

		$incidentReportHeader = $this->addProperType($incidentReportHeader);

		unset($incidentReportHeader->project['employees_join']);
		return $incidentReportHeader;
	}

	public function prepareIncidentReportDetailsSave($incidentReportHeader, $postData){
		$incidentReportDetails = [];
		
        $dateNow = new DateTime();

        $taskDetail     = $this->IncidentReportDetails->newEntity();
        $taskDetail['incident_report_header_id'] = $incidentReportHeader->id;
        $taskDetail['type'] = 'task';
        $taskDetail['value'] = $postData['task'];
        $taskDetail['created'] = $dateNow;

        array_push($incidentReportDetails, $taskDetail);

        $summaryDetail  = $this->IncidentReportDetails->newEntity();
        $summaryDetail['incident_report_header_id'] = $incidentReportHeader->id;
        $summaryDetail['type'] = 'incident_summary';
        $summaryDetail['value'] = $postData['involved-summary'];
        $summaryDetail['created'] = $dateNow;

        array_push($incidentReportDetails, $summaryDetail);

        $locationDetail  = $this->IncidentReportDetails->newEntity();
        $locationDetail['incident_report_header_id'] = $incidentReportHeader->id;
        $locationDetail['type'] = 'incident_summary';
        $locationDetail['value'] = $postData['location'];
        $locationDetail['created'] = $dateNow;

        array_push($incidentReportDetails, $locationDetail);

        $personsInvolved = $postData['involved-id'];

        for($i = 0; $i < count($personsInvolved); $i++) {
            $incidentReportDetail = $this->IncidentReportDetails->newEntity();

            $incidentReportDetail['incident_report_header_id'] = $incidentReportHeader->id;
            $incidentReportDetail['type'] = 'persons_involved';
            $incidentReportDetail['value'] = $personsInvolved[$i];
            $incidentReportDetail['created'] = $dateNow;

            array_push($incidentReportDetails, $incidentReportDetail);
        }

        if($incidentReportHeader->type === 'los') {
            $itemsLost      = $postData['item-id'];
            $itemsQuantity  = $postData['item-quantity'];
            for($i = 0; $i < count($itemsLost); $i++) {
                $incidentReportDetail = $this->IncidentReportDetails->newEntity();

                $incidentReportDetail['incident_report_header_id'] = $incidentReportHeader->id;
                $incidentReportDetail['type'] = 'item_lost';
                $incidentReportDetail['value'] = $itemsLost[$i];
                $incidentReportDetail['attribute'] = $itemsQuantity[$i];
                $incidentReportDetail['created'] = $dateNow;

                array_push($incidentReportDetails, $incidentReportDetail);
            }
        } else {
            $injuredSummaries = $postData['injured-summary'];
            for($i = 0; $i < count($injuredSummaries); $i++) {
                $incidentReportDetail = $this->IncidentReportDetails->newEntity();

                $incidentReportDetail['incident_report_header_id'] = $incidentReportHeader->id;
                $incidentReportDetail['type'] = 'injured_summary';
                $incidentReportDetail['value'] = $injuredSummaries[$i];
                $incidentReportDetail['attribute'] = $personsInvolved[$i];
                $incidentReportDetail['created'] = $dateNow;

                array_push($incidentReportDetails, $incidentReportDetail);
            }
        }

		return $incidentReportDetails;
	}

	public function prepeareIncidentReportsForList($incidentReportHeaders){
		foreach ($incidentReportHeaders as $incidentReportHeader) {
			$incidentReportHeader = $this->addProperType($incidentReportHeader);
		}

		return $incidentReportHeaders;

	}

	private function addProperType($incidentReportHeader){
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

		return $incidentReportHeader;
	}

	private function getInjuredSummary($attribute, $incidentReportDetails){
		if(!isset($incidentReportDetails)){				
			return '';
		}

		foreach ($incidentReportDetails as $incidentReportDetail) {
			if($incidentReportDetail->type == 'injured_summary' 
				&& $incidentReportDetail->attribute == $attribute) {
				return $incidentReportDetail->value;
			} 
		}

		return '';
	}
}