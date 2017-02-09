<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Edit Incident Report') ?>

<script id="incident-report-data" type="application/json">
	<?= $incidentReportHeader?>
</script>
<div class="row mt">
	<div class="col-md-12">
		<?= $this->Form->create($incidentReportHeader) ?>
		<fieldset>
			<h3><i class="fa fa-angle-right"></i>Edit Incident Report</h3>
			<?php
				echo $this->Form->input('project_id', [
					'class' => 'form-control chosen',
            		'data-old-project' => $incidentReportHeader->id,
					'label' => [
						'class' => 'mt',
						'text' => 'Project'
					],
					'options' => [''=>'-Select A Project-' , '1' => 'For Testing Purposes']+$projects
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
			
			<h4 class="mt"></i>Incident Details</h4>
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
		<?= $this->Form->button(__('Update')) ?>
		<?= $this->Form->end() ?>
	</div>
</div>