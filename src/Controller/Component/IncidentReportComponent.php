<?php
namespace App\Controller\Component;

use App\Utility\DatabaseConstants;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use DateTime;

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

		try{
			$incidentReportHeader = $this->IncidentReportHeaders->find('byId', ['id' => $id])->first();
		} catch(\Exception $e) {
			return DatabaseConstants::RECORDNOTFOUND;
		}

		foreach($incidentReportHeader->project->employees_join as $employee) {
			if($employee->employee_type->id == 3) {
				$incidentReportHeader['project_engineer'] = $employee;  
				break;          
			}
		}

		for($i=0; $i < count($incidentReportHeader->incident_report_details); $i++) {
			$incidentReportDetail = $incidentReportHeader->incident_report_details[$i];
			switch($incidentReportDetail->type) {
				case 'task':
				$task = $this->Tasks->get($incidentReportDetail->value);
				if($task->id == $incidentReportDetail->value) {
					$incidentReportHeader->task 		= $task->id;
					$incidentReportHeader->task_title 	= $task->title;
				}
				break;
			case 'incident_summary':
				$incidentReportHeader->incident_summary = $incidentReportDetail->value;
				break;
			case 'location':
				$incidentReportHeader->location = $incidentReportDetail->value;
				break;
			case 'item_lost':
				$itemLost = ['name' => $incidentReportDetail->value, 'quantity' => $incidentReportDetail->attribute];
				array_push($itemsLost, $itemLost); 
				break;
			case 'persons_involved':
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
				break;
			}
		}

		$incidentReportHeader->items_lost		= $itemsLost;
		$incidentReportHeader->persons_involved = $personsInvolved;

		$incidentReportHeader = $this->addProperType($incidentReportHeader);

		unset($incidentReportHeader->project['employees_join']);
		unset($incidentReportHeader['incident_report_details']);
		return $incidentReportHeader;
	}

	public function prepareIncidentReportDetailsSave($postData)
	{
		$this->IncidentReportDetails= TableRegistry::get('IncidentReportDetails');
		$incidentReportDetails = [];

		
        $dateNow = new DateTime();

        $taskDetail     = $this->IncidentReportDetails->newEntity();
        $taskDetail['type'] = 'task';
        $taskDetail['value'] = $postData['task'];
        $taskDetail['created'] = $dateNow;

        array_push($incidentReportDetails, $taskDetail);

        $summaryDetail  = $this->IncidentReportDetails->newEntity();
        $summaryDetail['type'] = 'incident_summary';
        $summaryDetail['value'] = $postData['incident-summary'];
        $summaryDetail['created'] = $dateNow;

        array_push($incidentReportDetails, $summaryDetail);

        $locationDetail  = $this->IncidentReportDetails->newEntity();
        $locationDetail['type'] = 'location';
        $locationDetail['value'] = $postData['location'];
        $locationDetail['created'] = $dateNow;

        array_push($incidentReportDetails, $locationDetail);

        $personsInvolved = isset($postData['involved-id']) ? array_values($postData['involved-id'])
        	: [];

        for($i = 0; $i < count($personsInvolved); $i++) {
            $incidentReportDetail = $this->IncidentReportDetails->newEntity();

            $incidentReportDetail['type'] = 'persons_involved';
            $incidentReportDetail['value'] = $personsInvolved[$i];
            $incidentReportDetail['created'] = $dateNow;

            array_push($incidentReportDetails, $incidentReportDetail);
        }

        if($postData['type'] === 'los') {
            $itemsLost      = array_values($postData['item-id']);
            $itemsQuantity  = array_values($postData['item-quantity']);
            for($i = 0; $i < count($itemsLost); $i++) {
                $incidentReportDetail = $this->IncidentReportDetails->newEntity();

                $incidentReportDetail['type'] = 'item_lost';
                $incidentReportDetail['value'] = $itemsLost[$i];
                $incidentReportDetail['attribute'] = $itemsQuantity[$i];
                $incidentReportDetail['created'] = $dateNow;

                array_push($incidentReportDetails, $incidentReportDetail);
            }
        } else {
            $injuredSummaries = isset($postData['injured-summary']) 
            	? array_values($postData['injured-summary']) : [];
            	
            for($i = 0; $i < count($injuredSummaries); $i++) {
                $incidentReportDetail = $this->IncidentReportDetails->newEntity();

                $incidentReportDetail['type'] = 'injured_summary';
                $incidentReportDetail['value'] = $injuredSummaries[$i];
                $incidentReportDetail['attribute'] = $personsInvolved[$i];
                $incidentReportDetail['created'] = $dateNow;

                array_push($incidentReportDetails, $incidentReportDetail);
            }
        }

		return $incidentReportDetails;
	}

	public function prepareIncidentReportsForList($incidentReportHeaders){
		$this->Employees 	= TableRegistry::get('Employees');
		foreach ($incidentReportHeaders as $incidentReportHeader) {
			$incidentReportHeader = $this->addProperType($incidentReportHeader);
			$incidentReportHeader->project_engineer = $this->Employees->get($incidentReportHeader->project_engineer);
		}

		return $incidentReportHeaders;

	}

	public function initializeProjectsList($id = null){
		$this->Projects 	= TableRegistry::get('Projects');

        $projects = [];

        $tempProjects = $this->Projects->find('all')
        ->where(['is_finished' => 0])
        ->contain(['EmployeesJoin' => [
            'EmployeeTypes'
            ]])
        ->toArray();

        foreach ($tempProjects as $tempProject) {
            $projectEngineer = null;

            foreach($tempProject->employees_join as $employee) {
                if($employee->employee_type->id == 3) {
                    $projectEgineer = $employee;            
                }
            }
            
            $project = [
            'text' => $tempProject->title,
            'value' => $tempProject->id,
            'data-project-engineer' => $projectEgineer->name,
            'data-location' => $tempProject->location
            ];

            if(isset($id) && $id == $tempProject->id) {
            	$project['selected'] = true;
            }

            array_push($projects, $project);
        }

        return $projects;
	}

	public function deleteIncidentReportDetails($incidentReportDetails) {
		$this->IncidentReportDetails= TableRegistry::get('IncidentReportDetails');

		$valid = true;

        foreach($incidentReportDetails as $incidentReportDetail) {
			if (!($this->IncidentReportDetails->delete($incidentReportDetail))) {
	            $valid = false;
	        }
        } 

        return $valid;
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