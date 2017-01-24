
<?= $this->assign('title', 'Create Incident Report') ?>

<div class="row mt">
	<div class="col-md-12">
		<?= $this->Form->create($incidentReportHeader) ?>
		<fieldset>
			<legend><h3><i class="fa fa-angle-right"></i>Create Incident Report</h3></legend>
			<?php
				echo $this->Form->input('project', [
					'class' => 'form-control chosen',
					'label' => [
						'class' => 'mt'
					],
					'options' => [''=>'-Select A Project-']+$projects
				]);

				echo $this->Form->input('project-location', [
					'class' => 'form-control',
					'disabled' => true,
					'label' => [
						'text' => 'Project Location',    
						'class' => 'mt'
					],
					'type' => 'text'
				]);

				echo $this->Form->input('project-engineer', [
					'class' => 'form-control',
					'disabled' => true,
					'label' => [ 
						'class' => 'mt'
					],
					'type' => 'text'
				]);

				echo $this->Form->input('date', [
					'class' => 'form-control',
					'label' => [
						'text' => 'Date',    
						'class' => 'mt'
					],
					'type' => 'text'
				]);

				echo $this->Form->input('type', [
					'class' => 'form-control chosen',
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
			
			<legend class="mt"><h4></i>Incident Details</h4></legend>
			<?php                
				echo $this->Form->input('location', [
					'class' => 'form-control',
					'label' => [
						'text' => 'Location',                    
						'class' => 'mt'
					]
					]);
				echo $this->Form->input('task', [
					'class' => 'form-control chosen',
					'label' => [
						'class' => 'mt'
					],
					'options' => [''=>'-Select A Task-']
				]);


				echo $this->element('incident_report_involved_input', [
						'options' => null,
						'resource' => 'involved_person'
					]);
				/*
				
				echo $this->Form->input('involved-personnel', [
					'multiple' => true,
					'data-placeholder' => 'Add Persons Involved',
					'class' => 'form-control chosen',
					'label' => [
						'text' => 'Persons Involved',                    
						'class' => 'mt'
					],
					'options' => $projectMembers,
					'data-count' => count($projectMembers)
					]);
					*/
			?>

			<br>
		</fieldset>
		<?= $this->Form->button(__('Submit')) ?>
		<?= $this->Form->end() ?>
	</div>
</div>