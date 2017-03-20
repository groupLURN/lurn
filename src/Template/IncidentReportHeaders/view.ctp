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


<div class="row mt">
	<div class="col-md-12">

        <?= $this->Form->button('<i class="fa fa-save"></i> Save as PDF', 
            ['onclick' => "location.href='" 
            . $this->Url->build(['action' => 'generate-report', $incidentReport->id, '1.pdf', '?' => ['project_id' => $projectId]])
            . "'", 'class' => 'btn btn-primary']); ?>
        <?= $this->Form->button('<i class="fa fa-print"></i> Print', 
            ['onclick' => "location.href='" 
            . $this->Url->build(['action' => 'generate-report', $incidentReport->id, '0.pdf', '?' => ['project_id' => $projectId]])
            . "'", 'class' => 'btn btn-warning']); ?>
		<h4>Incident Report</h4>
		<h5 class="mt">Project Details</h5>
		<table class="vertical-table table table-striped incident-report">
			<tr>
				<th><?= __('Project Name') ?></th>
				<td><?= h($incidentReport->project->title) ?></td>
			</tr>
			<tr>
				<th><?= __('Project Location') ?></th>
				<td><?= $this->Text->autoParagraph(h($incidentReport->project->location)); ?></td>
			</tr>
			<tr>
				<th><?= __('Project Engineer') ?></th>
				<td><?= h($incidentReport->project_engineer->name) ?></td>
			</tr>
			<tr>
				<th><?= __('Date') ?></th>
				<td><?= date_format($incidentReport->date,"F d, Y") ?></td>
			</tr>
		</table>
		<h5 class="mt">Incident Details</h5>
		<table class="vertical-table table table-striped incident-report">
			<tr>
				<th><?= __('Type') ?></th>
				<td><?= h($incidentReport->type_full); ?></td>
			</tr>
			<tr>
				<th><?= __('Location') ?></th>
				<td><?= $this->Text->autoParagraph(h($incidentReport->location)); ?></td>
			</tr>
			<tr>
				<th><?= __('Task') ?></th>
				<td><?= h($incidentReport->task_title) ?></td>
			</tr>
			<tr>
				<th><?= __('Persons Involved') ?></th>
				<td>
				<?php 
					for($i=0; $i<count($incidentReport->persons_involved); $i++){
						$personInvolved = $incidentReport->persons_involved[$i];
						echo $personInvolved->name;

						if($i<count($incidentReport->persons_involved)-1){
							echo ', ';
						}

					}

				 ?>
					
				</td>
			</tr>
			<tr>
				<th><?= __('Summary of the Incident') ?></th>
				<td><?= $this->Text->autoParagraph(h($incidentReport->incident_summary)); ?></td>
			</tr>
		</table>

		<?php if($incidentReport->type == 'los'):?>
		<h5 class="mt">Lost Items/Materials</h5>
		<table class="vertical-table table table-striped incident-report">
			<tr>
				<th><?= __('Item') ?></th>
				<th><?= __('Quantity') ?></th>
			</tr>
			<?php foreach ($incidentReport->items_lost as $itemLost):?>
			<tr>
				<td><?= h($itemLost['name']); ?></td>	
				<td><?= h($itemLost['quantity']); ?></td>				
			</tr>
			<?php endforeach;?>
		</table>
		<?php else: ?>
        <h5 class="mt">Details of Injured Person/s</h5>

        <?php foreach ($incidentReport->persons_involved as $personInvolved):?>
        <table class="vertical-table table table-striped incident-report">
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($personInvolved['name']); ?></td>
            </tr>
            <tr>
                <th><?= __('Age') ?></th>
                <td><?= h($personInvolved['age']); ?></td>                  
            </tr>
            <tr>
                <th><?= __('Address') ?></th>
                <td><?= h($personInvolved['address']); ?></td>                  
            </tr>
            <tr>
                <th><?= __('Contact Number') ?></th>
                <td><?= h($personInvolved['contact']); ?></td>                  
            </tr>
            <tr>
                <th><?= __('Occupation') ?></th>
                <td><?= h($personInvolved['occupation']); ?></td>                  
            </tr>
            <tr>
                <th><?= __('Summary of Injury') ?></th>
                <td><?= $this->Text->autoParagraph(h($personInvolved['injured_summary'])); ?></td>               
            </tr>
        </table>
        <br>
        <?php endforeach;?>
		<?php endif;?>
	</div>
</div>