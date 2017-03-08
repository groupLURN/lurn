<?= $this->assign('title', 'Incident Report') ?>

<h3>Project Details</h3>
<table class="table report text-left incident-report">
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

<br>
<h3>Incident Details</h3>
<table class="table report text-left incident-report">
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

<div class="page-break"></div>

<div class="header">
    <?= $this->Html->image('logo.jpg', array('fullBase' => true)) ?>
    <span>J.I. Espino Construction</span>
</div>

<hr>


<?php if($incidentReport->type == 'los'):?>
    <h3>Lost Items/Materials</h3>
    <table class="table report text-left incident-report">
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
    <h3>Details of Injured Person/s</h3>

    <?php foreach ($incidentReport->persons_involved as $personInvolved):?>
        <table class="table report text-left incident-report">
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