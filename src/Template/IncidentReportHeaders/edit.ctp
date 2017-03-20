<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Incident Reports') ?>

<!-- start of tabs -->
<div class="row mt">
    <div class="col-xs-12">
        <h3>
            <!--
                <span id="project-status-badge" class="
                    <?= $project->status !== 'Delayed' ? 'hidden' : '' ?>
                ">
                    <?= $project->status === 'Delayed' ? '!' : '' ?>
                </span>
            -->
            <?= h($project->title) ?>        
        </h3>
        <ul class="nav nav-tabs mt">
            <li>
                <a href=<?= $this->Url->build(['controller' => 'ProjectOverview', $projectId])?>>
                    <i class="fa fa-book"></i>
                    <span>Project Overview</span>
                </a>      
            </li>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'events', 'action' => 'project-calendar', $projectId])?>>
                    <i class="fa fa-calendar"></i>
                    <span>Events Calendar</span>
                </a>
            </li>
            <?php 
                if (in_array($employeeType, [0, 1, 2, 3], true)) {
            ?>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'ProjectPlanning', 'action' => 'CreateGanttChart', $projectId])?>>
                    <i class="fa fa-building"></i>
                    <span>Project Planning</span>
                </a>
            </li>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'manage', '?' => ['project_id' => $projectId]]) ?>>
                    <i class="fa fa-recycle"></i>
                    <span>Project Implementation</span>
                </a>
            </li>
            <?php 
                }

                if ($employeeType !== '') {
            ?>
            <li>
                <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventories', 'action' => 'index', 'action' => '/', $projectId]) ?>>
                    <i class="fa fa-database"></i>
                    <span>Project Inventories</span>
                </a>
            <?php
                }

                if (in_array($employeeType, [0, 1, 2, 4], true)) {
            ?>
            <li class="active">
                <a href=<?= $this->Url->build(['controller' => 'IncidentReportHeaders', 'action' => 'index', '?' => ['project_id' => $projectId]]) ?>>
                    <i class="fa fa-file"></i>
                    <span>Reports</span>
                </a>
            </li>
            <?php 
                }
            ?>
        </ul>
    </div>
    <div class="col-xs-12 mt">
        <!-- start of sub tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href=<?= $this->Url->build(['controller' => 'IncidentReportHeaders', 'action' => 'index', '?' => ['project_id' => $projectId]]) ?>>
                        <span>
                        Incident Reports
                        </span>
                    </a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'EquipmentProjectInventoryReport', 'action' => 'index', $projectId]) ?>>
                        <span>
                        Equipment Inventory Report
                        </span>
                    </a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'MaterialsProjectInventoryReport', 'action' => 'index', $projectId]) ?>>
                        <span>
                        Materials Inventory Report
                        </span>
                    </a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'ManpowerProjectInventoryReport', 'action' => 'index', $projectId]) ?>>
                        <span>
                        Manpower Inventory Report
                        </span>
                    </a>
                </li>
                <?php 
                    if ($isFinished == 1) {
                ?>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'SummaryReport', 'action' => 'index', $projectId]) ?>>
                            <span>
                            Summary Report
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'EquipmentSummaryReport', 'action' => 'index', $projectId]) ?>>
                            <span>
                            Equipment Summary Report
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'MaterialsSummaryReport', 'action' => 'index', $projectId]) ?>>
                            <span>
                            Materials Summary Report
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'ManpowerSummaryReport', 'action' => 'index', $projectId]) ?>>
                            <span>
                            Manpower Summary Report
                            </span>
                        </a>
                    </li>
                <?php 
                    }
                ?>
                </ul>
        <!-- end of sub tabs -->
    </div>
</div>
<!-- end of tabs -->

<script id="incident-report-data" type="application/json">
	<?= $incidentReportHeader?>
</script>
<div class="row">
	<div class="col-md-12">
		<?= $this->Form->create($incidentReportHeader) ?>
		<fieldset>
			<h3>Edit Incident Report</h3>
			<?php
				echo $this->Form->input('project_id', [
					'class' => 'form-control chosen',
            		'data-old-project' => $incidentReportHeader->id,
					'label' => [
						'class' => 'mt',
						'text' => 'Project'
					],
					'default' => $projectId,
					'options' => [''=>'-Select A Project-']+$projects
				]);

				echo $this->Form->input('project-location', [
					'class' => 'form-control',
					'readonly' => true,
					'label' => [
						'text' => 'Project Location',    
						'class' => 'mt'
					],
					'type' => 'text'
				]);

				echo $this->Form->input('project-engineer', [
					'class' => 'form-control',
					'readonly' => true,
					'label' => [ 
						'class' => 'mt'
					],
					'type' => 'text'
				]);

				echo $this->Form->input('date', [
					'class' => 'form-control datetime-picker',
					'label' => [
						'text' => 'Date',    
						'class' => 'mt'
					],
					'type' => 'text'
				]);

				echo $this->Form->input('type', [
					'class' => 'form-control chosen',
            		'data-old-type' => $incidentReportHeader->type,
					'label' => [
						'class' => 'mt'
					],
					'options' => [''=>'-Select an Incident Type-', 
								'acc'=>'Accident', 
								'doc'=>'Dangerous Occurrence', 
								'inj'=>'Injury', 
								'los'=>'Loss']
				]);

			?>
			
			<h4 class="mt">Incident Details</h4>
			<?php         
				echo $this->Form->input('location', [
					'class' => 'form-control',	
					'label' => [
						'class' => 'mt'
					]
				]);       
				echo $this->Form->input('task', [
					'class' => 'form-control chosen',	
            		'data-old-task' => $incidentReportHeader->task,
					'label' => [
						'class' => 'mt'
					],
					'options' => [''=>'-Select A Task-']
				]);

		        echo $this->Form->input('incident-summary', [
		            'class' => 'form-control',
		            'label' => [
		                'class' => 'mt',
		                'text' => 'Summary of the incident and/or injury caused by the incident (parts of the body and severity)'
		            ],
		            'type' => 'textarea'
		        ]);

				echo $this->element('incident_report_involved_input', ['action' => 'edit']);

			?>

			<br>
		</fieldset>
		<?= $this->Form->button(__('Update'), [
			'class' => 'btn btn-primary btn-submit'
			]) ?>
		<?= $this->Form->end() ?>
	</div>
</div>