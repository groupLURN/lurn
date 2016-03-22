<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Create Resources Transfer') ?>
<div class="row mt">
    <div class="col-md-12">
    <?= $this->Form->create($resourceTransferHeader) ?>
    <fieldset>
        <legend><?= __('Create Resources Transfer') ?></legend>
        <?php
            echo $this->Form->input('resource_request_header_id', [
                'class' => 'form-control chosen',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Resources Request Number'
                ],
                'options' => [null => '-'] + $resourceRequestHeadersHash,
                'onchange' => sprintf("
                    if(!confirm('Are you sure you want to change resource request number? This will erase the details below.'))
                    {
                        event.preventDefault();
                        return;
                    }
                    $('#equipment-paned-multi-select').html('');
                    $.getJSON('%s' + '/' + $(this).val(),
                        function(response)
                        {
                            fillPane($('#equipment-paned-multi-select'),
                                $.map(response.resourceRequestHeader.equipment, function(object)
                                {
                                    return {
                                        id: object.id,
                                        name: object.name,
                                        quantity: object._joinData.quantity
                                    };
                                })
                            );
                        }
                    );
                ", $this->Url->build(['controller' => 'ResourceRequestHeaders', 'action' => 'view']))
            ]);


        echo $this->Form->input('from_project_id', [
            'class' => 'form-control chosen',
            'label' => [
                'text' => 'Transfer From',
                'class' => 'mt'
            ],
            'options' => [null => 'General']
        ]);

        echo $this->Form->input('to_project_id', [
            'class' => 'form-control chosen',
            'label' => [
                'text' => 'Transfer To',
                'class' => 'mt'
            ],
            'options' => $projects
        ]);

        ?>
    </fieldset>
    <div class="row mt">
        <div class="col-xs-6">
            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Equipment Requested') ?></h4></legend>
            <?= $this->element('paned_multi_select', [
                'id' => 'equipment-paned-multi-select'
            ]) ?>
        </div>
        <div class="col-xs-6">
            <legend><h4><i class="fa fa-angle-right"></i> <?= __('Assign Equipment Needed') ?></h4></legend>
            <?= $this->element('multi_select_with_input', [
                'options' => $equipment,
                'resource' => 'equipment'
            ]) ?>
        </div>
    </div>
    <?= $this->Form->button(__('Submit'), [
        'class' => 'btn btn-primary btn-submit'
    ]) ?>
    <?= $this->Form->end() ?>


    </div>
</div>
