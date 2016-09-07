<?= $this->Flash->render() ?>
<div class="row mt">
	<div class="col-md-12">
		<?= $this->Form->create($project) ?>
		<fieldset>
			<legend><h3><i class="fa fa-angle-right"></i>Add Project</h3></legend>
			<?php

			echo $this->Form->input('title', [
				'class' => 'form-control',
				'label' => [
				'class' => 'mt'
				]
				]);

			echo $this->Form->input('description', [
				'class' => 'form-control',
				'label' =>  [
				'class' => 'mt'
				]           
				]);

			echo $this->Form->input('location', [
				'class' => 'form-control',
				'label' => [
				'class' => 'mt'
				]
				]);

			echo $this->Form->input('client_id', [
				'options' => $clients,
				'class' => 'form-control',
				'label' => [
				'class' => 'mt'
				]   
				]);

			echo $this->Form->input('start_date', [
				'type' => 'text',
				'class' => 'form-control datetime-picker',
				'label' => [
				'class' => 'mt'
				]
				]);

			echo $this->Form->input('end_date', [
				'type' => 'text',
				'class' => 'form-control datetime-picker',
				'label' => [
				'class' => 'mt'
				]
				]);

				?>

				<legend class="mt"><h3><i class="fa fa-angle-right"></i>Core Team Assignment</h3></legend>

				<?=
				$this->Form->input('employees_join._ids', [
					'type' => 'select',
					'data-placeholder' => 'Add Project Engineers',
					'multiple' => true,
					'options' => $projectEngineers,
					'class' => 'form-control chosen',
					'label' => [
					'text' => 'Project Engineers'
					]
					]);
					?>

				<br>

				<?=
				$this->Form->input('employees_join._ids', [
					'type' => 'select',
					'data-placeholder' => 'Add Warehouse Keepers',
					'multiple' => true,
					'options' => $warehouseKeepers,
					'class' => 'form-control chosen',
					'label' => [
					'text' => 'Warehouse Keepers'
					],
					'hiddenField' => false
					]);
					?>

			</fieldset>

						<?= $this->Form->button(__('Submit'), [
							'class' => 'btn btn-primary btn-submit'
							]) ?>
							<?= $this->Form->end() ?>

	</div>
</div>