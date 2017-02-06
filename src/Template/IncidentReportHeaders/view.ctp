<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Incident Report') ?>

<div class="row mt">
	<div class="col-md-12">
		<?= $this->Html->image('logo.jpg', array('class' => 'float-right')) ?>
		<h5>
			Incident Report<br>
			J.I. Espino Construction
		</h5>
		<br>
		<br>
		<br>

		<label class="mt">Project Details</label>
		<table class="vertical-table table table-striped">
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
		<label class="mt">Incident Details</label>
		<table class="vertical-table table table-striped">
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
				<td><?= h($incidentReport->task) ?></td>
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
		<label class="mt">Lost Items/Materials</label>
		<table class="vertical-table table table-striped">
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

		<label class="mt">Incident Details</label>
		<table class="vertical-table table table-striped">
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
				<td><?= h($incidentReport->task) ?></td>
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
		<?php endif;?>
	</div>
</div>