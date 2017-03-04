<?= $this->Flash->render() ?>
<div class="row mt">
	<div class="col-md-12">
		<?= $this->Form->create($project, ['type' => 'file']) ?>
		<fieldset>
			<legend><h3><i class="fa fa-angle-right"></i>Add Project</h3></legend>
			<i class="red-text">* = Required</i>
			<?php

			echo $this->Form->input('title', [
				'class' => 'form-control',
				'label' => [
					'class' => 'mt',
       				'escape' => false,
					'text' => '<i class="red-text">*</i> Title'

				]
			]);

			echo $this->Form->input('description', [
				'class' => 'form-control',
				'label' => [
					'class' => 'mt',
       				'escape' => false,
					'text' => '<i class="red-text">*</i> Description'
				]           
			]);

			echo $this->Form->input('location', [
				'class' => 'form-control',
				'label' => [
					'class' => 'mt',
       				'escape' => false,
					'text' => '<i class="red-text">*</i> Location'
				]
			]);

			echo $this->Form->input('client_id', [
				'options' => $clients,
				'class' => 'form-control',
				'label' => [
					'class' => 'mt',
       				'escape' => false,
					'text' => '<i class="red-text">*</i> Client'
				]   
			]);

			echo $this->Form->input('start_date', [
				'type' => 'text',
				'class' => 'form-control datetime-picker',
				'label' => [
					'class' => 'mt',
       				'escape' => false,
					'text' => '<i class="red-text">*</i> Start Date'
				]
			]);

			echo $this->Form->input('end_date', [
				'type' => 'text',
				'class' => 'form-control datetime-picker',
				'label' => [
					'class' => 'mt',
       				'escape' => false,
					'text' => '<i class="red-text">*</i> End Date'
				]
			]);

				?>
			<h4 class="mt">Core Team Assignment</h4>

			<?php
				echo $this->Form->input('project-engineer', [
					'class' => 'form-control',
					'label' => [
	       				'escape' => false,
						'text' => '<i class="red-text">*</i> Project Engineer'
					],
					'options' => [''=>'-Add a Project Engineer-']+$projectEngineers
				]);

				echo $this->Form->input('warehouse-keeper', [
					'class' => 'form-control',
					'label' => [
						'class' => 'mt',
	       				'escape' => false,
						'text' => '<i class="red-text">*</i> Warehouse Keeper'
					],
					'options' => [''=>'-Add a Warehouse Keeper-']+$warehouseKeepers
				]);
			?>
			<h4 class="mt">Upload Files</h4>	
            <div id="files-added" >
                None.                
            </div>
            <button id="add-file" class="mt btn btn-default" type="button">Add File</button>
		</fieldset>

		<?= $this->Form->button(__('Submit'), [
			'class' => 'btn btn-primary btn-submit',
			]) ?>
		<?= $this->Form->end() ?>

	</div>
</div>