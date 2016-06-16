<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Projects Inventory Summary Report') ?>

<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <?= $this->Form->create('Search', ['type' => 'GET']) ?>
            <h4><i class="fa fa-angle-right"></i> Project Invetory Summary Report </h4>
            <hr>
            <table class="table">
                <tbody>
                 <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Report Type"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('equipment_type', [
                            'options' => ['0' => 'All'] + $equipmentTypes,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($equipment_type)? $equipment_type: 0,
                            'onchange' => sprintf("
                                $('#supplier-id-filter').prop('disabled', Number($(this).val()) !== %d);
                            ", array_flip($equipmentTypes))
                        ]); ?>
                    </td>
                </tr>              
                <tr>
                    <td style="padding-top: 15px; padding-left: 10px;">
                        <?= $this->Form->label("", "Project"); ?>
                    </td>
                    <td colspan="3">
                        <?= $this->Form->input('project_id', [
                            'options' => ['0' => 'All'] + $projects,
                            'class' => 'form-control',
                            'label' => false,
                            'val' => isset($project_id)? $project_id: 0
                        ]); ?>
                    </td>
                </tr>
               <tr>
                    <td colspan="4">
                        <div class="row mt">
						    <div class="col-xs-12" align="right">
						        <?= $this->newButton(__('Generate Reports'), ['action' => 'view']); ?>
						    </div>
						</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <?= $this->Form->end(); ?>
        </div><!-- --/content-panel ---->
    </div>
</div>

