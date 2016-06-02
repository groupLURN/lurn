<div class="dashboard view large-9 medium-8 columns content">
	<h3><?= h($project->title) ?></h3>
	    <table class="vertical-table table table-striped">
	        <tr>
	            <th><?= __('Title') ?></th>
	            <td><?= h($project->title) ?></td>
	        </tr>
	        <tr>
	            <th><?= __('Description') ?></th>
	            <td><?= $this->Text->autoParagraph(h($project->description)); ?></td>
	        </tr>
	        <tr>
	            <th><?= __('Location') ?></th>
	            <td><?= h($project->location) ?></td>
	        </tr>
	        <tr>
	            <th><?= __('Client') ?></th>
	            <td><?= $project->has('client') ? $this->Html->link($project->client->company_name, ['controller' => 'Clients', 'action' => 'view', $project->client->id]) : '' ?></td>
	        </tr>
	        <tr>
	            <th><?= __('Project Status') ?></th>
	            <td><?= h($project->status) ?></td>
	        </tr>
	        <tr>
	            <th><?= __('Project Manager') ?></th>
	            <td><?= $this->Html->link($project->employee->name, ['controller' => 'employees', 'action' => 'view', $project->employee->id]) ?></td>
	        </tr>
	        <tr>
	            <th><?= __('Start Date') ?></th>
	            <td><?= h($project->start_date) ?></td>
	        </tr>
	        <tr>
	            <th><?= __('End Date') ?></th>
	            <td><?= h($project->end_date) ?></td>
	        </tr>
	    </table>
</div>